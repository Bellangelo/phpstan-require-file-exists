# phpstan-require-file-exists
**UPDATE:** This rule has been merged into PHPStan itself. Here is the PR: https://github.com/phpstan/phpstan-src/pull/3294

~~Weirdly enough, PHPStan does not check if a file exists when used in a
`require` or `include` statement. This is a PHPStan rule that tries to do
exactly that.~~

## Installation
```bash
composer require --dev bellangelo/phpstan-require-file-exists
```

## Development
For local development and testing, `composer.json` contains several commands that you can run.
- `composer run tests ` - runs the PHPUnit tests.
- `composer run phpstan` - runs PHPStan on the `src` and `tests` directories.
- `composer run phpcs` - runs PHP CodeSniffer on the `src` and `tests` directories.
- `composer run phpcs:fix` - runs PHP CodeSniffer on the `src` and `tests` directories and tries to fix the issues.