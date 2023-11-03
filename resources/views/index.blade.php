<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0, user-scalable=no"/>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <title>{{ env("APP_NAME") }} | Home</title>
  @include('layouts.website.style')
</head>
<body class="">
  <div id="wrapper" class="clearfix">
    @include('layouts.website.preloader')
    <x-web-header />
    <div class="main-content">
      <section id="home">
        <div class="container-fluid p-0">
          <x-slider />
        </div>
      </section>
      <section class="layer-overlay overlay-theme-colored-8">
        <div class="container pt-0 pb-0">
          <div class="section-content">
            <div class="row" data-margin-top="-90px">
              <div class="col-sm-12 col-md-4">
                <div class="icon-box p-40 iconbox-theme-colored bg-white border-1px text-center" style="height: 300px;">
                  <a class="icon">
                    <i class="flaticon-charity-world-in-your-hands font-48 font-weight-100"></i>
                  </a>
                  <h4 class="text-uppercase mt-0">Knowledge in Nutrition</h4>
                  <p style="text-align: justify;">Our nutrition team are highly trained with extensive experience, ensuring specific and thorough knowledge.</p>
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="icon-box p-40 iconbox-theme-colored bg-white border-1px text-center" style="height: 300px;">
                  <a class="icon">
                    <i class="flaticon-charity-shaking-hands-inside-a-heart font-48 font-weight-100"></i>
                  </a>
                  <h4 class="text-uppercase mt-0">IMPROVE QUALITY OF LIFE</h4>
                  <p style="text-align: justify;">It is the team goal to have every patient living his or her best nutritional life in less time, improving their overall quality of life.</p>
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="icon-box p-40 iconbox-theme-colored bg-white border-1px text-center" style="height: 300px;">
                  <a class="icon">
                    <i class="flaticon-charity-child-hand-on-adult-hand font-48 font-weight-100"></i>
                  </a>
                  <h4 class="text-uppercase mt-0">PARTNERSHIP</h4>
                  <p style="text-align: justify;">We are in collaboration with the best hands to deliver quality and cost-effective nutrition services to our beneficairies in various locations.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="about">
        <div class="container">
          <div class="section-content">
            <div class="row">
              <div class="col-md-6 mt-20">
                <div class="row">
                  <div class="col-md-6 col-sm-6 pl-0">
                    <div class="img-hover-border mt-sm-40">
                      <img class="img-fullwidth" src="{{ asset('assets/frontend/images/about/d1.jpeg') }}" alt="">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 pl-0 pr-0">
                    <div class="img-hover-border mt-sm-30">
                      <img class="img-fullwidth" src="{{ asset('assets/frontend/images/about/d2.jpg') }}" alt="">
                    </div>
                    <div class="img-hover-border mt-15 mt-sm-30">
                      <img class="img-fullwidth" src="{{ asset('assets/frontend/images/about/a4.jpg') }}" alt="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="about-details">
                  <h2 class="font-36 mt-0">Quality Nutrition Services</h2>
                  <p class="font-18">We have taken it upon ourselves as a responsibility to provide sustainable nutrition services for pregnant and lactating women, adolescent girls, and children under the age of five across the state. We want to improve knowledge, attitudes and practices towards infants and young feeding children, improve material nutrition as well as decrease low birth weight and associated morbidities.</p>
                  <a href="{{ route('about') }}" class="btn btn-flat btn-colored btn-theme-colored mt-15 mr-15">
                    Read More
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="divider parallax layer-overlay overlay-dark-9" data-parallax-ratio="0.7">
        <div class="container pt-80 pb-80">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
              <div class="funfact text-center">
                <i class="pe-7s-smile mt-5 text-white"></i>
                <h2 data-animation-duration="2000" data-value="1054" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2>
                <h5 class="text-white text-uppercase font-weight-600">Happy Beneficairies</h5>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
              <div class="funfact text-center">
                <i class="pe-7s-rocket mt-5 text-white"></i>
                <h2 data-animation-duration="2000" data-value="75" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2>
                <h5 class="text-white text-uppercase font-weight-600">Projects</h5>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
              <div class="funfact text-center">
                <i class="pe-7s-add-user mt-5 text-white"></i>
                <h2 data-animation-duration="2000" data-value="248" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2>
                <h5 class="text-white text-uppercase font-weight-600">Volunteers</h5>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
              <div class="funfact text-center">
                <i class="pe-7s-global mt-5 text-white"></i>
                <h2 data-animation-duration="2000" data-value="21" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2>
                <h5 class="text-white text-uppercase font-weight-600">Location Covered</h5>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section>
        <div class="container pb-30">
          <div class="section-content">
            <div class="row">
              <div class="col-md-12 pb-sm-20">
                <h3 class="line-bottom mt-0">Our Mission</h3>
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="icon-box left media bg-silver-light border-1px border-theme-colored p-15 mb-20">
                      <a class="media-left pull-left flip">
                        <i class="flaticon-charity-shaking-hands-inside-a-heart text-theme-colored"></i>
                      </a>
                      <div class="media-body">
                        <h4 class="font-15 text-uppercase">Growth of the children</h4>
                        <p>We are out to combat micronutrient deficiency in children, improve maternal nutrition and decrease associated morbidities</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="icon-box left media bg-silver-light border-1px border-theme-colored p-15 mb-20">
                      <a class="media-left pull-left flip">
                        <i class="flaticon-charity-shelter text-theme-colored"></i>
                      </a>
                      <div class="media-body">
                        <h4 class="font-15 text-uppercase">Nutrition for speedy growth</h4>
                        <p>We are out to combat micronutrient deficiency in children, improve maternal nutrition and decrease associated morbidities</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="icon-box left media bg-silver-light border-1px border-theme-colored p-15 mb-20">
                      <a class="media-left pull-left flip">
                        <i class="flaticon-charity-responsible-use-of-water text-theme-colored"></i>
                      </a>
                      <div class="media-body">
                        <h4 class="font-15 text-uppercase">Nutrition</h4>
                        <p>We are out to combat micronutrient deficiency in children, improve maternal nutrition and decrease associated morbidities</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="icon-box left media bg-silver-light border-1px border-theme-colored p-15 mb-20">
                      <a class="media-left pull-left flip">
                        <i class="flaticon-charity-make-a-donation text-theme-colored"></i>
                      </a>
                      <div class="media-body">
                        <h4 class="font-15 text-uppercase">Nutrition for good health</h4>
                        <p>We are out to combat micronutrient deficiency in children, improve maternal nutrition and decrease associated morbidities</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="gallery" class="bg-silver-light">
        <div class="container">
          <div class="section-title text-center">
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <h2 class="text-uppercase line-bottom-center mt-0">
                  Photo <span class="text-theme-colored font-weight-600">Gallery</span>
                </h2>
                <p>We document our projects and outreach in visuals. <br> Take and deep dive and see the beauty of what we do.</p>
              </div>
            </div>
          </div>
          <div class="section-content">
            <div class="row">
              <div class="col-md-12">
                <div class="gallery-isotope grid-4 gutter-small clearfix" data-lightbox="gallery">
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
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="blog">
        <div class="container">
          <div class="section-title text-center">
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <h2 class="text-uppercase line-bottom-center mt-0">
                  Our <span class="text-theme-colored font-weight-600">Blog</span>
                </h2>
                <p>Everything you need to know about our programmes and new developments are well explaind in the blog section</p>
              </div>
            </div>
          </div>
          <div class="section-content">
            <div class="row">
              @foreach ($posts as $post)
                <div class="col-xs-12 col-sm-6 col-md-4">
                  <article class="post clearfix mb-sm-30 bg-silver-light">
                    <div class="entry-header">
                      <div class="post-thumb thumb"> 
                        <img src="{{ asset($post->image) }}" alt="" class="img-responsive img-fullwidth" style="height: 250px;"> 
                      </div>
                    </div>
                    <div class="bg-theme-colored p-5 text-center pt-10 pb-10">
                      <span class="mb-10 text-white mr-10 font-13">
                        <i class="fa fa-user mr-5 text-white"></i> Read by {{ $post->views }}
                      </span>
                    </div>
                    <div class="entry-content p-20 pr-10">
                      <div class="entry-meta media mt-0 no-bg no-border">
                        <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                          <ul>
                            <li class="font-16 text-white font-weight-600 border-bottom">{{ \Carbon\Carbon::parse($post->created_at)->format('d') }}</li>
                            <li class="font-12 text-white text-uppercase">{{ \Carbon\Carbon::parse($post->created_at)->format('M') }}</li>
                          </ul>
                        </div>
                        <div class="media-body pl-15" style="height: 75px;">
                          <div class="event-content pull-left flip">
                            <h5 class="entry-title text-white text-uppercase m-0 mt-5">
                              <a href="{{ url("blog/$post->slug") }}">{{ $post->title }}</a>
                            </h5>
                          </div>
                        </div>
                      </div>
                      {{-- <p class="mt-10">Lorem ipsum dolor sit amet, consectetur adipisi cing elit. Molestias eius illum libero dolor nobis deleniti, sint assumenda. Pariatur iste veritatis excepturi, ipsa optio nobis.</p> --}}
                      <a href="{{ url("blog/$post->slug") }}" class="btn btn-default btn-sm btn-theme-colored mt-30">Read more</a>
                    </div>
                  </article>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </section>
      <section class="clients">
        <div class="container pt-0 pb-0">
          <div class="row">
            <div class="section-title text-center">
              <div class="row">
                <div class="col-md-10 col-md-offset-1">
                  <h2 class="text-uppercase line-bottom-center mt-0">
                    Our <span class="text-theme-colored font-weight-600">Partners</span>
                  </h2>
                  <p>We are in collaboration with the best hands to provide quality nutrition services.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="owl-carousel-6col clients-logo text-center">
                @foreach ($partners as $partner)
                  <div class="mb-30">
                    <a>
                      <img 
                        src="{{ asset($partner->image) }}" 
                        alt="Partner Image" 
                        style="width: auto; height: 100%;"
                      >
                    </a>
                  </div>
                @endforeach
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