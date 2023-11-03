<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <title>{{ env("APP_NAME") }} | {{ '' }}</title>
  @include('layouts.website.style')
</head>
<body class="">
  <div id="wrapper" class="clearfix">
    @include('layouts.website.preloader')
    <x-web-header />
    <div class="main-content">
      <section 
        class="inner-header bg-black-222" 
        data-bg-img="{{ asset('assets/frontend/images/bg/bg1.jpg') }}"
      >
        <div class="container pt-10 pb-10">
          <div class="section-content">
            <div class="row"> 
              <div class="col-md-12">
                <h3 class="text-white">{{ $data->title }}</h3>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section>
        <div class="container">
          <div class="row multi-row-clearfix">
            {!! $data->content !!}
          </div>
        </div>
      </section>
    </div>
    @include('layouts.website.footer')
  </div>
  @include('layouts.website.script')
</body>
</html>