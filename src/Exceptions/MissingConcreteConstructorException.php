<?php

namespace DTO\Exceptions;

/**
 * Exception thrown when a DTO class does not override the constructor.
 * 
 * @api
 * @final
 * @package dto
 * @since 0.1.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class MissingConcreteConstructorException extends DataTransferException {

    /**
     * Creates a new instance of the exception.
     * 
     * @api
     * @final
     * @override
     * @since 1.0.0
     * @version 1.0.0
     */
    public final function __construct() {

        parent::__construct('DTO\'s must have a concrete constructor to be instantiated.');
    }
}
