<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Dashboard</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Home</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Admin</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">Dashboard</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3"></div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
										<div class="col-xl-4 mb-xl-10">
											<div class="card card-flush h-xl-100">
												<div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" style="background-image:url('{{ asset('assets/backend/media/svg/shapes/top-green.png') }}')">
													<h3 class="card-title align-items-start flex-column text-white pt-15">
														<span class="fw-bolder fs-2x mb-3">Hello, {{ Auth::user()->name }}</span>
														<div class="fs-4 text-white">
															<span class="opacity-75">Welcome Back!</span>			
														</div>
													</h3>
												</div>
												<div class="card-body mt-n20">
													<div class="mt-n20 position-relative">
														<div class="row g-3 g-lg-6">
															<div class="col-6">
																<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<span class="svg-icon svg-icon-1 svg-icon-primary">
																				<i class="fa fa-user fs-1 text-success"></i>
																			</span>
																		</span>
																	</div>
																	<div class="m-0">
																		<span class="text-gray-700 fw-boldest d-block fs-2qx lh-1 ls-n1 mb-1">
																			{{ $admins }}
																		</span>
																		<span class="text-gray-500 fw-bold fs-6">Admins</span>
																	</div>
																</div>
															</div>
															<div class="col-6">
																<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<span class="svg-icon svg-icon-1 svg-icon-primary">
																				<i class="fa fa-newspaper fs-1 text-success"></i>
																			</span>
																		</span>
																	</div>
																	<div class="m-0">
																		<span class="text-gray-700 fw-boldest d-block fs-1 lh-1 ls-n1 mb-1">
																			{{ $blog_posts }}
																		</span>
																		<span class="text-gray-500 fw-bold fs-6">Blog Posts</span>
																	</div>
																</div>
															</div>
															<div class="col-6">
																<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<span class="svg-icon svg-icon-1 svg-icon-primary">
																				<i class="fa fa-handshake fs-1 text-success"></i>
																			</span>
																		</span>
																	</div>
																	<div class="m-0">
																		<span class="text-gray-700 fw-boldest d-block fs-1 lh-1 ls-n1 mb-1">
																			{{ $partners }}
																		</span>
																		<span class="text-gray-500 fw-bold fs-6">Partners</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-8 mb-5 mb-xl-10">
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
	</body>
</html>