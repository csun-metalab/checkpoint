<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organizations';

    protected $guarded = [];
    public $incrementing = false;
}