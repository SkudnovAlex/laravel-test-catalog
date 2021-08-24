<?php

namespace App\Mapper;

use App\DbModels\BaseModel;
use App\Models\EmptyModel;
use BadFunctionCallException;
use Carbon\Carbon;
use Illuminate\Support\Carbon as LaravelCarbon;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Mapper implements IMapper
{
    private object $source;
    private array $includeProperties = [];
    private array $excludeProperties = [];
    private bool $includeUsed = false;
    private bool $excludeUsed = false;
    private bool $emptyUsed = false;
    private bool $toEmpty = false;
    private bool $toCamel = false;
    private bool $toSnake = false;
    private bool $caseUsed = false;
    private bool $mapFieldsUsed = false;
    private array $mapFieldsProperties = [];

    private function __construct($source)
    {
        $this->source = $source;
    }

    public static function from($source, $checkPersisting = true): IMapper
    {
        if (!isset($source) || !is_object($source)) {
            throw new InvalidArgumentException('source must be an object');
        }

        if ($checkPersisting) {
            if (self::isEloquentModel($source) && !$source->exists) {
                throw new InvalidArgumentException(
                    'source based on the Eloquent must be loaded from the database before mapping'
                );
            }
        }

        return new self($source);
    }

    public function emptyIfNotPresent(): IMapper
    {
        $this->toEmpty = true;

        if ($this->emptyUsed) {
            throw new BadFunctionCallException(
                'empty rule has already been set and cannot be used again'
            );
        }

        $this->emptyUsed = true;

        return $this;
    }

    public function exclude(array $properties): IMapper
    {
        if ($this->includeUsed) {
            throw new BadFunctionCallException(
                'include rule has already been set and cannot be used along with exclude'
            );
        }

        if ($this->excludeUsed) {
            $this->excludeProperties = array_merge($this->excludeProperties, $properties);
        } else {
            $this->excludeProperties = $properties;
        }

        $this->excludeUsed = true;

        return $this;
    }

    public function excludeFrom(string $className): IMapper
    {
        return $this->exclude(array_keys(get_class_vars($className)));
    }

    public function include(array $properties): IMapper
    {
        if ($this->excludeUsed) {
            throw new BadFunctionCallException(
                'exclude rule has already been set and cannot be used along with include'
            );
        }

        $this->includeProperties = $properties;
        $this->includeUsed = true;

        return $this;
    }

    /** the key indicates from which field, to which value
     * @param array<string, string> $mapFields
     * @return $this|IMapper
     */
    public function mapFields(array $mapFields): IMapper
    {
        if ($this->mapFieldsUsed) {
            throw new BadFunctionCallException(
                'extended map rule has already been set and cannot be used along with include'
            );
        }

        $this->mapFieldsProperties = array_flip($mapFields);
        $this->mapFieldsUsed = true;

        return $this;
    }

    public function toSnakeCase(): IMapper
    {
        $this->toSnake = true;

        if ($this->caseUsed) {
            throw new BadFunctionCallException('case conversion rule has already been set');
        }

        $this->caseUsed = true;

        return $this;
    }

    public function toCamelCase(): IMapper
    {
        $this->toCamel = true;

        if ($this->caseUsed) {
            throw new BadFunctionCallException('case conversion rule has already been set');
        }

        $this->caseUsed = true;

        return $this;
    }

    public function mapTo($destination)
    {
        if (!isset($destination) || !is_object($destination)) {
            throw new InvalidArgumentException('destination must be an object');
        }

        if (self::isEloquentModel($this->source)) {
            $sourceVars = $this->source->toArray();

            foreach ($this->source->getDates() as $dateField) {
                $sourceVars[$dateField] = $this->source->$dateField;
            }
        } else {
            $sourceVars = get_object_vars($this->source);
        }

        if ($this->includeProperties) {
            $sourceVars = $this->array_filter_key(
                $sourceVars,
                function ($key) {
                    return in_array($key, $this->includeProperties);
                }
            );
        } elseif ($this->excludeProperties) {
            $sourceVars = $this->array_filter_key(
                $sourceVars,
                function ($key) {
                    return !in_array($key, $this->excludeProperties);
                }
            );
        }

        if (!$this->caseUsed) {
            if (self::isEloquentModel($this->source)) {
                if (!self::isEloquentModel($destination)) {
                    $this->toCamelCase();
                }
            } else {
                if (self::isEloquentModel($destination)) {
                    $this->toSnakeCase();
                }
            }
        }

        if ($this->caseUsed) {
            $keys = array_map(
                function ($key) {
                    if ($this->toCamel) {
                        return Str::camel($key);
                    }

                    if ($this->toSnake) {
                        return Str::snake($key);
                    }

                    return $key;
                },
                array_keys($sourceVars)
            );

            $sourceVars = array_combine($keys, array_values($sourceVars));
        }

        $destinationVars = get_class_vars(get_class($destination));

        if (self::isEloquentModel($destination)) {
            if ($destination->exists) {
                $destinationVars = $destination->toArray();
            } else {
                $destinationVars = $sourceVars;
            }
        }

        foreach ($destinationVars as $key => $value) {
            $sourceKey = $this->getSourceKey($key);

            if (array_key_exists($sourceKey, $sourceVars)) {
                if (isset($value) && !is_scalar($value) && !($value instanceof Carbon || $value instanceof LaravelCarbon)) {
                    continue;
                }

                $destination->$key = $sourceVars[$sourceKey];

                continue;
            }

            if ($this->toEmpty) {
                $destination->$key = EmptyModel::getValue();
            }
        }

        return $destination;
    }

    private static function isEloquentModel($obj)
    {
        return is_subclass_of($obj, BaseModel::class);
    }

    private function array_filter_key(array $array, $callback)
    {
        $matchedKeys = array_filter(array_keys($array), $callback);

        return array_intersect_key($array, array_flip($matchedKeys));
    }

    /**
     * @param string $destinationKey
     * @return string
     */
    private function getSourceKey(string $destinationKey)
    {
        if ($this->mapFieldsUsed &&
            isset($this->mapFieldsProperties[$destinationKey]) &&
            $this->mapFieldsProperties[$destinationKey] !== null
        ) {
            return $this->mapFieldsProperties[$destinationKey];
        }

        return $destinationKey;
    }
}
