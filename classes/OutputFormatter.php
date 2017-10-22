<?php

namespace classes;

abstract class OutputFormatter
{

    abstract public function formattedOutput($input);

    abstract public function fileOutput($fileName, $data, $delimiter);
}
