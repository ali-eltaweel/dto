<?php

namespace DTO\Exceptions;

/**
 * Exception thrown when an invalid argument type is provided for a DTO field.
 * 
 * @api
 * @final
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class InvalidArgumentTypeException extends DataTransferException {

    /**
     * Creates a new instance of the exception.
     * 
     * @api
     * @final
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $dtoClass
     * @param string $field
     * @param string $type
     * @param string $expectedType
     */
    public final function __construct(
        
        public readonly string $dtoClass,
        public readonly string $field,
        public readonly string $type,
        public readonly string $expectedType,
    ) {

        parent::__construct("Invalid value for field '$dtoClass.$field'; expected $expectedType found $type");
    }
}
