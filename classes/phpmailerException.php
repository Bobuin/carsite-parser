<?php

/**
 * PHPMailer exception handler
 * @package PHPMailer
 */

namespace classes;

class phpmailerException extends \Exception
{
    /**
     * Prettify error message output
     * @return string
     */
    public function errorMessage()
    {
        return '<strong>' . $this->getMessage() . "</strong><br />\n";
    }
}
