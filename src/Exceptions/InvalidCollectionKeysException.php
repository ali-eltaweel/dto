<?php

namespace DTO\Exceptions;

/**
 * Exception thrown when a collection's keys are not integers.
 * 
 * @api
 * @final
 * @package dto
 * @since 0.1.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class InvalidCollectionKeysException extends DataTransferException {

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
     */
    public final function __construct(public readonly string $dtoClass) {

        parent::__construct("Collection keys must be integers at DTO '$dtoClass'");
    }
}
