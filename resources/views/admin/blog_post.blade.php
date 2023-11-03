<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Blog Post</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Blog Post</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Home</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">
												{{ (!empty($edit)) ? 'Edit Blog Post' : 'Create Blog Post' }}
											</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a
                                            href="{{ route('admin.manage_blog_posts') }}" 
                                            class="btn btn-sm fw-bold btn-primary"
                                        ><i class="bi bi-file-earmark-richtext fs-3"></i> Manage Blog Posts</a>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
										<div class="card mb-5 mb-xl-10">
											<div class="card-header cursor-pointer">
												<div class="card-title m-0">
													<h4 class="fw-bolder m-0">Blog Post</h4>
												</div>												
											</div>
											<div class="card-body">
												<form id="blog_post" method="post" novalidate enctype="multipart/form-data">
													@csrf
													<div class="form-group mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
														<label for="title" class="fw-bolder">Title</label>
														<input type="text" name="title" id="title" placeholder="Blog title" value="{{ (!empty($edit)) ? $edit->title : old('title') }}" class="form-control">
														@if ($errors->has('title'))
															<span class="help-block">
																<strong>{{ $errors->first('title') }}</strong>
															</span>
														@endif
													</div>
													<div class="form-group mb-3 {{ $errors->has('image') ? 'has-error' : '' }}">
														<label for="image" class="fw-bolder">Image</label>
														<input type="file" name="image" id="image" placeholder="Choose a file" class="form-control" accept="image/jpeg, image/jpg, image/png, image/gif">
														@if ($errors->has('image'))
															<span class="help-block">
																<strong>{{ $errors->first('image') }}</strong>
															</span>
														@endif
													</div>
													<div class="form-group mb-3 {{ $errors->has('body') ? 'has-error' : '' }}">
														<label for="body" class="fw-bolder">Content</label>
														<textarea name="body" id="compose-area" cols="30" rows="10" class="summernote form-control" style="resize: none;">{{ (!empty($edit)) ? $edit->body : old('body') }}</textarea>
														@if ($errors->has('body'))
															<span class="help-block">
																<strong>{{ $errors->first('body') }}</strong>
															</span>
														@endif
													</div>
													<div class="form-group">
														<button id="post_btn" class="btn btn-sm btn-primary">
															<i class="bi bi-save"></i> {{ (!empty($edit)) ? 'Update' : 'Create' }}
														</button>
													</div>
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
			$("#blog_post").validate({
                ignore: 'hidden:not(.summernote),.note-editable.card-block',
                rules: {
                    title: { required: true },
                    body: { required: true },
                    @if (empty($edit))
                        image: { required: true },
                    @endif
                },
                messages: {
                    title: "Blog post title is required.",
                    body: "Blog post content is required.",
                    @if (empty($edit))
                        image: "Blog post image is required.",
                    @endif
                },
                errorClass: "help-block",
                errorElement: "strong",
                onfocus:true,
                onblur:true,
                highlight:function(element){
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight:function(element){
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorPlacement:function(error, element){
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                        return false;
                    } else if (element.hasClass('summernote')) {
                        error.insertAfter(element.siblings(".note-editor"));
                        return false;
                    } else {
                        error.insertAfter(element);
                        return false;
                    }
                },
            });

            $("body").on("submit", "#blog_post", function() {
                $("#post_btn").attr("disabled", true).html(`
					<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
				`);
            });
		</script>
	</body>
</html>