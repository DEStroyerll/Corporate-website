<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\ArticlesRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use App\Repositories\SlidersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class IndexController для работы с главной страничкой сайта.
 * @package App\Http\Controllers
 */
class IndexController extends SiteController
{
    /**
     * IndexController constructor.
     * @param SlidersRepository $slider_repository
     * @param PortfoliosRepository $portfolio_repository
     * @param ArticlesRepository $articles_repository
     */
    public function __construct(SlidersRepository $slider_repository, PortfoliosRepository $portfolio_repository,
                                ArticlesRepository $articles_repository)
    {
        parent::__construct(new MenusRepository(new Menu()));
        $this->slider_repository = $slider_repository;
        $this->portfolio_repository = $portfolio_repository;
        $this->articles_repository = $articles_repository;

        $this->site_bar = 'right';
        $this->title = 'Pink Rio';
        
        //Глобальный шаблон для отображения информации на экран.
        $this->template = env('THEME') . '.index';
    }

    /**
     * Метод который отображает контент главной страницы сайта.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Здесь мы получаем список Portfolio в виде коллекции моделей.
        |--------------------------------------------------------------------------
       */

        $portfolios = $this->getPortfolios();
        $content = view(env('THEME') . '.content')
            ->with('portfolios', $portfolios)
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);


        /*
        |--------------------------------------------------------------------------
        | Здесь мы получаем информацию о изображениях
        | которые отображаются в слайдере.
        |--------------------------------------------------------------------------
       */

        $slider_item = $this->getSliders();
        //Метод render() генерирует строку из объекта вида.
        $sliders = view(env('THEME') . '.slider')
            ->with('sliders', $slider_item)
            ->render();
        //Используя массив vars мы добавляем ячейку sliders.
        $this->vars = array_add($this->vars, 'sliders', $sliders);

        /*
        |--------------------------------------------------------------------------
        | Здесь мы формируем правый сайдбар нашего приложения.
        |--------------------------------------------------------------------------
       */

        $articles = $this->getArticles();
//        dd($articles);
        $this->content_right_sidebar = view(env('THEME') . '.sidebar')
            ->with('articles', $articles)
            ->render(); //Формируем строку из объекта.

        return $this->renderOutput();
    }

    /**
     * Метод для размещения статей в сайдбар.
     * @return mixed
     */
    protected function getArticles()
    {
        $articles = $this->articles_repository
            //Здесь мы указываем какие поля необходимо выбрать из таблички (БД).
            ->getModel(['title', 'created_at', 'img', 'alias'], Config::get('settings.articles_count'));
        return $articles;
    }

    /**
     * Метод возвращает список в виде коллекции модели Portfolio.
     * @return bool
     */
    protected function getPortfolios()
    {
        $portfolio = $this->portfolio_repository
            ->getModel('*', Config::get('settings.number_images_site'));
        return $portfolio;
    }

    /**
     * Метод для отображения слайдеров на главной страничке.
     * @return mixed
     */
    public function getSliders()
    {
        $sliders = $this->slider_repository->getModel();

        //Проверяем содержимое коллекции.
        if ($sliders->isEmpty()) {
            return false;
        }

        //Метод transform позволяет работать с коллекциями модели.
        $sliders->transform(function ($item) {
            $item->img = Config::get('settings.slider_path') . '/' . $item->img;
            return $item;
        });

        return $sliders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
