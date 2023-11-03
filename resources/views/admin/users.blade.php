<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Users</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Users Account</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Home</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">User Account</li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">										
										<a
                                            href="#" 
                                            class="btn btn-sm fw-bold btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#userModal"
                                        >
											<i class="fa fa-plus"></i> Add User
										</a>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
										<div class="card mb-5 mb-xl-10">
											<div class="card-header cursor-pointer">
												<div class="card-title m-0">
													<h3 class="fw-bolder m-0">Users</h3>
												</div>												
											</div>
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
																<th class="fw-bolder">Full Name</th>
																<th class="fw-bolder">Email</th>
																<th class="fw-bolder">Role</th>
																<th class="fw-bolder">Action</th>
															</tr>
														</thead>
														<tbody>
															@foreach ($users as $user)
																<tr>
																	<td>{{ $loop->iteration }}.</td>
																	<td>{{ $user->name }}</td>
																	<td>{{ $user->email }}</td>
																	<td>{{ ucwords(str_replace('_', ' ', $user->user_role->type)) }}</td>
																	<td class="btn btn-sm btn-group">
																		<a
																			href="javascript:void(0);" 
																			class="btn btn-primary btn-sm btn-rounded me-3 edit" 
																			title="Edit User"
																			id="{{ $user->id }}"
																		>
																			<i class="fa fa-edit"></i> Edit
																		</a>
																		<a
																			href="javascript:void(0);" 
																			class="btn btn-danger btn-sm btn-rounded me-3 delete" 
																			title="Delete User"
																			id="{{ $user->id }}"
																		>
																			<i class="fa fa-trash"></i> Delete
																		</a>
																		<a
																			href="javascript:void(0);" 
																			id="{{ $user->id }}"
																			title="Manage User Role"
																			data-bs-toggle="modal"
																			data-bs-target="#roleModal"
																			class="btn btn-success btn-sm btn-rounded role"
																		>
																			<i class="fa fa-user-plus"></i> Manage Role
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
		<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="userModal">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">User</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="post" id="user_form" novalidate>
						<input type="hidden" name="user" id="user">
						<div class="modal-body">
							<div class="row mb-3">
								<div class="col-md-12">
									<div class="form-group">
										<label for="name" class="fw-bold required">Full Name</label>
										<input type="text" name="name" id="name" placeholder="Full Name" class="form-control">
									</div>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-12">
									<div class="form-group">
										<label for="email" class="fw-bold required">Email</label>
										<input type="email" name="email" id="email" placeholder="yourmail@domain.com" class="form-control">
									</div>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-12">
									<div class="form-group">
										<label for="role" class="fw-bold required">Role</label>
										<select name="role" id="role" class="form-control">
											<option value="">-- Select Role --</option>
											@foreach ($roles as $role)
												<option value="{{ $role->value }}">{{ $role->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" id="close-btn" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
							<button type="submit" id="submit-btn" class="btn btn-sm btn-primary">Save Record</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="roleModal">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">User Roles</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div id="loader" class="text-center">
							<span class="spinner-border spinner-border-md" role="status" aria-hidden="true"></span>
						</div>
						<div id="role_list" style="display: none;">
							<div class="row" id="logs"></div>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
						<button type="button" id="update_role" class="btn btn-sm btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		@include('layouts.admin.script')
		<script>
			let selected;
			let userModal = new bootstrap.Modal(document.getElementById('userModal'), {
  				keyboard: false,
				backdrop: 'static',
			});

			let roleModal = new bootstrap.Modal(document.getElementById('roleModal'), {
  				keyboard: false,
				backdrop: 'static',
			});

			jQuery.validator.addMethod("customemail", function(value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            }, "Please enter a valid email address.");

			$("#user_form").validate({
				rules: {
					name: {
						required: true,
						minlength: 3,
					},					
					email: {
						required: true,
						customemail: true,
					},
					role: { required: true }
				},
				messages: {
					name: {
						required: "Enter your name.",
						minlength: "Your name should be longer than {0} characters."
					},					
					email: {
						required: "Enter email address."
					},
					role: {
						required: "Select role for user account"
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
					let form = $("#user_form").serialize();
					if (!selected) {
						$.ajax({
							type: "POST",
							url: "{{ route('admin.register_user') }}",
							data: form,
							beforeSend: () => {
								$("#submit-btn").attr('disabled', true).html(`
									<div class="text-center">
										<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									</div>`
								);
							},
							success: (response) => {
								$("#submit-btn").attr('disabled', false).html('Save');
								if (response.status == 201) {
									userModal.hide();
									emptyForm('user_form');
									loadRecords(response.data, [
										{
											'data': null, 'render': (data, type, row, meta) => {
												return meta.row + meta.settings._iDisplayStart + 1 +'.'
											}
										},
										{'data': 'fullname'},
										{'data': 'email'},
										{'data': 'role'},
										{
											'data': null, 'render': (full, type, row, meta) => {
												return `
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-primary btn-sm btn-rounded edit"><i class="fa fa-edit"></i> Edit</a>
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-danger btn-sm btn-rounded delete"><i class="fa fa-trash"></i> Delete</a>
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-success btn-sm btn-rounded role"><i class="fa fa-user-plus"></i> Manage Role</a>
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
							url: "{{ route('admin.update_user') }}",
							data: form,
							beforeSend: () => {
								$("#submit-btn").attr('disabled', true).html(`
									<div class="text-center">
										<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									</div>`
								);
							},
							success: (response) => {
								$("#submit-btn").attr('disabled', false).html('Save');
								if (response.status == 202) {
									userModal.hide();
									emptyForm('user_form');
									loadRecords(response.data, [
										{
											'data': null, 'render': (data, type, row, meta) => {
												return meta.row + meta.settings._iDisplayStart + 1 +'.'
											}
										},
										{'data': 'fullname'},
										{'data': 'email'},
										{'data': 'role'},
										{
											'data': null, 'render': (full, type, row, meta) => {
												return `
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-primary btn-sm btn-rounded edit"><i class="fa fa-edit"></i> Edit</a>
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-danger btn-sm btn-rounded delete"><i class="fa fa-trash"></i> Delete</a>
													<a href="javascript:void(0);" id="${full['id']}" class="btn btn-success btn-sm btn-rounded role"><i class="fa fa-user-plus"></i> Manage Role</a>
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
					}
				}
			});

			$("body").on("click", ".edit", function () {
				let user = this.id;
				if (user.length < 1 || user == null || user == "") return false
				$.ajax({
					type: "GET",
					url: "{{ route('admin.edit_user') }}",
					data: { user },
					success: (response) => {
						if (response.status == 200) {
							selected = response.data.id;
							$("#user").val(parseInt(response.data.id));
							setForm("user_form", response.data);
							userModal.show();
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
				let user = this.id;
				if (user.length && user != null && user != "") {
					swal({
						title: "Do you wish to proceed?",
						text: `The user's account will deleted.`,
						icon: "warning",
						buttons: true,
						dangerMode: true,
					}).then((willDelete) => {
						if (willDelete) {
							$.ajax({
								type: "DELETE",
								url: "{{ route('admin.delete_user') }}",
								data: { user },
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
											{'data': 'fullname'},
											{'data': 'email'},
											{'data': 'role'},
											{
												'data': null, 'render': (full, type, row, meta) => {
													return `
														<a href="javascript:void(0);" id="${full['id']}" class="btn btn-primary btn-sm btn-rounded me-3 edit"><i class="fa fa-edit"></i> Edit</a>
														<a href="javascript:void(0);" id="${full['id']}" class="btn btn-danger btn-sm btn-rounded me-3 delete"><i class="fa fa-trash"></i> Delete</a>
														<a href="javascript:void(0);" id="${full['id']}" class="btn btn-success btn-sm btn-rounded role"><i class="fa fa-user-plus"></i> Manage Role</a>
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

			$("body").on("click", ".role", function () {
				let user = this.id;
				if (user) {
					$("#logs").empty();
					$("#loader").show();
					roleModal.show();
					$.ajax({
                        type: "GET",
                        url: "{{ route('admin.manage_user_role') }}",
                        data: { type: "load_roles", user },
                        success: (response) => {
                            if (response.status == 200) {
                                for (const item in response.data) {
									let role = item.replace('_', ' ')
									let element = `
										<div class="col-md-4 form-group mb-3">
											<div class="form-check">
												<input name="roles[]" id="${item}" class="form-check-input" type="checkbox" value="${item}">
												<label class="form-check-label">${ titleCase(role.charAt(0).toUpperCase() + role.slice(1)) }</label>
											</div>
										</div>
									`;
									$("#logs").append(element);
                                    $(`#${item}`).attr("checked", response.data[item]);
                                }
                                $("#loader").hide();
                                $("#role_list").css("display", "block");
								$("#user").val(parseInt(user));
                            } else {
                                $("#loader").hide();
                                toastr.error(response.message, "error");
                            }
                        },
                        error: (err) => {
                            $("#loader").hide();
                            if (err.responseJSON) {
								toastr.error(err.responseJSON.message, 'error')
								return;
							}
							toastr.error(err.message, "Error");
                        }
                    });
				}
			});

			$("body").on("click", "#update_role", function () {
				let roles = $("input[name='roles[]']:checked").map(function () {
					return $(this).val()
				}).get();
				let user = $("#user").val();
				$.ajax({
                    type: "POST",
                    url: "{{ route('admin.manage_user_role') }}",
                    data: { type: "update_role", roles, user, },
                    beforeSend: () => {
                        $("#update_role").attr("disabled", true).html(
							'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
						);
                    },
                    success: (response) => {
                        $("#update_role").attr("disabled", false).html('Save Changes');
                        if (response.status == 200) {
                           	roleModal.hide();
							$("#logs").empty();
                            toastr.success(response.message, "success");
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
			})
		</script>
	</body>
</html>