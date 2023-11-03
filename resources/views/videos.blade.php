<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="ThemeMascot" />
  <title>{{ env("APP_NAME") }} | Videos</title>
  @include('layouts.website.style')
</head>
<body class="">
  <div id="wrapper">
    @include('layouts.website.preloader')
    <x-web-header />
    <div class="main-content">
      <section>
        <div class="container">
          <div class="row">
            @foreach ($videos as $video)
              <div class="col-md-6 mb-20">
                <div class="esc-heading lr-line left-heading">
                  <div class="heading-line-bottom">
                    <h4 class="heading-title">{{ $video->title }}</h4>
                  </div>
                </div>
                <div class="fluid-video-wrapper">
                  <iframe width="560" height="315" src="{{ str_replace('watch?v=', 'embed/', $video->url) }}"
                    allowfullscreen></iframe>
                </div>
              </div>
            @endforeach
          </div>
          <div class="row">
            <div class="col-md-12">
              @if (count($videos))
                <nav>
                  <ul class="pagination theme-colored">
                    {{ $videos->withQueryString()->links() }}
                  </ul>
                </nav>             
              @endif
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