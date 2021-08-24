<?php declare(strict_types=1);

namespace App\Mapper;

interface IMapper
{
    public function include(array $properties): IMapper;

    public function exclude(array $properties): IMapper;

    public function excludeFrom(string $className): IMapper;

    public function mapFields(array $mapFields): IMapper;

    public function toSnakeCase(): IMapper;

    public function toCamelCase(): IMapper;

    public function emptyIfNotPresent(): IMapper;

    public function mapTo($destination);
}
