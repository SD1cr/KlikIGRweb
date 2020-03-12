<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewCategory extends Model
{
    protected $table = "kategori_ecommerce";
    public $timestamps = false;

    public static function getNewKatAll()
    {
        return NewCategory::Distinct()
            ->Select('kategori_ecommerce.id', 'name', 'url_gbr_icon')
            ->OrderBy('kategori_ecommerce.id')
            ->Take(7)->Get();
    }
}
