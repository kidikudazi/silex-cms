<div id="kt_app_footer" class="app-footer">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">{{ date('Y') }} &copy;</span>
            <a href="{{ env('APP_URL') }}" target="_blank" class="text-gray-800 text-hover-primary">{{ env('APP_NAME') }}</a>
        </div>
    </div>
</div>