<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | {{ Auth::user()->name }}</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="" />
		<meta property="og:url" content="{{ env('APP_URL') }}" />
		<meta property="og:site_name" content="{{ env('APP_NAME') }} | {{ env('APP_NAME') }}" />
		@include('layouts.admin.style')
	</head>
	<body 
        id="kt_app_body" 
        data-kt-app-layout="dark-sidebar" 
        data-kt-app-header-fixed="true" 
        data-kt-app-sidebar-enabled="true" 
        data-kt-app-sidebar-fixed="true" 
        data-kt-app-sidebar-hoverable="true" 
        data-kt-app-sidebar-push-header="true" 
        data-kt-app-sidebar-push-toolbar="true" 
        data-kt-app-sidebar-push-footer="true" 
        data-kt-app-toolbar-enabled="true" 
        class="app-default"
    >
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				@include('layouts.admin.header')
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					@include('layouts.admin.sidebar')
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<div class="d-flex flex-column flex-column-fluid">
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Profile</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Home</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">My Profile</li>
										</ul>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10">
										<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
											<div class="card mb-5 mb-xl-10">
												<div class="card-header">
													<div class="card-title m-0">
														<h3 class="fw-bolder m-0">Profile</h3>
													</div>
												</div>
												<div class="card-body mb-5 pb-0">
													<form method="post" id="profile_form" novalidate>
														<div class="row mb-5">
															<label for="name" class="fw-bold">Full name</label>
															<input type="text" name="name" id="name" class="form-control" placeholder="Your full name" value="{{ Auth::user()->name }}">
														</div>
														<div class="row mb-5">
															<label for="email" class="fw-bold">Email</label>
															<input type="email" name="email" id="email" class="form-control" placeholder="Your email address" value="{{ Auth::user()->email }}">														
														</div>
														<div class="row">
															<div class="col-md-12">
																<button
																	id="submit-btn" 
																	class="btn btn-sm btn-flex btn-primary"
																>Update Profile</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
											<div class="card mb-5 mb-xl-10">
												<div class="card-header">
													<div class="card-title m-0">
														<h3 class="fw-bolder m-0">Account Security</h3>
													</div>
												</div>
												<div class="card-body mb-5 pb-0">
													<form method="post" id="password_form" novalidate>
														<div class="row">
															<div class="form-group mb-3">
																<label for="old_password" class="fw-bold">Current Password</label>
																<input type="password" name="old_password" id="old_password" class="form-control" placeholder="Your current password">
															</div>
														</div>
														<div class="row">
															<div class="form-group mb-3">
																<label for="password" class="fw-bold">New Password</label>
																<input type="password" name="password" id="password" class="form-control" placeholder="Your new password">
															</div>
														</div>
														<div class="row">
															<div class="form-group mb-3">
																<label for="password_confirmation" class="fw-bold">Retype Password</label>
																<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype your new password">
															</div>
														</div>
														<div class="row">
															<div class="col-md-12">
																<button 
																	type="submit" 
																	id="password-btn" 
																	class="btn btn-sm btn-primary"
																>Update Security</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@include('layouts.admin.footer')
					</div>
				</div>
			</div>
		</div>
		@include('layouts.admin.script')
		<script>
			$("#profile_form").validate({
				rules: {
					fullname: { required: true, minlength: 3 },
					emai: { required: true }					
				},
				messages: {
					fullname: {
						required: "Enter your full name.",
						minlength: "Your full name can not be less than {0} characters."
					},					
					email: "Enter your email address."
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
				},
				submitHandler: function () {
					$.ajax({
						type: "POST",
						url: "{{ route('admin.update_profile') }}",
						data: $("#profile_form").serialize(),
						dataType: 'json',
						async: true,
						beforeSend: () => {
							$("#submit-btn").attr('disabled', true).html(`
								<div class="text-center">
									<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								</div>`
							);
						},
						success: (response) => {
							$("#submit-btn").attr('disabled', false).html('Update Profile');
							if (response.status == 200) {
								toastr.success(response.message, "success");
							} else {
								toastr.error(response.message, "error");
							}
						},
						error: (err) => {
							$("#submit-btn").attr('disabled', false).html('Update Profile');
							if (err.responseJSON) {
								toastr.error(err.responseJSON.message, 'error')
								return;
							}
							toastr.error(err.message, "error");
						}
					});
				}
			});

			$("#password_form").validate({
				rules: {
					old_password: { required: true },
					password: {
						required: true,
						minlength: 8,
						maxlength: 20,
					},
					password_confirmation: {
						minlength: 8,
						equalTo: "#password"
					},
				},
				messages: {
					old_password: "Enter your current password",
					password: {
						required: "Enter your new password",
						minlength: "Your password should be more than {0} characters.",
					},
					password_confirmation: "Password does not match"
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
				},
				submitHandler: function () {
					$.ajax({
						type: "POST",
						url: "{{ route('admin.update_security') }}",
						data: $("#password_form").serialize(),
						dataType: 'json',
						async: true,
						beforeSend: () => {
							$("#password-btn").attr('disabled', true).html(`
								<div class="text-center">
									<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								</div>`
							);
						},
						success: (response) => {
							$("#password-btn").attr('disabled', false).html('Update Security');
							if (response.status == 200) {
								toastr.success(response.message, "success");
								emptyForm('password_form');
							} else {
								toastr.error(response.message, "error");
							}
						},
						error: (err) => {
							$("#password-btn").attr('disabled', false).html('Update Security');
							if (err.responseJSON) {
								toastr.error(err.responseJSON.message, 'error')
								return;
							}
							toastr.error(err.message, "error");
						}
					});
				}
			});
		</script>
	</body>
</html>