<?php

namespace classes;

class PageParser
{

    /**
     *
     * @param string $url URL of page to parse
     * @param string $script Name of JS file for PhantomJS
     *
     * @return string
     */
    public static function parsePage($url, $script)
    {
        $params   = [
            PHANTOM_BIN,
            SCRIPTS_PATH . $script,
            escapeshellarg($url),
        ];
        $response = shell_exec(implode(' ', $params));
        return trim($response);
    }

}
