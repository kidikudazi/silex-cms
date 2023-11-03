<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Videos</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
											Videos
										</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Home</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">Videos</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a
                                            href="#" 
                                            class="btn btn-sm fw-bold btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#videoModal"
                                        ><i class="bi bi-film"></i> Add Video</a>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
                                    @if (count($videos))
                                        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                            @foreach ($videos as $video)
                                                <div class="col-md-4" id="video-{{ $video->id }}">
                                                    <div class="card">
                                                        <div class="card-img">
                                                            <iframe class="embed-responsive-item card-rounded h-275px w-100" src="{{ str_replace('watch?v=', 'embed/', $video->url) }}" allowfullscreen="allowfullscreen"></iframe>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="h-100 d-flex flex-column justify-content-between mb-lg-0 mb-5">
                                                                <div class="mb-3">
                                                                    <a class="fs-5 text-dark fw-bold text-hover-dark text-dark lh-base">{{ $video->title }}</a>
                                                                </div>
                                                                <div class="d-flex flex-stack flex-wrap">
                                                                    <div class="d-flex align-items-center pe-1">
                                                                        <div class="fs-5 fw-bold">
                                                                            <span class="text-muted">Posted on {{ \Carbon\Carbon::parse($video->created_at)->format('M d Y') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <a
                                                                            href="javascript:void(0);" 
                                                                            id="{{ $video->id }}" 
                                                                            class="text-hover-danger pull-right delete" 
                                                                            title="Delete Video" 
                                                                            data-toggle="tooltip"
                                                                        ><i class="fa fa-trash text-danger"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <x-zero-state :message="'No video(s) uploaded yet.'" />
                                    @endif
                                    @if (count($videos))
                                        <div class="row g-5 g-xl-10">
                                            <div class="text-center">
                                                {{ $videos->links() }}
                                            </div>
                                        </div>
                                    @endif
								</div>
							</div>
						</div>
						<div class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true" id="videoModal">
							<div class="modal-dialog modal-right">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Add Video</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<form method="POST" id="video_form" novalidate>
										<div class="modal-body">
											<div class="form-group mb-3">
												<label for="title" class="fw-bolder">Title</label>
												<input type="text" name="title" id="title" placeholder="Event Title" class="form-control">
											</div>
											<div class="form-group">
												<label for="url" class="fw-bolder">Video Link</label>
												<input type="url" name="url" id="url" placeholder="http://youtube.com/" class="form-control">
											</div>
										</div>
										<div class="modal-footer justify-content-between">
											<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
											<button type="submit" id="video_btn" class="btn btn-sm btn-primary">Create</button>
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
            jQuery.validator.addMethod("custom_url", function (value, element) {
                return /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/.test(value)
            }, "Please enter a valid youtube url.");

            $("#video_form").validate({
                rules: {
                    title: {
                        required: true,
                    },
                    url: {
                        required: true,
                        custom_url: true,
                    }
                },
                messages: {
                    title: "Video title is required.",
                    url: {
                        required: "Video streaming link is required."
                    }
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
                    let title = $("#title").val()
                    let url = $("#url").val()
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.upload_video') }}",
                        data: { title, url },
                        beforeSend: () => {
                            $("#video_btn").attr("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                        },
                        success: (response) => {
                            $("#video_btn").attr("disabled", false).html("Create");
                            if (response.status == 201) {
                                $("#videoModal").modal('hide');
                                emptyForm('video_form');
                                toastr.success(response.message, "success");
                                window.setTimeout(() => {
                                    window.location.reload();
                                }, 3000);
                            } else {
                                toastr.error(response.message, "error");
                            }
                        },
                        error: (err) => {
                            $("#video_btn").attr("disabled", false).html("Create");
                            toastr.error(err.message, "error");
                        }
                    });
                }
            });

            $("body").on("click", ".delete", function () {
                let video = this.id;
                if (video == null || video == "" || video.length < 1) {
                    return false;
                } else {
                    swal({
                        title: "Do you wish to proceed?",
                        text: "The selected video will be trashed completely.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('admin.delete_video') }}",
                                data: { video },
                                success: function (response) {
                                    if (response.status == 200) {
                                        toastr.success(response.message, "success");
                                        $(`#video-${video}`).remove();
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