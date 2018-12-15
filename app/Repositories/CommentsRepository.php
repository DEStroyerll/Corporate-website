<?php

namespace App\Repositories;

use App\Comment;

/**
 * Class CommentsRepository для работы с моделью Comment.
 * @package App\Repositories
 */
class CommentsRepository extends Repository
{
    /**
     * Конструктор для отображения модели Comment.
     */
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
}