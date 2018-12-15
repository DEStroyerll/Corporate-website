<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Config;

/**
 * Class Repository родительский класс для всех репозиториев для работы с логикой БД.
 * @package App\Repositories
 */
abstract class Repository
{
    //Свойство для хранения объектов моделей.
    protected $model = false;

    /**
     * Метод в котором мы получаем различные модели проекта.
     * @param string $select - это список полей которые мы вибираем из (БД).
     * @param bool $take - ограничитель элементов которые мы вибыраем из (БД).
     * @param bool $pagination - это количество элементов на одной странице постраничной навигации.
     * @param bool $where - это количество статей в определенной категории.
     * @return bool
     */
    public function getModel($select = '*', $take = false, $pagination = false, $where = false)
    {
        //$builder объект конструктора SQL запросов в (БД).
        $builder = $this->model->select($select);

        if ($take) {
            //Метод take() указывает сколько елементов
            //выбрать из таблицы в (БД).
            $builder->take($take);
        }

        if ($where) {
            $builder->where($where[0], $where[1]);
        }

        //Здесь метод paginate() завершает формирование SQL запроса.
        if ($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    /**
     * Метод для проверки елементов модели и декодировки картинок.
     * @param $element_model - отдельный элемент модели
     * @return bool
     */
    protected function check($element_model)
    {
        if ($element_model->isEmpty()) {
            return false;
        }

        //Используя функцию трансформ мы работаем с каждым елементом модели.
        $element_model->transform(function ($item) {

            if (is_string($item->img)
                && is_object(json_decode($item->img)
                    && (json_last_error() == JSON_ERROR_NONE))) {
                //Здесь мы используя метод json_decode()
                //в котором преобразуем свойство img(строка) в объект.
                $item->img = json_decode($item->img);
            }
            return $item;
        });
//        dd($element_model);
        return $element_model;
    }

    /**
     * Метод для работы с отдельными статьями модели Articles.
     * @param $alias
     * @return mixed
     */
    public function one($alias)
    {
        $one_article = $this->model->where('alias', $alias)->first();
        return $one_article;
    }
}
