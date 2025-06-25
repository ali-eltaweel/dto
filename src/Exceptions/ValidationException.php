<?php

namespace DTO\Exceptions;

/**
 * Exception thrown when a DTO validation fails.
 * 
 * @api
 * @final
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class ValidationException extends DataTransferException {

    /**
     * Creates a new validation exception.
     * 
     * @api
     * @final
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $messageTemplate
     * @param string $dtoClass
     * @param string $field
     * @param string $validationRuleClass
     */
    public final function __construct(
        
        public readonly string $messageTemplate,
        public readonly string $dtoClass,
        public readonly string $field,
        public readonly string $validationRuleClass,
    ) {

        $message = preg_replace_callback('/{[a-zA-Z]+}/', function(array $matches) use ($dtoClass, $field) {

            return compact('dtoClass', 'field')[ substr($matches[0], 1, -1) ];

        }, $messageTemplate);

        parent::__construct($message);
    }
}
