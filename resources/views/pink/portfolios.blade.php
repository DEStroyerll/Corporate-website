<!--Здесь мы наследуем главный макет сайта-->
@extends(env('THEME').'.layouts.site')

<!--Здесь мы подключаем секцию navigation-->
@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection