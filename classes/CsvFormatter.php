<?php

namespace classes;

use classes\OutputFormatter;

class CsvFormatter extends OutputFormatter
{

    /**
     * 
     * @param array $input
     * @return array
     */
    public function formatedOutput($input)
    {
        foreach ($input as &$dataLines) {
            implode('|', $dataLines);
        }
        return $input;
    }

    /**
     * 
     * @param resource $fileName File handler to save
     * @param array $data Data to save
     * @param string $delimiter CSV fields delimiter 
     * @return boolean
     */
    public function fileOutput($fileName, $data, $delimiter)
    {
        $fp = fopen(DATA_PATH . $fileName, 'w');
        foreach ($this->formatedOutput($data) as $dataLines) {
            $saveLine = fputcsv($fp, $dataLines, $delimiter);
            if ($saveLine === false) {
                fclose($fp);
                return false;
            }
        }
        fclose($fp);
        return true;
    }

}
