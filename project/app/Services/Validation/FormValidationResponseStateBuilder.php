<?php declare(strict_types=1);

namespace App\Services\Validation;

class FormValidationResponseStateBuilder
{
    /**
     * @var array
     */
    private $state;

    public function __construct()
    {
        $this->state = [];
    }

    public function field(string $fieldName, array $messages): FormValidationResponseStateBuilder
    {
        $this->setField($fieldName, $messages);

        return $this;
    }

    /**
     * @param array|null $messages
     * @return array
     */
    public function create(?array $messages = null): array
    {
        $this->setField('_form', $messages ?? [trans('validation.invalidRequest')]);

        return $this->state;
    }

    public function createOrEmpty(array $formMessages = []): array
    {
        return !$this->isEmpty() ? $this->create($formMessages) : [];
    }

    public function isEmpty(): bool
    {
        return count($this->state) === 0;
    }

    private function setField(string $fieldName, array $messages): void
    {
        if ($messages === null || count($messages) === 0) {
            return;
        }

        $this->state[$fieldName] = $messages;
    }
}
