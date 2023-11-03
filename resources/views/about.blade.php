<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <title>{{ env("APP_NAME") }} | About</title>
  @include('layouts.website.style')
</head>
<body class="">
  <div id="wrapper" class="clearfix">
    @include('layouts.website.preloader')
    <x-web-header />
    <div class="main-content">
      <section>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="meet-doctors">
                <h2 class="font-36 mt-10">
                  CMS
                </h2>
                <p class="mb-30">
                  A easy and swift content management system.
                </p>
              </div>
            </div>            
          </div>
        </div>
      </section>
      <section class="bg-lighter">
        <div class="container pt-50">
          <div class="section-content">
            <div class="row">
              <div class="col-md-12">
                <h3 class="line-bottom">Our Vision</h3>
                <p class="lead font-20">Lorem ipsum dolor sit amet, <span class="text-theme-colored">Crowdfunding</span>
                  adipisicing elit. Adipisci maxime, mollitia cumque dolore itaque!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore maxime, sapiente fugiat molestias.
                  Tempora, voluptatum repudiandae dignissimos, dicta voluptate placeat a. Ipsum quaerat quasi quia
                  deserunt enim dicta.Lorem ipsum dolor sit amet, consectetur adipisicing.Lorem ipsum dolor sit amet,
                  consectetur adipisicing elit. Tempore maxime, sapiente fugiat molestias. Tempora, voluptatum
                  repudiandae dignissimos, dicta voluptate placeat a. Ipsum quaerat quasi quia.
                </p>
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
    </div>
    @include('layouts.website.footer')
  </div>
  @include('layouts.website.script')
</body>
</html>