<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="ThemeMascot" />
  <title>{{ env("APP_NAME") }} | Our Team</title>
  @include('layouts.website.style')
</head>
<body class="">
  <div id="wrapper">
    @include('layouts.website.preloader')
    <x-web-header />
    <div class="main-content">
        <section class="inner-header divider parallax bg-black-222">
            <div class="container pt-10 pb-10">
                <div class="section-content">
                    <div class="row"> 
                        <div class="col-md-12">
                            <h3 class="text-white">Our Team Members</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        @foreach ($teams as $member)
                            <div class="col-sm-6 col-md-3 mb-30">
                                <div 
                                    class="team box-hover-effect effect3 border-1px border-bottom-theme-color-2px sm-text-center maxwidth400 mb-sm-30"
                                >
                                    <div class="thumb">
                                        <img class="img-fullwidth" src="{{ asset($member->image) }}" alt="{{ $member->name }}" style="height: 300px;">
                                    </div>
                                    <div class="content p-20 text-center">
                                        <h4 class="name mb-0 mt-0"><a class="text-theme-colored">{{ $member->name }}</a></h4>
                                        <p class="text-black">{{ $member->position }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if (count($teams))
                            <nav>
                                <ul class="pagination theme-colored">
                                    {{ $teams->withQueryString()->links() }}
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