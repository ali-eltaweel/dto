<?php

namespace DTO;

use ArraySubscript\{ Annotations\ArraySubscript, Annotations\ArraySubscriptOperation, ArrayObject };

use Lang\{ Annotations\Computes, ComputedProperties };

use ArrayAccess, ReflectionClass, ReflectionNamedType, ReflectionParameter, ReflectionUnionType, Throwable;

/**
 * Data Transfer Object (DTO).
 * 
 * @api
 * @abstract
 * @package dto
 * @since 0.1.0
 * @version 1.3.0
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
abstract class DataTransferObject implements ArrayAccess {

    use ArrayObject, ComputedProperties;

    /**
     * The fields of the Data Transfer Object.
     * 
     * @internal
     * @since 1.0.0
     * 
     * @var array<int|string, mixed>
     */
    protected array $fields;

    /**
     * Creates a new Data Transfer Object instance.
     * 
     * @api
     * @since 1.0.0
     * @version 1.1.0
     * 
     * @param array<int, mixed> $fields
     */
    public function __construct(array $fields) {

        $classReflection = new ReflectionClass(static::class);

        if (is_a(static::class, DataTransferCollection::class, true)) {

            $this->fields = $fields;

            $signatureMethod    = $classReflection->hasMethod('__v') ? $classReflection->getMethod('__v') : null;
            $signatureParameter = ($signatureMethod?->getParameters() ?? [])[0] ?? null;

            foreach (Validation\ValidationRule::annotatedOn($signatureParameter, instanceof: true) ?? [] as $validationRule) {
                
                foreach ($this->fields as $field => $value) {

                    $validationRule->validate(static::class, $field, $value);
                }
            }

            return;
        }

        $constructorParameters = $classReflection->getConstructor()->getParameters();

        $fieldsNames = array_map(
            fn (ReflectionParameter $parameterReflection) => $parameterReflection->getName(),
            $constructorParameters
        );

        $this->fields = array_combine($fieldsNames, array_pad($fields, count($fieldsNames), null));

        foreach ($constructorParameters as $parameterReflection) {

            foreach (Validation\ValidationRule::annotatedOn($parameterReflection, instanceof: true) ?? [] as $validationRule) {

                $validationRule->validate(static::class, $parameterReflection->getName(), $this->{$parameterReflection->getName()});
            }
        }
    }

    public final function getFieldsNames(): array {

        return array_keys($this->fields);
    }

    /**
     * Converts this Data Transfer Object to an array.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return array<int|string, mixed> The array representation of this Data Transfer Object.
     */
    public final function toArray(): array {

        /** @var ?callable */
        $toArray = null;
        $toArray = function(array $fields) use (&$toArray) {

            foreach ($fields as $field => $value) {

                if (is_a($value, DataTransferObject::class, true)) {
                    $fields[ $field ] = $value->toArray();
                    continue;
                }
                
                if (is_array($value)) {

                    $fields[ $field ] = $toArray($value);
                    continue;
                }

                $fields[ $field ] = $value;
            }

            return $fields;
        };

        return $toArray($this->fields);
    }

    /**
     * Retrieves the value of a field.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $field The name of the field to retrieve.
     * @return mixed The value of the field.
     */
    #[Computes(provider: 'getFieldsNames')]
    #[ArraySubscript(operation: ArraySubscriptOperation::Get)]
    protected final function get(string $field): mixed {

        return $this->fields[$field];
    }

    /**
     * Creates a new Data Transfer Object instance from an array.
     * 
     * @api
     * @static
     * @since 1.0.0
     * @version 1.1.0
     * 
     * @param array<int|string, mixed> $fields
     * @return static
     * 
     * @throws Exceptions\InvalidCollectionKeysException
     * @throws Exceptions\MissingConcreteConstructorException
     * @throws Exceptions\MissingArgumentTypeException
     * @throws Exceptions\CannotInstantiateAbstractClassException
     */
    public static function fromArray(array $fields): static {

        if (in_array(static::class, [ self::class, DataTransferCollection::class, DataTransferMap::class ], true)) {

            throw new Exceptions\CannotInstantiateAbstractClassException();
        }

        $fields = static::mapFields($fields);

        if (is_a(static::class, DataTransferCollection::class, true)) {

            return new static($fields);
        }

        return new static(...$fields);
    }

    /**
     * Maps the specified field to its corresponding type.
     * 
     * @static
     * @internal
     * @since 1.0.0
     * @version 1.1.0
     * 
     * @param string $field
     * @param mixed $value
     * @param ?ReflectionNamedType $type
     * @return mixed
     * 
     * @throws Exceptions\InvalidCollectionKeysException
     * @throws Exceptions\MissingConcreteConstructorException
     * @throws Exceptions\MissingArgumentTypeException
     */
    protected static function mapField(int|string $field, mixed $value, ?ReflectionNamedType $type): mixed {

        if (is_null($type)) {

            return $value;
        }

        if (is_null($value) && $type->allowsNull()) {

            return null;
        }

        switch ($type->getName()) {

            case 'string': return strval($value);
            case 'int':    return intval($value);
            case 'float':  return floatval($value);
            case 'bool':   return boolval($value);
            case 'array':  return is_array($value) ? $value : (array) $value;
        };

        if (is_a($type->getName(), self::class, true)) {

            if (!(is_array($value) || is_a($value, $type->getName()))) {

                throw new Exceptions\InvalidArgumentTypeException(static::class, $field, gettype($value), "{$type->getName()} or an array");
            }

            if (is_array($value)) {

                try {

                    $value = $type->getName()::fromArray($value);

                } catch (Exceptions\ValidationException $validationException) {
                
                    throw new Exceptions\ValidationException(
                        messageTemplate: $validationException->messageTemplate,
                        dtoClass: static::class,
                        field: "{$field}.{$validationException->field}",
                        validationRuleClass: $validationException->validationRuleClass
                    );

                } catch (Exceptions\InvalidCollectionKeysException $invalidCollectionKeysException) {

                    throw new Exceptions\InvalidCollectionKeysException(
                        dtoClass: "{$field}.{$invalidCollectionKeysException->dtoClass}"
                    );

                } catch (Exceptions\MissingArgumentTypeException $missingArgumentTypeException) {

                    throw new Exceptions\MissingArgumentTypeException(
                        dtoClass: static::class,
                        field: "{$field}.{$missingArgumentTypeException->field}"
                    );

                } catch (Throwable $e) {

                    throw $e;
                }
            }

            return $value;
        }

        throw new Exceptions\UnsupportedArgumentTypeException(static::class, $field, $type->getName());
    }

    /**
     * Maps the specified fields to their corresponding types.
     * 
     * @static
     * @internal
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param array<int|string, mixed> $fields
     * @return array<int|string, mixed>
     * 
     * @throws Exceptions\InvalidCollectionKeysException
     * @throws Exceptions\MissingConcreteConstructorException
     * @throws Exceptions\MissingArgumentTypeException
     */
    private static function mapFields(array $fields): array {

        if (
            is_a(static::class, DataTransferCollection::class, true) &&
            !is_a(static::class, DataTransferMap::class, true)
        ) {

            foreach (array_keys($fields) as $k) {
    
                if (!is_int($k)) {

                    throw new Exceptions\InvalidCollectionKeysException(static::class);
                }
            }
        }

        $classReflection = new ReflectionClass(static::class);

        if (is_a(static::class, DataTransferCollection::class, true)) {
            
            $signatureMethod    = $classReflection->hasMethod('__v') ? $classReflection->getMethod('__v') : null;
            $signatureParameter = ($signatureMethod?->getParameters() ?? [])[0] ?? null;
            $valueType          = $signatureParameter?->getType();
            $valueType          = $valueType instanceof ReflectionUnionType ? $valueType->getTypes()[0] : $valueType;

            foreach ($fields as $field => $value) {

                $fields[$field] = static::mapField($field, $value, $valueType);
            }

            return is_a(static::class, DataTransferMap::class, true) ? $fields : array_values($fields);
        }

        $mappedFields = [];
        $constructor  = $classReflection->getConstructor();
        
        if ($constructor->getDeclaringClass()->getName() == self::class) {

            throw new Exceptions\MissingConcreteConstructorException();
        }

        foreach ($constructor->getParameters() as $parameterReflection) {

            $parameterName = $parameterReflection->getName();

            if (!array_key_exists($parameterName, $fields) && $parameterReflection->isDefaultValueAvailable()) {

                $fields[ $parameterName ] = $parameterReflection->getDefaultValue();
            }
            
            if (is_null($parameterType = $parameterReflection->getType())) {

                $mappedFields[ $parameterName ] = $fields[ $parameterName ] ?? null;
            }

            if ($parameterType instanceof ReflectionUnionType) {

                $parameterType = $parameterType->getTypes()[0];
            }

            if (!array_key_exists($parameterName, $fields) && !$parameterType->allowsNull()) {

                if (is_a($parameterType->getName(), self::class, true)) {

                    $fields[ $parameterName ] = [];
                } else {

                    throw new Exceptions\MissingArgumentTypeException(static::class, $parameterName);
                }
            }

            $argument = $fields[ $parameterName ] ?? null;

            $mappedFields[ $parameterName ] = static::mapField($parameterName, $argument, $parameterType);
        }

        return $mappedFields;
    }
}
