<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //Свойство которое мы определили как объект.
    protected $casts = ['img' => 'object'];

    //Для конкретной записи мы получаем информацию
    //о пользователе который ее добавил.
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //Доступ к категории данной статьи.
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    //Доступ к коментариям.
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
