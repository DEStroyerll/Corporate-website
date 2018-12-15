<?php

namespace App\Repositories;

use App\Menu;

/**
 * Class MenusRepository для работы с моделью Menu.
 * @package App\Repositories
 */
class MenusRepository extends Repository
{
    /**
     * Конструктор для отображения модели Menu.
     */
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }
}