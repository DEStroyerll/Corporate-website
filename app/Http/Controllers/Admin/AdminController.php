<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Lavary\Menu\Menu;

/**
 * Class AdminController - родительский контроллер закрытой части проекта.
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    //Свойство для хранения Portfolio.
    protected $portfolio_repository;
    //Свойство для хранения Articles.
    protected $articles_repository;
    //Свойство для хранения аутентифицированных пользователей.
    protected $user;
    //Свойство для хранения шаблона.
    protected $template;
    //Свойство для хранения основного контента.
    //Основная часть каждой страницы панели администратора.
    protected $content = false;
    //Свойство для хранения заголовка страницы.
    protected $title;
    //Свойство для хранения массива переменных для шаблона.
    protected $vars = array();

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
//TODO метод user() возвращает аутентифицированного пользователя.
//        $this->user = Auth::user();
//
//        if (!$this->user) {
//            abort(404);
//        }
    }

    /**
     * Метод который формирует общий вид админки.
     * @return $this
     */
    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        //Формируем меню для админки.
        $menu = $this->getMenu();

        //Формирует навигацию для фдминки.
        $navigation = view(env('THEME') . '.admin.navigation')
            ->with('menu', $menu)
            ->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        //Формирует контент для админки.
        if ($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        //Формируем подвал проекта.
        $footer = view(env('THEME') . '.admin.footer')->render();
        $this->vars = array_add($this->vars,'footer',$footer);

        return view($this->template)->with($this->vars);
    }

    public function getMenu()
    {
        $build_menu = (new Menu)->make('adminMenu', function ($menu) {
            //Формируем пункты меню.
            $menu->add('Articles', array('route'=>'admin.articles'));

            $menu->add('Portfolio',  array('route'  => 'admin.articles.index'));
            $menu->add('Меню',  array('route'  => 'admin.articles.index'));
            $menu->add('Пользователи',  array('route'  => 'admin.articles.index'));
            $menu->add('Привилегии',  array('route'  => 'admin.articles.index'));
        });
        return $build_menu;
    }
}