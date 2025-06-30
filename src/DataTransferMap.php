<?php

namespace DTO;

/**
 * Data Transfer Map.
 * 
 * Allows arbitrary string keys.
 * 
 * @api
 * @abstract
 * @package dto
 * @since 0.1.0
 * @version 1.1.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
abstract class DataTransferMap extends DataTransferCollection {

    /**
     * Returns the keys of the map.
     * 
     * @api
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return array<int|string, string>
     */
    public final function keys(): array {
        
        return array_keys($this->fields);
    }
}
