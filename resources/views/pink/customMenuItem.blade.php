<!--Шаблон для вывода меню с использованием рекурсии-->
@foreach($items as $item)
    <!--Добавляем класс active для активного пункта меню-->
    <li {{(URL::current() == $item->url()) ? "class=active" : ""}}>
        <!--Метод url() получает ссылку на пункт меню (указана вторым параметром при создании объекта Menu)-->
        <a href="{{$item->url()}}">{{$item->title}}</a>
        <!--Формируем дочерние пункты меню метод hasChildren() проверяет наличие дочерних пунктов меню-->
        @if($item->hasChildren())
            <ul class="sub-menu">
                <!--Метод children() возвращает дочерние пункты меню для текущего пункта-->
                @include(env('THEME').'.customMenuItem', ['items'=>$item->children()])
            </ul>
        @endif
    </li>
@endforeach