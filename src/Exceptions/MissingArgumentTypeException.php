<?php

namespace DTO\Exceptions;

/**
 * Exception thrown when a required argument is missing for a DTO field when creating from an array.
 * 
 * @api
 * @final
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class MissingArgumentTypeException extends DataTransferException {

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
     */
    public final function __construct(public readonly string $dtoClass, public readonly string $field) {

        parent::__construct("Missing value for field '$dtoClass.$field'");
    }
}
