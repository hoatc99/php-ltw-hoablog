//Navbar items set state

$(document).ready(function() {
    let url = window.location.href;
    $(".nav-item a").each(function() {
        if (this.href === url) {
            $(this).parent().addClass('active');
        }
    });

    let searchParams = new URLSearchParams(window.location.search)
    searchParams.has('page') // true
    let param = searchParams.get('page')
    console.log(param)
});
