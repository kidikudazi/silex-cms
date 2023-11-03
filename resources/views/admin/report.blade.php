<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Reports</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Reports</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Nutrition Report</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">Reports</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a
                                            href="#" 
                                            class="btn btn-sm fw-bold btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#report_modal"
                                        ><i class="fa fa-plus"></i> Add Report</a>
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
																<th class="fw-bolder">Category</th>
																<th class="fw-bolder">Year</th>
																<th class="fw-bolder">Last Modified</th>
																<th class="fw-bolder">Action</th>
															</tr>
														</thead>
														<tbody>
															@foreach ($reports as $report)
																<tr>
																	<td>{{ $loop->iteration }}.</td>
																	<td>{{ $report->title }}</td>
																	<td>{{ $report->report_category->title }}</td>
																	<th>{{ $report->year }}</th>
																	<td>{{ \Carbon\Carbon::parse($report->updated_at)->format('jS M Y') }}</td>
																	<td class="btn btn-sm btn-group">
																		<a
																			href="javascript:void(0);" 
																			class="btn btn-primary btn-sm btn-rounded me-3 edit" 
																			title="Edit Report"
																			id="{{ $report->id }}"
																		>
																			<i class="fa fa-edit"></i> Edit
																		</a>
																		<a
																			href="javascript:void(0);" 
																			class="btn btn-danger btn-sm btn-rounded me-3 delete" 
																			title="Delete Report"
																			id="{{ $report->id }}"
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
		<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="report_modal">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Report</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" id="report_form" novalidate enctype="multipart/form-data">
						<input type="hidden" name="report" id="report">
						<div class="modal-body">
							<div class="row mb-3">
								<div class="col-md-12">
									<div class="form-group">
										<label for="category" class="fw-bold required">Category</label>
										<select name="category" id="category" class="form-control">\
											<option value="">-- Select Category --</option>
											@foreach ($categories as $category)
												<option value="{{ $category->id }}">{{ $category->title }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-12">
									<div class="form-group">
										<label for="title" class="fw-bold required">Title</label>
										<input type="text" name="title" id="title" placeholder="Category title" class="form-control">
									</div>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-12">
									<div class="form-group">
										<label for="year" class="fw-bold required">Year</label>
										<select name="year" id="year" class="form-control">
											<option value="">-- Select Year --</option>
											@foreach (range(0, $year) as $item)
												@if ($item)
													<option value="{{ $item + 2001	 }}">{{ $item + 2001	 }}</option>
												@endif
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-12">
									<div class="form-group">
										<label for="document" class="fw-bold required">Document</label>
										<input type="file" name="document" id="document" placeholder="Choose file" class="form-control" accept="application/pdf,application/msword,application/docx,application/doc">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button
								type="button" 
								id="close-btn" 
								class="btn btn-sm btn-danger" 
								data-bs-dismiss="modal"
							>
								<i class="fa fa-times"></i> Close
							</button>
							<button 
								type="submit" 
								id="submit-btn" 
								class="btn btn-sm btn-primary"
							><i class="fa fa-save"></i>	Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		@include('layouts.admin.script')
		<script>
			let selected;
			let reportModal = new bootstrap.Modal(document.getElementById('report_modal'), {
  				keyboard: false,
				backdrop: 'static',
			});

			$("#report_form").validate({
				rules: {
					category: { required: true },
					title: {
						required: true,
						minlength: 3,
					},
					year: { required: true },
					document: {
						required: function (element) {
							return (selected) ? false : true
						}
					}
				},
				messages: {
					category: "Select report category.",
					title: {
						required: "Enter report title.",
						minlength: "Report title be longer than {0} characters."
					},
					year: "Select report year.",
					document: {
						required: "Choose report document to upload."
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
					let form = $("#report_form")[0];
					let data = new FormData(form);
					if (!selected) {
						$.ajax({
							type: "POST",
							url: "{{ route('admin.create_report') }}",
							data: data,
							processData: false,
                        	contentType: false,
							beforeSend: () => {
								$("#submit-btn").attr('disabled', true).html(`
									<div class="text-center">
										<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									</div>`
								);
							},
							success: (response) => {
								$("#submit-btn").attr('disabled', false).html('<i class="fa fa-save"></i> Save');
								if (response.status == 201) {
									reportModal.hide();
									emptyForm('report_form');
									loadRecords(response.data, [
										{
											'data': null, 'render': (data, type, row, meta) => {
												return meta.row + meta.settings._iDisplayStart + 1 +'.'
											}
										},
										{'data': 'title'},
										{'data': 'category'},
										{'data': 'year'},
										{'data': 'last_modified'},
										{
											'data': null, 'render': (full, type, row, meta) => {
												return `
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-primary btn-sm btn-rounded edit" title="Edit Report"><i class="fa fa-edit"></i> Edit</a>
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-danger btn-sm btn-rounded delete" title="Delete Report"><i class="fa fa-trash"></i> Delete</a>
												`;
											}
										}
									]);
									toastr.success(response.message, "Success");
								} else {
									toastr.error(response.message, "Error");
								}
							},
							error: (err) => {
								$("#submit-btn").attr('disabled', false).html('Save');
								if (err.responseJSON) {
									toastr.error(err.responseJSON.message, 'error')
									return;
								}
								toastr.error(err.message, "Error");
							}
						});
					} else {
						$.ajax({
							type: "POST",
							url: "{{ route('admin.update_report') }}",
							data: data,
							processData: false,
                        	contentType: false,
							beforeSend: () => {
								$("#submit-btn").attr('disabled', true).html(`
									<div class="text-center">
										<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									</div>`
								);
							},
							success: (response) => {
								$("#submit-btn").attr('disabled', false).html('<i class="fa fa-save"></i> Save');
								if (response.status == 202) {
									reportModal.hide();
									emptyForm('report_form');
									loadRecords(response.data, [
										{
											'data': null, 'render': (data, type, row, meta) => {
												return meta.row + meta.settings._iDisplayStart + 1 +'.'
											}
										},
										{'data': 'title'},
										{'data': 'category'},
										{'data': 'year'},
										{'data': 'last_modified'},
										{
											'data': null, 'render': (full, type, row, meta) => {
												return `
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-primary btn-sm btn-rounded edit" title="Edit Report"><i class="fa fa-edit"></i> Edit</a>
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-danger btn-sm btn-rounded delete" title="Delete Report"><i class="fa fa-trash"></i> Delete</a>
												`;
											}
										}
									]);
									selected = null;
									toastr.success(response.message, "Success");
								} else {
									toastr.error(response.message, "Error");
								}
							},
							error: (err) => {
								$("#submit-btn").attr('disabled', false).html('Save');
								if (err.responseJSON) {
									toastr.error(err.responseJSON.message, 'error')
									return;
								}
								toastr.error(err.message, "Error");
							}
						});
					}
				}
			});

			$("body").on("click", ".edit", function () {
				let report = this.id;
				if (report.length < 1 || report == null || report == "") return false
				$.ajax({
					type: "GET",
					url: "{{ route('admin.edit_report') }}",
					data: { report },
					success: (response) => {
						if (response.status == 200) {
							selected = response.data.id;
							$("#report").val(parseInt(response.data.id));
							setForm("report_form", response.data);
							reportModal.show();
						} else {
							toastr.error(response.message, "error");
						}						
					},
					error: (err) => {
						if (err.responseJSON) {
							toastr.error(err.responseJSON.message, 'error')
							return;
						}
						toastr.error(err.message, "error");
					}
				}); 
			});

			$("body").on("click", ".delete", function () {
				let report = this.id;
				if (report.length && report != null && report != "") {
					swal({
						title: "Do you wish to proceed?",
						text: `The selected report will be deleted completely.`,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					}).then((willDelete) => {
						if (willDelete) {
							$.ajax({
								type: "DELETE",
								url: "{{ route('admin.delete_report') }}",
								data: { report },
								beforeSend: function () {
									$(this).attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
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
											{'data': 'category'},
											{'data': 'year'},
											{'data': 'last_modified'},
											{
												'data': null, 'render': (full, type, row, meta) => {
													return `
														<a href="javascript:void(0);" id="${full['id']}" class="btn btn-primary btn-sm btn-rounded edit" title="Edit Report"><i class="fa fa-edit"></i> Edit</a>
														<a href="javascript:void(0);" id="${full['id']}" class="btn btn-danger btn-sm btn-rounded delete" title="Delete Report"><i class="fa fa-trash"></i> Delete</a>
													`;
												}
											}
										]);
									} else {
										toastr.error(response.message, "error");
									}
								},
								error: function (error) {
									if (err.responseJSON) {
										toastr.error(err.responseJSON.message, 'error')
										return;
									}
									toastr.error(err.message, "Error");
								}
							});
						}
					});
				}
			});
		</script>
	</body>
</html>