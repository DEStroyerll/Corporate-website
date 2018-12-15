<?php

namespace App\Repositories;

use App\Portfolio;

class PortfoliosRepository extends Repository {

    /**
     * PortfoliosRepository constructor.
     */
    public function __construct(Portfolio $portfolio)
    {
        $this->model = $portfolio;
    }
}