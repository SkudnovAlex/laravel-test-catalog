<?php

namespace App\Http\RequestForms\Product;

use App\Http\Requests\CommonRequestForm;
use App\Http\Requests\Product\ProductListRequest;

class ProductListRequestForm extends CommonRequestForm
{
    public function rules()
    {
        return [
            'categoryId' => ['required', 'integer'],
            'page' => ['integer'],
            'pageSize' => ['integer'],
        ];
    }

    public function body(): ProductListRequest
    {
        return $this->innerBodyObject(new ProductListRequest());
    }
}
