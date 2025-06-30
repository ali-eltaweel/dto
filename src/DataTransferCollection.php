<?php

namespace DTO;

use Countable, IteratorAggregate, Traversable;

/**
 * Data Transfer Collection.
 * 
 * Allows arbitrary int keys.
 * 
 * @api
 * @abstract
 * @package dto
 * @since 0.1.0
 * @version 1.2.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 * 
 * @template T
 * @method T offsetGet(int $offset)
 */
abstract class DataTransferCollection extends DataTransferObject implements Countable, IteratorAggregate {

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

    /**
     * Returns the number of fields in the collection.
     * 
     * @api
     * @final
     * @since 1.2.0
     * @version 1.0.0
     * 
     * @return int
     */
    public final function count(): int {
        
        return count($this->fields);
    }

    /**
     * Returns an iterator for the collection.
     * 
     * @api
     * @final
     * @since 1.2.0
     * @version 1.0.0
     * 
     * @return Traversable<int, T>
     */
    public final function getIterator(): Traversable {
        
        foreach ($this->fields as $key => $value) {
        
            yield $key => $value;
        }
    }
}
