<?php

namespace DTO\Exceptions;

/**
 * Exception thrown when an unsupported argument type is encountered.
 * 
 * @api
 * @final
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class UnsupportedArgumentTypeException extends DataTransferException {

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
     */
    public final function __construct(
        
        public readonly string $dtoClass,
        public readonly string $field,
        public readonly string $type,
    ) {

        parent::__construct("Unsupported type '$type' for field '$dtoClass.$field'; expected DTO, scalar or array");
    }
}
