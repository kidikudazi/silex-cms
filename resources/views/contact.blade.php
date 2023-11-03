<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <title>{{ env("APP_NAME") }} | Contact</title>
  @include('layouts.website.style')
</head>
<body class="">
<div id="wrapper" class="clearfix">
  @include('layouts.website.preloader')
  <x-web-header />
  <div class="main-content">
    <section class="divider">
      <div class="container pt-60 pb-60">
        <div class="section-title mb-60">
          <div class="row">
            <div class="col-md-12">
              <div class="esc-heading small-border text-center">
                <h3>Have any Questions?</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="section-content">
          <div class="row">
            <div class="col-sm-12 col-md-4">
              <div class="contact-info text-center">
                <i class="fa fa-phone font-36 mb-10 text-theme-colored"></i>
                <h4>Call Us</h4>
                @foreach (json_decode($siteSetting->phone_numbers) ?? [] as $item)                    
                  <h6 class="text-gray"><a href="tel:{{ $item }}">{{ $item }}</a></h6>
                @endforeach
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="contact-info text-center">
                <i class="fa fa-map-marker font-36 mb-10 text-theme-colored"></i>
                <h4>Address</h4>
                <h6 class="text-black">{{ $siteSetting->address ?? "" }}</h6>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="contact-info text-center">
                <i class="fa fa-envelope font-36 mb-10 text-theme-colored"></i>
                <h4>Email</h4>
                <h6 class="text-black">{{ env('APP_MAIL') }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="contact" class="divider bg-lighter">
      <div class="container-fluid pt-0 pb-0">
        <div class="section-content">
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div class="contact-wrapper">
                <h3 class="line-bottom mt-0 mb-20">Interested in discussing?</h3>
                <p class="mb-30">Got a message for us? Fill the form below. We'll get back to you.</p>
                <form id="contact_form" name="contact_form" class="form" method="post">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="form_name">Name <small>*</small></label>
                        <input name="name" class="form-control required" type="text" placeholder="Enter Name">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="form_email">Email <small>*</small></label>
                        <input name="email" class="form-control required email" type="email" placeholder="Enter Email">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="form_name">Subject <small>*</small></label>
                        <input name="subject" class="form-control required" type="text" placeholder="Enter Subject">
                      </div>
                    </div>                    
                  </div>
                  <div class="form-group">
                    <label for="form_name">Message</label>
                    <textarea name="message" class="form-control required" rows="5" placeholder="Enter Message"></textarea>
                  </div>
                  <div class="form-group">
                    <input name="form_botcheck" class="form-control" type="hidden" value="" />
                    <button type="submit" class="btn btn-dark btn-theme-colored btn-flat mr-5" data-loading-text="Please wait...">Send your message</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-sm-12 col-md-6 bg-img-center bg-img-cover p-0" data-bg-img="images/bg/bg1.jpg">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.1311783843475!2d4.567852214211576!3d8.486624099585573!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10364d6446b68aa1%3A0xcb663f2186e68501!2sKwara%20State%20Government%20Secretariat!5e0!3m2!1sen!2sng!4v1666193842938!5m2!1sen!2sng" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  @include('layouts.website.footer')
</div>
@include('layouts.website.script')
<script type="text/javascript">
  $("#contact_form").validate({
    submitHandler: function(form) {
      var form_btn = $(form).find('button[type="submit"]');
      var form_result_div = '#form-result';
      $(form_result_div).remove();
      var form_btn_old_msg = form_btn.html();
      form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
      $.ajax({
        type: "POST",
        url: "{{ route('contact_message') }}",
        data: $(form).serialize(),
        dataType: 'json',
        success: function (response) {
          form_btn.prop('disabled', false).html(form_btn_old_msg);
          if (response.status == 200) {
            form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
            $(form).find('.form-control').val('');
            $(form_result_div).html(response.message).fadeIn('slow');
            setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
          } else {
            form_btn.before('<div id="form-result" class="alert alert-danger" role="alert" style="display: none;"></div>');
            $(form_result_div).html(response.message).fadeIn('slow');
            setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
          }
        },
        error: function (error) {
          form_btn.prop('disabled', false).html(form_btn_old_msg);
          form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
          $(form_result_div).html(error.message).fadeIn('slow');
          setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
        }
      });
    }
  });
</script>
</body>
</html>