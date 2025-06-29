<?php

namespace DTO;

/**
 * Data Transfer Collection.
 * 
 * Allows arbitrary int keys.
 * 
 * @api
 * @abstract
 * @package dto
 * @since 0.1.0
 * @version 1.1.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 * 
 * @template T
 * @method T offsetGet(int $offset)
 */
abstract class DataTransferCollection extends DataTransferObject {

    /**
     * Creates a new data transfer collection/map instance.
     * 
     * @api
     * @final
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param array<int|string, mixed> $fields
     */
    public final function __construct(array $fields) {

        parent::__construct($this instanceof DataTransferMap ? $fields : array_values($fields));
    }
}
