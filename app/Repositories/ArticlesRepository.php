<?php

namespace App\Repositories;

use App\Article;

/**
 * Class ArticlesRepository для работы с моделью Article.
 * @package App\Repositories
 */
class ArticlesRepository extends Repository
{
    /**
     * Конструктор для отображения модели Article.
     */
    public function __construct(Article $articles)
    {
        $this->model = $articles;
    }
}