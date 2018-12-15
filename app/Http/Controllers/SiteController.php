<?php

namespace App\Http\Controllers;

use App\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Lavary\Menu\Menu;

/**
 * Class SiteController родительский для всех контроллеров.
 * @package App\Http\Controllers
 */
class SiteController extends Controller
{
    //Свойство для хранения логики объектов класса Portfolios.
    protected $portfolio_repository;
    //Свойство для хранения логики объектов класса Sliders.
    protected $slider_repository;
    //Свойство для хранения логики объектов класса Article.
    protected $articles_repository;
    //Свойство для хранения логики объектов класса Menus.
    protected $menus_repository;
    //Свойство для хранения коментариев.
    protected $comments_repository;

    //Свойство для заголовка сайта.
    protected $title;

    //Свойство для хранения имени шаблона для конкретной страницы.
    protected $template;

    //Свойство для хранения массива переменных передаваемые в шаблон.
    protected $vars = array();

    //Свойство которое показывает есть/нет site bar на странице.
    protected $site_bar = false;

    //Свойства для хранения информации в левом/правом site bare.
    protected $content_right_sidebar = false;
    protected $content_left_sidebar = false;

    /**
     * SiteController constructor где для каждой странички
     * мы будем отображать menu сайта.
     * @param MenusRepository $menus_repository
     */
    public function __construct(MenusRepository $menus_repository)
    {
        $this->menus_repository = $menus_repository;
    }

    /**
     * Метод который формирует меню,навигацию,сайдбар,подвал проекта.
     * @return $this - Возвращает в результате работы конкретный вид.
     */
    protected function renderOutput()
    {
        //Переменная построитель  Builder menu.
        $menu = $this->getMenu();

        //Навигация проекта.
        $navigation = view(env('THEME') . '.navigation')
            ->with('menu', $menu)
            ->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        //Правый сайдбар.
        if ($this->content_right_sidebar) {
            $right_sidebar = view(env('THEME') . '.right_side_bar')
                ->with('content_right_sidebar', $this->content_right_sidebar)
                ->render();
            $this->vars = array_add($this->vars, 'right_sidebar', $right_sidebar);
        }

        //Левый сайдбар.
        if ($this->content_left_sidebar) {
            $left_sidebar = view(env('THEME') . '.left_side_bar')
                ->with('content_left_sidebar', $this->content_left_sidebar)
                ->render();
            $this->vars = array_add($this->vars, 'left_sidebar', $left_sidebar);
        }

        //Заголовок проекта.
        $this->vars = array_add($this->vars, 'title', $this->title);

        //Подвал проекта.
        //Используя метод render() мы из объекта получаем строку
        //которую можем отображать на экран.
        $footer = view(env('THEME') . '.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }

    /**
     * Метод для формирования menu используя библиотеку Lavary.
     * @return mixed
     */
    protected function getMenu()
    {
        $menu = $this->menus_repository->getModel();
//        dd($menu);

        //Здесь мы формируем menu сайта.
        $menu_builder = (new Menu)->make('myMenu', function ($add_menu) use ($menu) {
            foreach ($menu as $item) {
                //Здесь мы сформировали родительские элементы меню у которых parent_id == 0
                //и с помощью метода id() присваиваем каждому пункту идентификатор.
                if ($item->parent_id == 0) {
                    $add_menu->add($item->title, $item->path)->id($item->id);
                } //Иначе формируем дочерний пункт меню.
                else {
                    //Ищем для текущего дочернего пункта меню в объекте меню ($add_menu)
                    //id родительского пункта (из БД).
                    if ($add_menu->find($item->parent_id)) {
                        $add_menu->find($item->parent_id)
                            ->add($item->title, $item->path)
                            ->id($item->id);
                    }
                }
            }
        });

//        dd($menu_builder);

        return $menu_builder;
    }

}