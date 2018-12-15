<?php

namespace App\Repositories;

use App\Slider;

/**
 * Class SlidersRepository для работы с моделью Slider.
 * @package App\Repositories
 */
class SlidersRepository extends Repository {

    /**
     * Конструктор для отображения модели Slider.
     */
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }
}