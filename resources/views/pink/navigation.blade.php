<!-- START MAIN NAVIGATION -->
@if($menu)
    <div class="menu classic">
        <ul id="nav" class="menu">
            <!--$menu->roots() - получаем только родительские элементы меню-->
            @include(env('THEME').'.customMenuItem', ['items'=>$menu->roots()])
        </ul>
    </div>
@endif
<!-- END MAIN NAVIGATION -->