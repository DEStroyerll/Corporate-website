<!-- START SIDEBAR -->
    <!--Виджет для отображения последних работ портфолио-->
    <div class="widget-first widget recent-posts">
        <h3>{{Lang::get('my_translations.latest_projects')}}</h3>
        <div class="recent-post group">
            @if(!$portfolios->isEmpty())
                @foreach($portfolios as $portfolio)
                    <div class="hentry-post group">
                                            <!--Костыль для CCS уменьшение размера-->
                        <div class="thumb-img"><img style="width: 55px" src="{{asset(env('THEME'))}}/images/projects/{{$portfolio->img->mini}}" alt="" title="" /></div>
                        <div class="text">
                            <a href="{{route('portfolios.show', ['alias'=>$portfolio->alias])}}" title="{{$portfolio->title}}" class="title">{{$portfolio->title}}</a>
                            <p>{{str_limit($portfolio->text, 130)}}</p>
                            <a class="read-more" href="{{route('portfolios.show', ['alias'=>$portfolio->alias])}}">{{Lang::get('my_translations.read_more')}}</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!--Виджет для отображения последних коментариев-->
    @if(!$comments->isEmpty())
        <div class="widget-last widget recent-comments">
            <h3>{{Lang::get('my_translations.latest_comments')}}</h3>
            <div class="recent-post recent-comments group">
                @foreach($comments as $comment)
                    <div class="the-post group">
                        <div class="avatar">

                            @setDirective($user_mail, ($comment->email) ? md5($comment->email) : $comment->user->email)
                            <img alt="" src="https://www.gravatar.com/avatar/{{$user_mail}} ?d=mm&s=55" class="avatar" />
                        </div>
                        <span class="author"><strong><a href="#">{{isset($comment->user) ? $comment->user->name : $comment->name}}</a></strong> in</span>
                        <a class="title" href="#">{{$comment->text}}</a>
                        <p class="comment">
                            {{$comment->text}} <a class="goto" href="#">&#187;</a>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
<!-- END SIDEBAR -->