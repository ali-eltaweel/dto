<?php

namespace DTO\Validation;

use Attribute;

/**
 * The Min validation rule checks if the input is greater than or equal to a specified minimum value.
 * 
 * @api
 * @final
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class Min extends ValidationRule {

    /**
     * Creates a new Min validation rule.
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

            return $input >= $this->value ? null : "Value of {dtoClass}.{field} must be at least {$this->value}.";
        }

        if (is_array($input)) {

            return count($input) >= $this->value ? null : "Value of {dtoClass}.{field} must be an array with at least {$this->value} element(s).";
        }

        if (is_string($input)) {

            return mb_strlen($input) >= $this->value ? null : "Value of {dtoClass}.{field} must be a string at least {$this->value} character(s).";
        }

        return null;
    }
}
