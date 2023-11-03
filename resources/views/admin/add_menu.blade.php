<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ env('APP_NAME') }} | Add Menu</title>
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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Menu</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">Web Builder</a>
											</li>
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<li class="breadcrumb-item text-muted">
                                                {{ (!empty($edit)) ? 'Edit Menu' : 'Create Menu' }}
                                            </li>
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a
                                            href="{{ route('admin.menu') }}" 
                                            class="btn btn-sm fw-bold btn-primary"
                                        ><i class="bi bi-journal-richtext"></i> Manage Menu</a>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
										<div class="card mb-5 mb-xl-10">
											<div class="card-body">
												<form id="menu_form" method="POST" novalidate>
													@csrf
                                                    <div class="form-group mb-3">
                                                        <label for="type" class="fw-bolder">Type</label>
                                                        <select name="type" id="type" class="form-control">
                                                            <option value="">-- Select Menu Type --</option>
                                                            <option 
																value="main"
																{{ !empty($edit) ? ((int) $edit->is_sub === 0 ? "selected": "") :(old('type') === "main" ? "selected" : "") }}
															>Main Menu</option>
                                                            <option
																value="sub"
																{{ !empty($edit) ? ($edit->is_sub === 1 ? "selected": "") :(old('type') === "sub" ? "selected" : "") }}
															>Sub Menu</option>
                                                        </select>
														@if ($errors->has('type'))
															<span class="help-block">
																<strong>{{ $errors->first('type') }}</strong>
															</span>
														@endif
                                                    </div>
                                                    <div class="form-group mb-3" style="display: {{ !empty($edit) ? ($edit->is_sub === 1 ? "block": "none") :(old('type') === "sub" ? "block" : "none") }}" id="menu-list">
                                                        <label for="category" class="fw-bolder">Menus</label>
                                                        <select name="category" id="category" class="form-control">
                                                            <option value="">-- Select Menu --</option>
                                                            @foreach ($menus as $menu)
                                                                <option value="{{ $menu->uuid }}" {{ (!empty($edit) && $edit->parent === $menu->uuid) ? "selected" :(old('category') == $menu->uuid ? 'selected' : '') }}>{{ $menu->title }}</option>
                                                            @endforeach
                                                        </select>
														@if ($errors->has('category'))
															<span class="help-block">
																<strong>{{ $errors->first('category') }}</strong>
															</span>
														@endif
                                                    </div>
													<div class="form-group mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
														<label for="title" class="fw-bolder">Title</label>
														<input type="text" name="title" id="title" placeholder="Menu title" value="{{ (!empty($edit)) ? $edit->title : old('title') }}" class="form-control">
														@if ($errors->has('title'))
															<span class="help-block">
																<strong>{{ $errors->first('title') }}</strong>
															</span>
														@endif
													</div>
													<div class="form-group mb-3 {{ $errors->has('content') ? 'has-error' : '' }}">
														<label for="content" class="fw-bolder">Content</label>
														<textarea name="content" id="compose-area" cols="30" rows="10" class="summernote form-control" style="resize: none;">{{ (!empty($edit)) ? $edit->content : old('content') }}</textarea>
														@if ($errors->has('content'))
															<span class="help-block">
																<strong>{{ $errors->first('content') }}</strong>
															</span>
														@endif
													</div>
													<div class="form-group">
														<button id="menu_btn" class="btn btn-sm btn-primary">
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
            $("#menu_form").validate({
                ignore: 'hidden:not(.summernote),.note-editable.card-block,.note-editor *',
                rules: {
                    type: { required: true },
                    title: { required: true },
                    content: { required: true },
                    category: {
						required: function (element) {
							return $("#type").val() == "sub"
						} 
					}
                },
                messages: {
                    type: "Select the type of menu to create.",
                    title: "Menu title is required.",
                    content: "Menu page content is required.",
                    category: "Select menu category"
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

            $("body").on("change", "#type", function () {
                let selected = this.value;
                if (selected === "main") {
                    $("#menu-list").hide();
                } else {
                    $("#menu-list").show();
                }
            });

            $("body").on("submit", "#menu_form", function() {
                $("#menu_btn").attr("disabled", true).html(`
					<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
				`);
            });
		</script>
	</body>
</html>