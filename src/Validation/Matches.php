<?php

namespace DTO\Validation;

use Attribute;

/**
 * This rule checks if the input matches a specified regular expression pattern.
 * 
 * @api
 * @final
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class Matches extends ValidationRule {

    /**
     * Creates a new Matches validation rule.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $pattern The regular expression pattern to match against the input.
     */
    public final function __construct(private string $pattern) {}

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

        return preg_match($this->pattern, strval($input)) == 1 ? null : "Value does not match the pattern ({$this->pattern}).";
    }
}
