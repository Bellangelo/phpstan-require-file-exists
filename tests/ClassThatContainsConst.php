<?php

declare(strict_types=1);

namespace Tests;

class ClassThatContainsConst
{
    public const FILE_EXISTS = 'include_me_to_prove_you_work.txt';
    public const FILE_DOES_NOT_EXIST = 'a_file_that_does_not_exist.php';
}