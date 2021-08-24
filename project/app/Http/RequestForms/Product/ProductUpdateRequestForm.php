<?php

namespace App\Http\RequestForms\Product;

use App\Http\Requests\CommonRequestForm;
use App\Http\Requests\Product\ProductUpdateRequest;

class ProductUpdateRequestForm extends CommonRequestForm
{
    public function rules()
    {
        return [
            'id' => ['required', 'integer'],
            'name' => ['string', 'max:255'],
            'categoryId' => ['integer'],
            'price' => ['numeric'],
            'description' => ['string'],
        ];
    }

    public function body(): ProductUpdateRequest
    {
        return $this->innerBodyObject(new ProductUpdateRequest());
    }
}
