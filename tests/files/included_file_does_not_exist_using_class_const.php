<?php

declare(strict_types=1);

use Tests\ClassThatContainsConst;

include __DIR__ . '/' . ClassThatContainsConst::FILE_DOES_NOT_EXIST;
include_once __DIR__ . '/' . ClassThatContainsConst::FILE_DOES_NOT_EXIST;
require __DIR__ . '/' . ClassThatContainsConst::FILE_DOES_NOT_EXIST;
require_once __DIR__ . '/' . ClassThatContainsConst::FILE_DOES_NOT_EXIST;
