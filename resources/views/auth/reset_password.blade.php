<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<title>{{ env("APP_NAME") }} | Reset Password</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content=" | " />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="{{ asset('assets/frontend/images/logos/logo.png') }}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="{{ asset('assets/backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/backend/plugins/custom/toastr/toastr.min.css') }}">
	</head>
	<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<style>body { background-image: url("{{ asset('assets/backend/media/auth/bg10.jpg')}}" ); } [data-theme="dark"] body { background-image: url("{{ asset('assets/backend/media/auth/bg10-dark.jpg') }}"); }</style>
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<div class="d-flex flex-column-fluid flex-lg-row-center justify-content-center justify-content-lg-center p-12">
					<div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10">
						<div class="w-md-400px">
							<form class="form w-100" novalidate="novalidate" id="password_reset_form" method="POST">
                                @csrf
								<div class="text-center mb-10">
									<img 
										src="{{ asset('assets/frontend/images/logos/logo.png') }}" 
										alt="" 
										srcset=""
										class="mb-3 img-responsive"
										height="55px"
									>
									<h1 class="text-dark fw-bolder mb-3">Forgot Password ?</h1>
									<div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
								</div>
								<div class="fv-row mb-8">
									<input 
                                        type="text" 
                                        placeholder="Email" 
                                        name="email" 
                                        autocomplete="off" 
                                        class="form-control bg-transparent" 
                                        value="{{ old('email') }}"
                                    />
								</div>
								<div class="d-flex flex-wrap justify-content-center pb-lg-0">
									<button type="submit" id="submit_btn" class="btn btn-primary me-4">
										<span class="indicator-label">Submit</span>
									</button>
									<a href="{{ route('login') }}" class="btn btn-light">Cancel</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
        <script src="{{ asset('assets/backend/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/backend/js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('assets/backend/plugins/custom/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('assets/backend/plugins/custom/jquery-validation/jquery.validate.min.js') }}"></script>
        <script>
            @if (Session::has('error'))
                $(window).ready(function () {
                    toastr.error("{{ session('error') }}", "error");
                });
            @endif

			@if (Session::has('success'))
				$(window).ready(function () {
					toastr.success("{{ session('success') }}", "success");
				});
			@endif

            $("#password_reset_form").validate({
                rules: {
                    email: { required: true }
                },
                messages: {
                    email: { required: "The email field is required." }
                },
                errorClass: "help-block",
				errorElement: "strong",
				onfocus:true,
				onblur:true,
				highlight: function(element){
					$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
				},
				unhighlight: function(element){
					$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
				},
				errorPlacement: function(error, element){
					if(element.parent('.input-group').length) {
						error.insertAfter(element.parent());
						return false;
					} else {
						error.insertAfter(element);
						return false;
					}
				}                
            });

            $("body").on("submit", "#password_reset_form", function () {
                $("#submit_btn").attr("disabled", true).html(`
                    <span>
                        Please wait... 
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                `);
            });
        </script>
	</body>
</html>