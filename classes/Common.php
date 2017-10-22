<?php

namespace classes;

class Common
{

    /**
     * Main function for grabbing product pages URLs to file
     *
     * @param string $url
     */
    public static function parseProductLinks($url)
    {
        $productsLinks = PageParser::parsePage($url, 'products-links.js');
        file_put_contents(DATA_PATH . 'links.txt', $productsLinks);
    }

    /**
     * Main function for parsing product info from pages.
     * URLs are read from file
     * @throws \classes\phpmailerException
     */
    public static function parseProductsInfo()
    {
        $startTime = time();
        $handle    = @fopen(DATA_PATH . 'links.txt', 'r');
        if ($handle) {
            $i      = 0;
            $result = [];
            while (($buffer = fgets($handle, 4096)) !== false) {
                if ($i > 3 && TEST) {
                    break;
                }
                $result[] = self::prepareProductLine($buffer);
                $i++;
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);

            if (count($result) > 0) {
                $csv = new CsvFormatter();
                $csv->fileOutput('products.csv', $result, '|');
            }
        }
        $stopTime = time();
        if (file_exists(DATA_PATH . 'products.csv')) {
            self::sendMail($startTime, $stopTime);
        }
    }

    /**
     * Getting product Info from page & format review date
     *
     * @param string $buffer URL of page to parse
     *
     * @return array
     */
    public static function prepareProductLine($buffer)
    {
        $productPage = PageParser::parsePage($buffer, 'products-page.js');
        $productInfo = explode('||', $productPage);
        if (!empty($productInfo[4])) {
            $productInfo[4] = date('d-m-Y', strtotime($productInfo[4]));
        }
        return $productInfo;
    }

    /**
     * Mailing parsing result
     *
     * @param string $startTime Script starting work time
     * @param string $stopTime Script finished work time
     *
     * @throws \classes\phpmailerException
     */
    public static function sendMail($startTime, $stopTime)
    {
        $mail = new PHPMailer;
        $mail->setFrom('from@example.com', 'Parsing Script');
        $mail->addAddress(EMAIL_TO, 'John Doe');
        $mail->Subject = 'CARiD suspension systems | ' . date('Y-m-d H:i:s');
        $mail->Body    = 'Script start time: ' . date('Y-m-d H:i:s', $startTime) . "\n"
            . 'Script stop time: ' . date('Y-m-d H:i:s', $stopTime);
        $mail->addAttachment(DATA_PATH . 'products.csv');

        /* SMTP Options */
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->Host       = SMTP_HOST;
        $mail->Username   = EMAIL_FROM;
        $mail->Password   = SMTP_PASS;
        /* End SMTP */

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
    }

}
