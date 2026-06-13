<?php

namespace DTO\Validation;

use Attribute;

/**
 * The In validation rule checks if the input is within a specified set of values.
 * 
 * @api
 * @final
 * @package dto
 * @since 1.7.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class In extends ValidationRule {

    /**
     * Creates a new In validation rule.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param array $values
     * @param bool $strict
     */
    public final function __construct(private array $values, private bool $strict = false) {}

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

        if (in_array($input, $this->values, $this->strict)) {
            
            return null;
        }

        return "Value of {dtoClass}.{field} must be one of the allowed values: " . implode(", ", $this->values) . ".";
    }
}
