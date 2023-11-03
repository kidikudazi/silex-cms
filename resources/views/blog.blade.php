<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <title>{{ env("APP_NAME") }} | Blog</title>
  @include('layouts.website.style')
</head>
<body class="">
  <div id="wrapper" class="clearfix">
    @include('layouts.website.preloader')
    <x-web-header />
    <div class="main-content">
      <section>
        <div class="container">
          <div class="row mb-50">
            <div class="col-md-12">
              <div class="search-form">
                <form action="{{ route('blog') }}" method="GET">
                  <div class="input-group">
                    <input type="text" name="keyword" id="keyword" placeholder="Search..." class="form-control search-input" value="{{ request()->has('keyword') ? request()->get('keyword') : ''}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn search-button"><i class="fa fa-search"></i></button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="row multi-row-clearfix">
            <div class="blog-posts">
              @foreach ($posts as $post)
                <div class="col-md-4">
                  <article class="post clearfix mb-30 bg-lighter">
                    <div class="entry-header">
                      <div class="post-thumb thumb"> 
                        <img src="{{ asset($post->image) }}" alt="Image" class="img-responsive img-fullwidth" style="height: 250px;"> 
                      </div>
                    </div>
                    <div class="entry-content p-20 pr-10">
                      <div class="entry-meta media mt-0 no-bg no-border">
                        <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                          <ul>
                            <li class="font-16 text-white font-weight-600">{{ \Carbon\Carbon::parse($post->created_at)->format('d') }}</li>
                            <li class="font-12 text-white text-uppercase">{{ \Carbon\Carbon::parse($post->created_at)->format('M') }}</li>
                          </ul>
                        </div>
                        <div class="media-body pl-15" style="height: 90px;">
                          <div class="event-content pull-left flip">
                            <h5 class="entry-title text-white text-uppercase m-0 mt-5">
                              <a href="{{ url("blog/{$post->slug}") }}">{{ $post->title }}</a>
                            </h5>
                            <span class="mb-10 text-gray-darkgray mr-10 font-13">
                              <i class="fa fa-user mr-5 text-theme-colored"></i> Read by {{ $post->views }} 
                            </span>                      
                          </div>
                        </div>
                      </div>
                      {{-- <p class="mt-10">{!! Str::limit($post->body, 177, '[...]') !!}</p> --}}
                      <a href="{{ url("blog/{$post->slug}") }}" class="btn btn-default btn-sm btn-theme-colored mt-30">Read more</a>
                      <div class="clearfix"></div>
                    </div>
                  </article>
                </div>
              @endforeach
              <div class="col-md-12">
                <nav>
                  <ul class="pagination theme-colored">
                    {{ $posts->withQueryString()->links() }}
                  </ul>
                </nav>
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