<?php

namespace DTO\Validation;

use DTO\Exceptions\ValidationException;

use Attraction\Annotation;

use Attribute;

/**
 * Base class for validation rules.
 * 
 * @api
 * @abstract
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
abstract class ValidationRule extends Annotation {

    /**
     * Validates the input against the rule.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $dtoClass
     * @param int|string $field
     * @param mixed $input
     * @return void
     * 
     * @throws ValidationException
     */
    public final function validate(string $dtoClass, int|string $field, mixed $input): void {

        if (!is_null($messageTemplate = $this->check($input))) {

            throw new ValidationException(
                messageTemplate: $messageTemplate,
                dtoClass: $dtoClass,
                field: $field,
                validationRuleClass: $this::class
            );
        }
    }
    
    /**
     * Checks the input against the validation rule.
     * 
     * @internal
     * @abstract
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param mixed $input
     * @return ?string The error message if validation fails, null otherwise.
     */
    protected abstract function check(mixed $input): ?string;
}
