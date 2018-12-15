<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Данный метод предоставляет доступ к записям
    //из таблички articles которые связаны с конкретной категорией.
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
