<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testHappyPath(): void
    {
        $expectedTotalErrors = 16;
        $expectedErrorsPerFile = [
            'file_exists_but_path_is_relative.php' => [
                'errors' => 4,
                'lines' => [5, 6, 7, 8]
            ],
            'included_file_does_not_exist.php' => [
                'errors' => 4,
                'lines' => [5, 6, 7, 8]
            ],
            'included_file_does_not_exist_using_class_const.php' => [
                'errors' => 4,
                'lines' => [7, 8, 9, 10]
            ],
            'included_file_does_not_exist_using_const.php' => [
                'errors' => 4,
                'lines' => [5, 6, 7, 8]
            ],
        ];
        $errorStartsWith = 'Included or required file "';
        $errorEndsWith = '" does not exist.';

        $output = [];
        exec('php vendor/bin/phpstan analyse -c tests/phpstan-testing.neon --error-format=json', $output);

        $jsonOutput = json_decode(implode(' ', $output), true, 10, JSON_THROW_ON_ERROR);

        $this->assertSame($expectedTotalErrors, $jsonOutput['totals']['file_errors']);
        $this->assertCount(count($expectedErrorsPerFile), $jsonOutput['files']);

        foreach ($jsonOutput['files'] as $filename => $errors) {
            $basename = basename($filename);

            $this->assertArrayHasKey($basename, $expectedErrorsPerFile);

            $expectedError = $expectedErrorsPerFile[$basename];
            $this->assertSame($expectedError['errors'], $errors['errors']);

            foreach ($errors['messages'] as $index => $error) {
                $this->assertStringStartsWith($errorStartsWith, $error['message']);
                $this->assertStringEndsWith($errorEndsWith, $error['message']);

                $this->assertSame($expectedError['lines'][$index], $error['line']);
            }
        }
    }
}
