<?php

namespace DTO\Validation;

use Attribute;

/**
 * Validates that the input is greater than a specified value.
 * 
 * @api
 * @final
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class GreaterThan extends ValidationRule {

    /**
     * Creates a new GreaterThan validation rule.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param int|float $value
     */
    public final function __construct(private int|float $value) {}

    /**
     * Checks the input against the validation rule.
     * 
     * @final
     * @internal
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param mixed $input
     * @return ?string The error message if validation fails, null otherwise.
     */
    protected final function check(mixed $input): ?string {

        if (is_numeric($input)) {

            return $input > $this->value ? null : "Value of {dtoClass}.{field} must be greater than {$this->value}.";
        }

        if (is_array($input)) {

            return count($input) > $this->value ? null : "Value of {dtoClass}.{field} must be an array with more than {$this->value} element(s).";
        }

        if (is_string($input)) {

            return mb_strlen($input) > $this->value ? null : "Value of {dtoClass}.{field} must be a string longer than {$this->value} character(s).";
        }

        return null;
    }
}
