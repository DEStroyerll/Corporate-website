<!-- START PRIMARY -->
<div id="primary" class="sidebar-no">
    <div class="inner group">
        <!-- START CONTENT -->
        <div id="content-page" class="content group">
            <div class="clear"></div>
            <div class="posts">
                <div class="group portfolio-post internal-post">

                    @if($portfolio)
                        <div id="portfolio" class="portfolio-full-description">

                            <div class="fulldescription_title gallery-filters">
                                <h1>{{$portfolio->title}}</h1>
                            </div>

                            <div class="portfolios hentry work group">
                                <div class="work-thumbnail">
                                    <a class="thumb"><img src="{{asset(env('THEME'))}}/images/projects/{{$portfolio->img->max}}" alt="" title=""/></a>
                                </div>
                                <div class="work-description">
                                    <p>{!! $portfolio->text !!}</p>
                                    <div class="clear"></div>
                                    <div class="work-skillsdate">
                                        <p class="skills"><span class="label">Filter:</span> {{$portfolio->filter->title}}</p>
                                        <p class="workdate"><span class="label">Customer:</span> {{$portfolio->customer}}</p>
                                        <p class="workdate"><span class="label">Year:</span> {{$portfolio->created_at->format('Y')}}
                                        </p>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="clear"></div>

                            @if(!$portfolios->isEmpty())
                                <h3>Other Projects</h3>

                                <div class="portfolio-full-description-related-projects">
                                    @foreach($portfolios as $portfolio)
                                        <div class="related_project">
                                            <a class="related_proj related_img"
                                               href="{{route('portfolios.show',['alias'=>$portfolio->alias])}}"
                                               title="Love">
                                                <img src="{{asset(env('THEME'))}}/images/projects/{{$portfolio->img->mini}}" alt="" title=""/></a>
                                            <h4>
                                                <a href="{{route('portfolios.show',['alias'=>$portfolio->alias])}}">{{$portfolio->title}}</a>
                                            </h4>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
</div>
<!-- END PRIMARY -->