<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Маршруты для отображения главной странице сайта.
Route::resource('/', 'IndexController', ['only'=>'index', 'names'=>['index'=>'home']]);

//Маршруты для обработки страниц Portfolio.
Route::resource('portfolios', 'PortfolioController', ['parameters'=>['portfolios'=>'alias']]);

//Маршруты для обработки страниц в правом сайдбаре Article.
Route::resource('articles', 'ArticlesController', ['parameters'=>['articles'=>'alias']]);

//Регулярное выражение для параметров.
Route::get('articles/cat/{cat_alias?}', ['uses'=>'ArticlesController@index', 'as'=>'articles_cont'])
    ->where('cat_alias', '[\w-]+');

//Маршрут для обработки страницы Contact.
Route::match(['get', 'post'], '/contacts', ['uses'=>'ContactsController@index', 'as'=>'contacts']);



//Маршрут для регистрации пользователя.
//Route::get('login', ['uses'=>'Auth\AuthController@getLogin']);

//Маршрут для обработки данных введенных от пользователя.
//Route::post('login', ['uses'=>'Auth\AuthController@postLogin']);

//Маршрут для выхода пользователя.
//Route::get('logout', ['uses'=>'Auth\AuthController@getLogout']);


//Общая часть для всех маршрутов закрытой части проекта.
Route::group(['prefix' => 'admin','middleware'=> 'auth'],function() {

    Route::get('/',['uses' => 'Admin\IndexController@index','as' => 'admin']);

    Route::resource('/articles','Admin\ArticlesController');
});

//Аутентификация фдминки.
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
