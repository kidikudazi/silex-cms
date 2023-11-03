<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Manage Blog Posts</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Blog Posts</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Home</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">Manage Blog Posts</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a
                                            href="{{ route('admin.blog_post') }}" 
                                            class="btn btn-sm fw-bold btn-primary"
                                        ><i class="bi bi-file-earmark-richtext fs-3"></i> Create Blog Post</a>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
										<form id="blog_search" action="{{ route('admin.manage_blog_posts') }}" method="GET" novalidate>
											<div class="row">
												<div class="form-group col-md-6 offset-md-3">
													<div class="input-group mb-3">
														<input 
															type="text" 
															name="keyword" 
															id="keyword" 
															class="form-control" 
															placeholder="Search by title or author's name" 
															aria-label="Search by title or author's name" 
															aria-describedby="button-addon2" 
															value="{{ request()->has('keyword') ? request()->get('keyword') : '' }}"
														>
														<button class="btn btn-primary" type="submit" id="button-addon2">
															<i class="bi bi-search"></i>
														</button>
													</div>
												</div>
											</div>
										</form>
									</div>
									@if (count($posts))
										<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
											@foreach ($posts as $post)
												<div class="col-md-4" id="post-{{ $post->id }}">
													<div class="card">
														<div class="card-img">
															<img src="{{ $post->image }}" alt="" srcset="" class="card-rounded img-responsive min-h-175px" style="width: 100%; height: 90px;">
														</div>
														<div class="card-body mt-0 ps-5">
															<a
																class="fw-bold text-dark mb-4 fs-5 lh-base text-hover-primary"
																title="{{ $post->title }}"
															>
																{{ \Str::limit($post->title, 85, '[...]') }}
															</a>
															<div class="d-flex flex-stack flex-wrap">
																<div class="d-flex align-items-center pe-2">
																	<div class="fs-5 fw-bold">
																		<a 
																			href="{{ route('admin.manage_blog_posts', ['keyword' => $post->user->name ]) }}"
																			class="text-gray-700 text-hover-primary"
																		>
																			{{ $post->user->name}}
																		</a><br>
																		<span class="text-muted">{{ \Carbon\Carbon::parse($post->created_at)->format('M d Y') }}</span>
																	</div>
																</div>
																<div class="btn-group">
																	<a 
																		href="{{ route('admin.edit_blog_post', ['post' => $post->slug]) }}" class="text-hover-primary pull-left me-4" 
																		title="Edit Post" 
																		data-toggle="tooltip"
																	><i class="fa fa-edit text-primary"></i></a>
																	<a 
																		href="javascript:void(0);" 
																		id="{{ $post->id }}" 
																		class="text-hover-danger pull-right delete" 
																		title="Delete Post" 
																		data-toggle="tooltip"
																	><i class="fa fa-trash text-danger"></i></a>
																</div>
															</div>
														</div>
													</div>
												</div>
											@endforeach
										</div>
									@else
										<x-zero-state :message="'No blog post(s) created yet.'"/>
									@endif
									@if (count($posts))
										<div class="row g-5 g-xl-10">
											<div class="text-center">
												{{ $posts->links() }}
											</div>
										</div>
									@endif
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
			$("body").on("click", ".delete", function () {
                let post = this.id;
                if (post == null || post == "" || post.length < 1) {
                    return false;
                } else {
                    swal({
                        title: "Do you wish to proceed?",
                        text: "The selected blog post will be trashed completely.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('admin.delete_blog_post') }}",
                                data: {post: post},
                                success: function (response) {
                                    if (response.status == 200) {
                                        toastr.success(response.message, "success");
                                        $(`#post-${post}`).remove();
                                        window.setTimeout(() => {
                                            window.location.reload();
                                        }, 5000);
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