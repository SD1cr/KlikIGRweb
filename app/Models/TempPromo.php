<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempPromo extends Model
{
    protected $table = 'temp_promo';
    protected $fillable = ['userid'];
    public $timestamps = false;
}
