<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends AdminController
{
    /**
     * IndexController constructor.
     */
    public function __construct()
    {
//        parent::__construct();

        $this->template = view(env('THEME') . '.admin.index');
    }

    public function index()
    {
        $this->title = 'Admin panel';

        return $this->renderOutput();
    }
}
