<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use JsonMapper;

abstract class CommonRequestForm extends FormRequest
{
    /**
     * @var Factory
     */
    protected $factory;

    public function __construct()
    {
        parent::__construct();

        $this->factory = App::make(Factory::class);
    }

    protected function failedValidation(Validator $validator)
    {
        if (count($validator->failed()) > 0) {
            $validator->errors()->add('_form', $this->formValidationMessage());
        }

        parent::failedValidation($validator);
    }

    protected function formValidationMessage(): string
    {
        return trans('validation.invalidRequest');
    }

    /**
     * @param $body
     * @return mixed
     */
    protected function innerBodyObject($body)
    {
        $jsonMapper = new JsonMapper();
        $jsonMapper->bEnforceMapType = false;

        return $jsonMapper->map((object) $this->input(), $body);
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    abstract public function body();
}
