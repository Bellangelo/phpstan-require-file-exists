<?php

declare(strict_types=1);

use Tests\ClassThatContainsConst;

include __DIR__ . '/' . ClassThatContainsConst::FILE_EXISTS;
include_once __DIR__ . '/' . ClassThatContainsConst::FILE_EXISTS;
require __DIR__ . '/' . ClassThatContainsConst::FILE_EXISTS;
require_once __DIR__ . '/' . ClassThatContainsConst::FILE_EXISTS;
