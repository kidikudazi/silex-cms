<script src="{{ asset('assets/frontend/js/custom.js') }}"></script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.actions.min.js') }}">
</script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.carousel.min.js') }}">
</script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js') }}">
</script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js') }}">
</script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.migration.min.js') }}">
</script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.navigation.min.js') }}">
</script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.parallax.min.js') }}">
</script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js') }}">
</script>
<script 
    type="text/javascript" 
    src="{{ asset('assets/frontend/js/revolution-slider/js/extensions/revolution.extension.video.min.js') }}">
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let menus = document.getElementsByClassName('menu');
    for (let index = 0; index < menus.length; index++) {
        if (window.location.pathname === menus[index].children[0].pathname) {
            menus[index].classList.add('active');
        } else {
            menus[index].classList.remove('active');
        }
    }
</script>