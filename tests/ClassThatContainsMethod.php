<?php

declare(strict_types=1);

namespace Tests;

class ClassThatContainsMethod
{
    public function getFileThatDoesNotExist(): string
    {
        return 'a_file_that_does_not_exist.txt';
    }
}
