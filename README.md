# phpstan-require-file-exists
Weirdly enough, PHPStan does not check if a file exists when used in a
`require` or `include` statement. This is a PHPStan rule that tries to do
exactly that.

## Installation
```bash
composer require --dev bellangelo/phpstan-require-file-exists
```

## Configuration
Add the following to your `phpstan.neon`:
```neon
services:
    -
        class: Bellangelo\PHPStanRequireFileExists\RequireFileExistsRule
        arguments:
           - @reflectionProvider
        tags: [phpstan.rules.rule]
```

You can find a `phpstan.neon` example in the `tests` directory, here: [tests/phpstan.neon](tests/phpstan-testing.neon).

## Supported cases
- `require 'file.php';` - might not find it since the path is relative.
- `require __DIR__ . '/file.php';` - can find it, if it exists.
- `require __DIR__ . '/' . MyClass::MY_CONST;` - can find it if the const has the correct value from the start.

## Unsupported cases
- `require $file;` - won't throw an error since it cannot read variables.
- `require (new MyClass())->file;` - won't throw an error since it cannot read class properties.