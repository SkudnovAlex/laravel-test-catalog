<?php

namespace App\Http\RequestForms\Product;

use App\Http\Requests\CommonRequestForm;
use App\Http\Requests\Product\ProductDeleteRequest;

class ProductDeleteRequestForm extends CommonRequestForm
{
    public function rules()
    {
        return [
            'id' => ['required', 'integer'],
        ];
    }

    public function body(): ProductDeleteRequest
    {
        return $this->innerBodyObject(new ProductDeleteRequest());
    }
}
