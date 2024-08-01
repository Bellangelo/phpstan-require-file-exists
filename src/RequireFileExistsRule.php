<?php

declare(strict_types=1);

namespace Bellangelo\PHPStanRequireFileExists;

use PhpParser\Node;
use PhpParser\Node\Expr\Include_;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class RequireFileExistsRule implements Rule
{
    private ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getNodeType(): string
    {
        return Include_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof Include_) {
            $filePath = $this->resolveFilePath($node->expr, $scope);
            if ($filePath !== null && !file_exists($filePath)) {
                return [
                    RuleErrorBuilder::message(sprintf('Included or required file "%s" does not exist.', $filePath))->build(),
                ];
            }
        }

        return [];
    }

    private function resolveFilePath(Node $node, Scope $scope): ?string
    {
        if ($node instanceof String_) {
            return $node->value;
        }

        if ($node instanceof Concat) {
            $left = $this->resolveFilePath($node->left, $scope);
            $right = $this->resolveFilePath($node->right, $scope);
            if ($left !== null && $right !== null) {
                return $left . $right;
            }
        }

        if ($node instanceof Dir) {
            return dirname($scope->getFile());
        }

        if ($node instanceof ClassConstFetch) {
            return $this->resolveClassConstant($node);
        }

        return null;
    }

    private function resolveClassConstant(ClassConstFetch $node): ?string
    {
        if ($node->class instanceof Node\Name && $node->name instanceof Node\Identifier) {
            $className = (string) $node->class;
            $constantName = $node->name->toString();

            if ($this->reflectionProvider->hasClass($className)) {
                $classReflection = $this->reflectionProvider->getClass($className);
                if ($classReflection->hasConstant($constantName)) {
                    $constantReflection = $classReflection->getConstant($constantName);
                    $constantValue = $constantReflection->getValue();
                    if (is_string($constantValue)) {
                        return $constantValue;
                    }
                }
            }
        }
        return null;
    }
}
