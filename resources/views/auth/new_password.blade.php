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
							<form class="form w-100" novalidate="novalidate" id="new_password_form" method="POST">
                                @csrf
								<div class="text-center mb-10">
									<img 
										src="{{ asset('assets/frontend/images/logos/logo.png') }}" 
										alt="" 
										srcset=""
										class="mb-3 img-responsive"
										height="55px"
									>
									<h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
									<div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ? 
									<a href="{{ route('login') }}" class="link-primary fw-bold">Sign in</a></div>
								</div>
								<div class="fv-row mb-8" data-kt-password-meter="true">
									<div class="mb-1">
										<div class="position-relative mb-3">
											<input 
                                                class="form-control bg-transparent" 
                                                type="password" 
                                                placeholder="Password" 
                                                name="password" 
                                                id="password"
                                                autocomplete="off" 
                                            />
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="bi bi-eye-slash fs-2"></i>
												<i class="bi bi-eye fs-2 d-none"></i>
											</span>
										</div>
										<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
										</div>
									</div>
									<div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
								</div>
								<div class="fv-row mb-8" data-kt-password-meter="true">
                                    <div class="position-relative mb-3">
                                        <input
                                            type="password" 
                                            placeholder="Repeat Password" 
                                            name="confirm_password" 
                                            id="confirm_password"
                                            autocomplete="off" 
                                            class="form-control bg-transparent" 
                                        />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                            <i class="bi bi-eye-slash fs-2"></i>
                                            <i class="bi bi-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" id="submit_btn" class="btn btn-primary">
										<span class="indicator-label">Submit</span>
									</button>
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

            $("#new_password_form").validate({
                rules: {
                    password: { required: true, minlength: 8, },
                    confirm_password: { minlength: 8, equalTo: "#password" }
                },
                messages: {
                    password: {
                        required: "The password field is required.",
                        minlength: "Minimum of {0} characters allowed."
                    },
                    confirm_password: "Password does not match."
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

            $("body").on("submit", "#new_password_form", function () {
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