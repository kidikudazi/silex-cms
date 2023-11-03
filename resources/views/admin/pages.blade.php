<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Pages</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Pages</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Page Builder</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">Manage Pages</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a
                                            href="{{ route('admin.add_page') }}" 
                                            class="btn btn-sm fw-bold btn-primary"
                                        ><i class="bi bi-journal-richtext"></i> Add Page</a>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
										<div class="card mb-5 mb-xl-10">
											<div class="card-body">
												<div class="table-responsive">
													<table 
														id="datatable" 
														class="table table-bordered table-condensed table-striped display nowrap" 
														style="width: 100%"
													>
														<thead>
															<tr>
																<th class="fw-bolder">#</th>
																<th class="fw-bolder">Title</th>
																<th class="fw-bolder">Menu</th>
																<th class="fw-bolder">Action</th>
															</tr>
														</thead>
														<tbody>
															@foreach ($pages as $page)
																<tr>
																	<td>{{ $loop->iteration }}.</td>
																	<td>{{ $page->title }}</td>
																	<td>{{ $page->menu->title }}</td>
																	<td class="btn btn-sm btn-group">
																		<a
																			href="{{ url("admin/page/edit/{$page->uuid}") }}" 
																			class="btn btn-primary btn-sm btn-rounded me-3 edit" 
																			title="Manage Content"
																			id="{{ $page->uuid }}"
																		>
																			<i class="fa fa-edit"></i> Manage Content
																		</a>
																		<a
																			href="javascript:void(0);" 
																			class="btn btn-danger btn-sm btn-rounded me-3 delete" 
																			title="Delete Page"
																			id="{{ $page->uuid }}"
																		>
																			<i class="fa fa-trash"></i> Delete
																		</a>		
																	</td>
																</tr>
															@endforeach
														</tbody>
													</table>
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
			$("body").on("click", ".delete", function () {
                let page = this.id;
                if (page == null || page == "" || page.length < 1) {
                    return false;
                } else {
                    swal({
                        title: "Do you wish to proceed?",
                        text: "The selected page will be trashed completely.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('admin.delete_page') }}",
                                data: {uuid: page},
								beforeSend: function () {
									$(this).attr("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
								},
                                success: function (response) {
                                    if (response.status == 200) {
                                        toastr.success(response.message, "success");
										loadRecords(response.data, [
											{
												'data': null, 'render': (data, type, row, meta) => {
													return meta.row + meta.settings._iDisplayStart + 1 +'.'
												}
											},
											{'data': 'title'},
											{'data': 'menu'},
                                            {
												'data': null, 'render': (full, type, row, meta) => {
													return `
                                                        <a
                                                            href="/admin/page/edit/${full['uuid']}" 
                                                            class="btn btn-primary btn-sm btn-rounded me-3 edit" 
                                                            title="Manage Content"
                                                            id="${full['uuid']}"
                                                        >
                                                            <i class="fa fa-edit"></i> Manage Content
                                                        </a>
                                                        <a
                                                            href="javascript:void(0);" 
                                                            class="btn btn-danger btn-sm btn-rounded me-3 delete" 
                                                            title="Delete Menu"
                                                            id="${full['uuid']}"
                                                        >
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
													`;
												}
											}
										]);
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