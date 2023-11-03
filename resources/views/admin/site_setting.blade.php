<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Site Setting</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Site Settings</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Home</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">Site Setting</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3"></div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
										<div class="card">
											<div class="card-body">
												<form method="POST" id="setting_form" novalidate>
													<div class="row">
														<div class="form-group mb-3 col-md-6">
															<label for="opening_hour" class="fw-bolder">Opening Hour</label>
															<input type="time" name="opening_hour" id="opening_hour" placeholder="Choose opening hour" class="form-control" value="{{ $settings->opening_hour }}">
														</div>
														<div class="form-group mb-3 col-md-6">
															<label for="closing_hour" class="fw-bolder">Closing Hour</label>
															<input type="time" name="closing_hour" id="closing_hour" placeholder="Choose opening hour" class="form-control" value="{{ $settings->closing_hour }}">
														</div>
													</div>
													<div class="row">
														@foreach ($socials as $social => $value)
															<div class="form-group mb-3 col-md-3">
																<label for="social" class="fw-bolder">{{ ucfirst($social) }}</label>
																<input type="text" name="{{ $social }}" id="{{ $social }}" class="form-control" value="{{ $value }}" placeholder="Username" required>
															</div>
														@endforeach
													</div>
													<div class="row">
														@foreach ($numbers as $number => $value)
															<div class="form-group mb-3 col-md-6">
																<label 
																	for="{{ $number }}" 
																	class="fw-bolder"
																>{{ ucfirst("{$number} Number") }}</label>
																<input type="number" name="{{ $number }}" id="{{ $number }}" value="{{ $value }}" class="form-control" placeholder="080XXXXXXXX" min="0" minlength="11" maxlength="14" required>
															</div>
														@endforeach
													</div>
													<div class="row">
														<div class="form-group mb-3 col-md 12">
															<label for="address" class="fw-bolder">Address</label>
															<input type="text" name="address" id="address" placeholder="Address" class="form-control" value="{{ $settings->address }}">
														</div>
													</div>
													<button type="submit" id="setting_btn" class="btn btn-sm btn-primary">Update</button>
												</form>
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
			$("#setting_form").validate({
                rules: {
                    opening_hour: { required: true },
                    closing_hour: { required: true },
					address: { required: true }
                },
                messages: {
                    opening_hour: "Enter opening hour.",
                    closing_hour: "Enter closing hour.",
					address: "Enter address."
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
                        url: "{{ route('admin.update_setting') }}",
                        data: $("#setting_form").serialize(),
                        beforeSend: () => {
                            $("#setting_btn").attr("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                        },
                        success: (response) => {
                            $("#setting_btn").attr("disabled", false).html("Update");
                            if (response.status == 202) {
                                toastr.success(response.message, "success");
                            } else {
                                toastr.error(response.message, "error");
                            }
                        },
                        error: (err) => {
                            $("#setting_btn").attr("disabled", false).html("Update");
                            toastr.error(err.message, "error");
                        }
                    });
                }
            });
		</script>
	</body>
</html>