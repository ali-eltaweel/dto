<?php

namespace DTO\Exceptions;

/**
 * Exception thrown when attempting to instantiate an abstract class (base dto, base collection or map).
 * 
 * @api
 * @final
 * @package dto
 * @since 1.0.0
 * @version 1.0.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class CannotInstantiateAbstractClassException extends DataTransferException {

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

        parent::__construct('Cannot instantiate abstract class. Please use a concrete subclass instead.');
    }
}
