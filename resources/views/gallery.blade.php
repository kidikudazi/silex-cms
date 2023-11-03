<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <title>{{ env("APP_NAME") }} | Gallery</title>
  @include('layouts.website.style')
</head>
<body class="">
<div id="wrapper" class="clearfix">
  @include('layouts.website.preloader')
  <x-web-header />
  <div class="main-content">
    <section>
      <div class="container-fluid pb-0">
        <div class="section-content">
          <div class="row">
            <div class="col-md-12">
              <div id="grid" class="gallery-isotope grid-4 gutter clearfix mb-5" data-lightbox="gallery">
                @foreach ($galleries as $gallery)    
                  <div class="gallery-item">
                    <div class="thumb">
                      <img alt="project" src="{{ asset($gallery->url) }}" class="img-fullwidth">
                      <div class="overlay-shade"></div>
                      <div class="icons-holder">
                        <div class="icons-holder-inner">
                          <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                            <a href="{{ asset($gallery->url) }}"  data-lightbox-gallery="gallery"><i class="fa fa-picture-o"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <h5 class="text-center mt-15 mb-40">{{ $gallery->caption }}</h5>
                  </div>
                @endforeach
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