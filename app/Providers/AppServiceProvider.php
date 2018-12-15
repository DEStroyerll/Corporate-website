<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Директива для присваивания значений различным переменным в шаблоне Blade.
        //Первый аргумент директивы это имя переменной, а воторой значение.
        Blade::directive('setDirective', function ($expression) {
            //Функция list() - назначает список переменных за одну операцию.
            //Функция explode() - разбивает строку с помощью разделителя.
            list($name, $value) = explode(',', $expression);
            return "<?php $name = $value ?>";
        });

        //Просмотр SLQ запросов.
        DB::listen(function ($query) {
//            echo '<h1>'. $query->sql .'</h1>';
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
