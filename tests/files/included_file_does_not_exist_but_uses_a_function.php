<?php

declare(strict_types=1);

// phpcs:disable
function getFileThatDoesNotExist(): string
{
    return 'a_file_that_does_not_exist.txt';
}

// phpcs:enable
include __DIR__ . '/' . getFileThatDoesNotExist();
include_once __DIR__ . '/' . getFileThatDoesNotExist();
require __DIR__ . '/' . getFileThatDoesNotExist();
require_once __DIR__ . '/' . getFileThatDoesNotExist();
