<!--Здесь мы наследуем главный макет сайта-->
@extends(env('THEME').'.layouts.site')

<!--Здесь мы подключаем секцию navigation-->
@section('navigation')
    {!! $navigation !!}
@endsection

@section('slider')
    {!! $sliders !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('bar')
    {!! $right_sidebar !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection