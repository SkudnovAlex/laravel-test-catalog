<?php

namespace App\DbModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

abstract class BaseModel extends Model
{
    use ValidatingTrait, HasFactory;

    public $validationMessage = 'Request data is invalid';

    protected $rules = [];

    protected $throwValidationExceptions = true;
}
