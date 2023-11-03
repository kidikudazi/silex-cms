<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Partner</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Partners</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Home</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">Partners</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a
                                            href="#" 
                                            class="btn btn-sm fw-bold btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addPartnerModal"
                                        ><i class="fa fa-handshake"></i> Add Partner</a>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
										@if (count($partners))
											<div class="card">
												<div class="card-body">
													<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 gy-10">
														@foreach ($partners as $partner)
															<div class="col text-center mb-9" id="partner-{{ $partner->id }}">
																<div class="octagon mx-auto mb-2 d-flex w-150px h-150px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url('{{ asset($partner->image) }}')"></div>
																<div class="mb-0">
																	<a class="text-dark fw-bold text-hover-dark fs-3">{{ $partner->name }}</a>
																	<br>
																	<a
																		href="javascript:void(0);" 
																		id="{{ $partner->id }}" 
																		class="text-hover-danger text-danger pull-right delete" 
																		title="Remove Partner" 
																		data-toggle="tooltip"
																	><i class="fa fa-times text-danger"></i> Remove</a>
																</div>
															</div>
														@endforeach
													</div>
												</div>
											</div>
										@else
											<x-zero-state :message="'No partner added yet.'"/>
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true" id="addPartnerModal">
							<div class="modal-dialog modal-right">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Partner</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<form method="POST" id="partner_form" novalidate enctype="multipart/form-data">
										<div class="modal-body">
											<div class="form-group mb-3">
												<label for="name" class="fw-bolder">Name</label>
												<input type="text" name="name" id="name" placeholder="Name" class="form-control">
											</div>
											<div class="form-group">
												<label for="image" class="fw-bolder">Image</label>
												<input type="file" name="image" id="image" placeholder="Choose file to upload" class="form-control" accept="image/jpeg, image/png, image/jpg, image/gif">
											</div>
										</div>
										<div class="modal-footer justify-content-between">
											<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
											<button type="submit" id="partner_btn" class="btn btn-sm btn-primary">Add Partner</button>
										</div>
									</form>
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
			$("#partner_form").validate({
                rules: {
					name: { required: true },
                    image: { required: true }
                },
                messages: {
					name: "Enter member name.",
                    image: "Choose image file to upload."
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
					const form = $("#partner_form")[0];
					let data = new FormData(form);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.create_partner') }}",
                        data: data,
						processData: false,
                        contentType: false,
                        beforeSend: () => {
                            $("#partner_btn").attr("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                        },
                        success: (response) => {
                            $("#partner_btn").attr("disabled", false).html("Add Partner");
                            if (response.status == 201) {
                                $("#addPartnerModal").modal('hide');
								emptyForm("partner_form");
                                toastr.success(response.message, "success");
                                window.setTimeout(() => {
                                    window.location.reload();
                                }, 3000);
                            } else {
                                toastr.error(response.message, "error");
                            }
                        },
                        error: (err) => {
                            $("#team_btn").attr("disabled", false).html("Add Partner");
                            toastr.error(err.message, "error");
                        }
                    });
                }
            });

			$("body").on("click", ".delete", function () {
                let partner = this.id;
                if (partner == null || partner == "" || partner.length < 1) {
                    return false;
                } else {
                    swal({
                        title: "Do you wish to proceed?",
                        text: "The selected partner will be removed from the list.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('admin.delete_partner') }}",
                                data: { partner },
                                success: function (response) {
                                    if (response.status == 200) {
                                        toastr.success(response.message, "success");
                                        $(`#partner-${partner}`).remove();
                                        window.setTimeout(() => {
                                            window.location.reload();
                                        }, 3000);
                                    } else {
                                        toastr.error(response.message, "error");
                                    }
                                },
                                error: function (error) {
                                    toastr.error(error.message, "error");
                                }
                            });
                        }
                    });
                }
            });
		</script>
	</body>
</html>