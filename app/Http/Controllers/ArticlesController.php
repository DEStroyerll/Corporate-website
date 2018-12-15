<?php

namespace App\Http\Controllers;

use App\Category;
use App\Menu;
use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;

class ArticlesController extends SiteController
{
    /**
     * ArticlesController constructor.
     * @param PortfoliosRepository $portfolio_repository
     * @param ArticlesRepository $articles_repository
     * @param CommentsRepository $comments_repository
     */
    public function __construct(PortfoliosRepository $portfolio_repository, ArticlesRepository $articles_repository,
                                CommentsRepository $comments_repository)
    {
        parent::__construct(new MenusRepository(new Menu()));

        $this->portfolio_repository = $portfolio_repository;
        $this->articles_repository = $articles_repository;
        $this->comments_repository = $comments_repository;

        $this->title = 'Pink Rio';

        //Шаблон для отображения статей на экран.
        $this->template = env('THEME') . '.articles';
    }

    /**
     * Метод который отображает статьи в разделе BLOG.
     * @param $cat_alias
     * @return $this
     */
    public function index($cat_alias = false)
    {
        /*
        |--------------------------------------------------------------------------
        | Здесь мы отображаем статьи в разделе BLOG
        |--------------------------------------------------------------------------
       */

        $articles = $this->getArticles($cat_alias);
        $content = view(env('THEME') . '.articles_content')
            ->with('articles', $articles)
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);


        /*
        |--------------------------------------------------------------------------
        | Здесь мы отображаем правый сайдбар в разделе BLOG
        |--------------------------------------------------------------------------
       */

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));
        $this->content_right_sidebar = view(env('THEME') . '.articles_sidebar')
            ->with(['comments' => $comments, 'portfolios' => $portfolios]);

//        dd($portfolios);
//        dd($comments);

        return $this->renderOutput();
    }

    /**
     * Метод для отображения коментариев в разделе BLOG
     * @param $amount_of_elements - количество коментариев
     * @return mixed
     */
    public function getComments($amount_of_elements)
    {
        $comments = $this->comments_repository->getModel(['text', 'name', 'email', 'website', 'articles_id', 'user_id'], $amount_of_elements);
        return $comments;

    }

    /**
     * Метод для отображения статей в разделе BLOG
     * @param $amount_of_elements - количество статей
     * @return bool
     */
    public function getPortfolios($amount_of_elements)
    {
        $portfolios = $this->portfolio_repository->getModel(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], $amount_of_elements);
        return $portfolios;
    }

    /**
     * Метод для получения статей.
     * @param bool $alias - id category к которой привязана статья.
     * @return bool
     */
    public function getArticles($alias = false)
    {
        $where = false;
        //Формируем id конкретной категории.
        if ($alias) {
            $category_id = Category::select('id')
                //WHERE 'alias' = $alias
                ->where('alias', $alias)
                ->first()
                ->id;
            $where = ['category_id', $category_id];
        }

        //Получаем коллекцию моделей и
        //перечень свойств которые мы берем из (БД).
        $articles = $this
            ->articles_repository
            ->getModel(['title', 'alias', 'created_at', 'img', 'description', 'user_id', 'category_id'], false, true, $where);
        if ($articles) {
            //Подгружаем информацию из связаных моделей
            //на этапе формирования информации.
            $articles->load('user', 'category');
        }
        return $articles;
    }

    /**
     * Метод для отображения развернутого материала статьи.
     * @param bool $alias - псевдоним материала который нужно отобразить на экране.
     * @return $this
     */
    public function show($alias = false)
    {
        //Здесь мы выбрали одну запись из БД используя метод one().
        $article = $this->articles_repository->one($alias);
//        dd($article);

        $content = view(env('THEME') . '.article_content')
            ->with('article', $article)
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));
        $this->content_right_sidebar = view(env('THEME') . '.articles_sidebar')
            ->with(['comments' => $comments, 'portfolios' => $portfolios]);

        return $this->renderOutput();
    }
}
