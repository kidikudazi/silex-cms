<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <title>{{ env("APP_NAME") }} | {{ $post->title }}</title>
  @include('layouts.website.style')
</head>
<body class="">
  <div id="wrapper" class="clearfix">
    @include('layouts.website.preloader')
    <x-web-header />
    <div class="main-content">
      <section>
        <div class="container mt-30 mb-30 pt-30 pb-30">
            <div class="row">
                <div class="col-md-9">
                <div class="blog-posts single-post">
                    <article class="post clearfix mb-0">
                    <div class="entry-header">
                        <div class="post-thumb thumb"> <img src="{{ asset($post->image) }}" alt="" class="img-responsive img-fullwidth"> </div>
                    </div>
                    <div class="entry-content">
                        <div class="entry-meta media no-bg no-border mt-15 pb-20">
                        <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                            <ul>
                            <li class="font-16 text-white font-weight-600">{{ \Carbon\Carbon::parse($post->created_at)->format('d') }}</li>
                            <li class="font-12 text-white text-uppercase">{{ \Carbon\Carbon::parse($post->created_at)->format('M') }}</li>
                            </ul>
                        </div>
                        <div class="media-body pl-15">
                            <div class="event-content pull-left flip">
                                <h4 class="entry-title text-white text-uppercase m-0"><a href="">{{ $post->title }}</a></h4>
                                <span class="mb-10 text-gray-darkgray mr-10 font-13">
                                    <i class="fa fa-commenting-o mr-5 text-theme-colored"></i> Read by {{ $post->views }}
                                </span>
                            </div>
                        </div>
                        </div>
                        <p class="mb-15">{!! $post->body !!}</p>
                    </div>
                    </article>
                    <div class="tagline p-0 pt-20 mt-5">
                    <div class="row">                        
                        <div class="col-md-4">
                            <div class="share text-left">
                                <p><i class="fa fa-share-alt text-theme-colored"></i> Share</p>
                            </div>
                            <div class="post-right">
                                <ul class="styled-icons square-sm m-0">
                                <li><a href="https://facebook.com/sharer/sharer.php?u={{ url("/blog/$post->slug") }}" target="_blank"><i class="fa fa-facebook text-primary"></i></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url={{ url("/blog/$post->slug") }}" target="_blank"><i class="fa fa-twitter text-primary"></i></a></li>
                                <li><a href="whatsapp://send?text={{ url ("/blog/$post->slug") }}" target="_blank"><i class="fa fa-whatsapp text-success"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="author-details media-post">
                        <h5 class="post-title mt-0 mb-0"><a href="{{ route("blog", ["keyword" => $post->user->name]) }}" class="font-18"><span class="text-theme-colored">Author</span>: John Doe</a></h5>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </div>
                <div class="col-md-3">
                <div class="sidebar sidebar-left mt-sm-30">
                    <div class="widget">
                        <h5 class="widget-title line-bottom">Search box</h5>
                        <div class="search-form">
                            <form action="{{ route('blog') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="keyword" id="keyword" placeholder="Click to Search" class="form-control search-input" value="{{ request()->has('keyword') ? request()->get('keyword') : ''}}">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn search-button"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="widget">
                        @if (count($related))                                                    
                            <h5 class="widget-title line-bottom">Trending News</h5>
                            @foreach ($related as $item)
                                <div class="latest-posts">
                                    <article class="post media-post clearfix pb-0 mb-10">
                                        <a class="post-thumb" href="{{ url("blog/{$item->slug}") }}">
                                            <img src="{{ asset($item->image) }}" alt="Image" style="height: 75px; width: 75px;">
                                        </a>
                                        <div class="post-right">
                                            <h5 class="post-title mt-0"><a href="{{ url("blog/$item->slug") }}">{{ $item->title }}</a></h5>
                                            <p><b>Author</b>: {{ $item->user->name }}</p>
                                            <p><b>Read</b> by {{ $item->views }}</p>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
      </section>
    </div>
    @include('layouts.website.footer')
  </div>
  @include('layouts.website.script')
</body>
</html>