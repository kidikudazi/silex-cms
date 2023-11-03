<script src="{{ asset('assets/backend/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/backend/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/sweetalert/sweet-alert.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('assets/backend/js/fancy/jquery.fancybox.min.js') }}"></script>
<script>
    $("body").on("click", "#logout-btn", function() {
        $("#logout").submit();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#datatable").DataTable({
        search: true,
        destroy: true,
        responsive: true,
        select: true,
        columnsDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: 0 },
        ]
    });

    const emptyForm = (form) => {
        let list = $(`#${form}`)[0];
        for (let index = 0; index < list.length; index++) {
            const element = list[index];
            const tagName = element.tagName;
            const tagId = element.id;

            if (tagName == "INPUT" || tagName == "SELECT") {
                $(`#${tagId}`).val('');
            }
        }
    };

    const setForm = (form, data) => {
        let list = $(`#${form}`)[0];
        for (let index = 0; index < list.length; index++) {
            const element = list[index];
            const tagName = element.tagName;
            const tagId = element.id;

            Object.keys(data).forEach(key => {
                if (tagName == "INPUT") {
                    $(`#${key}`).val(data[key]);
                } else if (tagName == "SELECT") {
                    $(`#${key}`).val(data[key]).attr("selected", true);
                }
            });
        }
    };

    const loadRecords = (data, columns) => {
        $("#datatable").DataTable({
            search: true,
            destroy: true,
            responsive: true,
            data: data,
            select: true,
            columnsDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 0 },
            ],
            columns: columns
        });
    };

    const titleCase = (str) => {
        return str.toLowerCase().split(' ').map(function(word) {
            return (word.charAt(0).toUpperCase() + word.slice(1));
        }).join(' ');
    };

    $(function () {
        $("#compose-area").summernote({
            height: 300,
            placeholder: "Content goes here...",
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['height', ['height']]
            ]
        });
    });

    @if (Session::has('error'))
        $(window).ready(function () {
            toastr.error("{{ session('error') }}", "error");
        });
    @endif

    @if (Session::has('success'))
        $(window).ready(function () {
            toastr.success("{{ session('success') }}", "success");
        });
    @endif

    window.addEventListener('load', function(){
        window.setTimeout(() => {
            $('#icon').removeClass('bounce');
            $('#icon').removeClass('fa-box');
            $('#icon').addClass('fa-box-open');
            $('#icon-box').removeClass('text-success');
            $('#icon-box').addClass('text-warning');
            $('#data_message').css('display', 'block');
        }, 800);
    });

    // activity time
    let timeoutInMiliseconds = 1200000;
    let timeoutId;

    const resetTimer =() => {
        window.clearTimeout(timeoutId)
        startTimer();
    }
    
    const startTimer =() => {
        timeoutId = window.setTimeout(doInactive, timeoutInMiliseconds);
    }
    
    const doInactive =() => {
        window.location.reload();
    }
    
    const setupTimers = () => {
        document.addEventListener("mousemove", resetTimer, false);
        document.addEventListener("mousedown", resetTimer, false);
        document.addEventListener("keypress", resetTimer, false);
        document.addEventListener("touchmove", resetTimer, false);
        
        startTimer();
    }

    const generateAvatar = (text, foregroundColor = "white", backgroundColor = "black") => {
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");

        canvas.width = 200;
        canvas.height = 200;

        // Draw background
        context.fillStyle = backgroundColor;
        context.fillRect(0, 0, canvas.width, canvas.height);

        // Draw text
        context.font = "bold 100px Assistant";
        context.fillStyle = foregroundColor;
        context.textAlign = "center";
        context.textBaseline = "middle";
        context.fillText(text, canvas.width / 2, canvas.height / 2);

        return canvas.toDataURL("image/png");
    }

    $(document).ready(() =>{
        setupTimers();
        document.getElementById("admin-avatar").src = generateAvatar("{{ \Session::get('initials') }}", "white", "#05a65bcc");
    });
</script>