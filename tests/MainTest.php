<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testHappyPath(): void
    {
        $expectedTotalErrors = 4;
        $expectedErrorsPerFile = [
            'included_file_does_not_exist.php' => [
                'errors' => 4,
                'messages' => [
                    [
                        'message' => 'Included or required file "a_file_that_does_not_exist.php" does not exist.',
                        'line' => 5,
                        'ignorable' => true
                    ],
                    [
                        'message' => 'Included or required file "a_file_that_does_not_exist_once.php" does not exist.',
                        'line' => 6,
                        'ignorable' => true
                    ],
                    [
                        'message' => 'Included or required file "a_file_that_does_not_exist.php" does not exist.',
                        'line' => 7,
                        'ignorable' => true
                    ],
                    [
                        'message' => 'Included or required file "a_file_that_does_not_exist_once.php" does not exist.',
                        'line' => 8,
                        'ignorable' => true
                    ],
                ]
            ],
        ];

        $output = [];
        exec('php vendor/bin/phpstan analyse -c tests/phpstan-testing.neon --error-format=json', $output);

        $jsonOutput = json_decode(implode(' ', $output), true, 10, JSON_THROW_ON_ERROR);

        $this->assertSame($expectedTotalErrors, $jsonOutput['totals']['file_errors']);
        $this->assertCount(count($expectedErrorsPerFile), $jsonOutput['files']);

        foreach ($jsonOutput['files'] as $filename => $errors) {
            $basename = basename($filename);

            $this->assertArrayHasKey($basename, $expectedErrorsPerFile);
            $this->assertSame($expectedErrorsPerFile[$basename]['errors'], $errors['errors']);
            $this->assertSame($expectedErrorsPerFile[$basename]['messages'], $errors['messages']);
        }
    }
}
