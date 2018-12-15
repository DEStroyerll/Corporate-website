<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    //Свойство которое мы определили как объект.
    protected $casts = ['img' => 'object'];

    //Модель Portfolio используя метод belongsTo
    //ссылается на определенную запись в табличке Filters.
    public function filter()
    {
        //Здесь в качестве первого аргумента мы указываем модель с которой связаня текущая модель.
        //В качестве второго аргумента мы указываем поле текущей модели (внешний ключ).
        //В качестве третьего аргумента мы определяем ответное поле модели с которой связываемся.
        return $this->belongsTo('App\Filter', 'filter_alias', 'alias');
    }
}
