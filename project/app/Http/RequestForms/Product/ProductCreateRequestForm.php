<?php

namespace App\Http\RequestForms\Product;

use App\Http\Requests\CommonRequestForm;
use App\Http\Requests\Product\ProductCreateRequest;

class ProductCreateRequestForm extends CommonRequestForm
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'categoryId' => ['required', 'integer'],
            'price' => ['numeric'],
            'description' => ['string'],
        ];
    }

    public function body(): ProductCreateRequest
    {
        return $this->innerBodyObject(new ProductCreateRequest());
    }
}
