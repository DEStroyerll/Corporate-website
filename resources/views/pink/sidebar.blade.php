<!-- START SIDEBAR -->
<!--Правый сайдбар главной странички сайта-->
    <div class="widget-first widget recent-posts">

        @if($articles)
            <h3>{{trans('my_translations.recent_blog_entries')}}</h3>
            <div class="recent-post group">

                @foreach($articles as $article)
                    <div class="hentry-post group">
                        <div class="thumb-img"><img src="{{asset(env('THEME'))}}/images/articles/{{$article->img->mini}}" alt="" title="" /></div>
                        <div class="text">
                            <a href="{{route('articles.show', ['alias'=>$article->alias])}}" title="Section shortcodes &amp; sticky posts!" class="title">{{$article->title}}</a>
                            <!--Здесь мы используем класс Carbon для работы с датой и временем-->
                            <p class="post-date">{{$article->created_at->format('F d, Y ')}}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
        </div>

    <div class="widget-last widget text-image">
        <h3>Customer support</h3>
        <div class="text-image" style="text-align:left"><img src="{{asset(env('THEME'))}}/images/callus.gif" alt="Customer support" /></div>
        <p>Proin porttitor dolor eu nibh lacinia at ultrices lorem venenatis. Sed volutpat scelerisque vulputate. </p>
    </div>
<!-- END SIDEBAR -->