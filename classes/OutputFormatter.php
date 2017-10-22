<?php

namespace classes;

abstract class OutputFormatter
{

    abstract public function formatedOutput($input);

    abstract public function fileOutput($fileName, $data, $delimiter);
}
