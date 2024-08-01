<?php

declare(strict_types=1);

$includedFile = 'a_file_that_does_not_exist.php';

include $includedFile;
include_once $includedFile;
require $includedFile;
require_once $includedFile;
