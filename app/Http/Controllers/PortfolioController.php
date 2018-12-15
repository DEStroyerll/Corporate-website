<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;


class PortfolioController extends SiteController
{

    /**
     * PortfolioController constructor.
     * @param PortfoliosRepository $portfolios_repository
     */
    public function __construct(PortfoliosRepository $portfolios_repository)
    {
        parent::__construct(new MenusRepository(new Menu()));

        $this->portfolio_repository = $portfolios_repository;
        $this->title = 'Pink Rio';

        $this->template = env('THEME') . '.portfolios';
    }


    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Здесь мы отображаем статьи в разделе PORTFOLIO
        |--------------------------------------------------------------------------
       */

        $portfolios = $this->getPortfolios();

        $content = view(env('THEME') . '.portfolios_content')
            ->with('portfolios', $portfolios)
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    /**
     * @param $take
     * @param $paginate - постраничная навигация.
     * @return bool - возвращает статьи раздела PORTFOLIO.
     */
    public function getPortfolios($take = false, $paginate = true)
    {
        $portfolios = $this->portfolio_repository->getModel('*', $take, $paginate);
        //Здесь мы используя метод load()
        //подгружаем связаную модель Filter с Portfolio.
        if ($portfolios){
            $portfolios->load('filter');
        }
//        dd($portfolios);
    return $portfolios;
    }

    /**
     * @param $alias - одна статья данного раздела.
     * @return $this
     */
    public function show($alias)
    {
        $portfolio = $this->portfolio_repository->one($alias);
        //Здесь мы отображаем остальные работы в разделе Portfolio
        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);

        $content = view(env('THEME') . '.portfolio_content')
            ->with(['portfolio' => $portfolio, 'portfolios' => $portfolios])
            ->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }
}
