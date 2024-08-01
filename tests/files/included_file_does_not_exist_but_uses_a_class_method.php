<?php

declare(strict_types=1);

use Tests\ClassThatContainsMethod;

include __DIR__ . '/' . (new ClassThatContainsMethod())->getFileThatDoesNotExist();
include_once __DIR__ . '/' . (new ClassThatContainsMethod())->getFileThatDoesNotExist();
require __DIR__ . '/' . (new ClassThatContainsMethod())->getFileThatDoesNotExist();
require_once __DIR__ . '/' . (new ClassThatContainsMethod())->getFileThatDoesNotExist();
