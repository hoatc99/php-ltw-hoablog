//Sidebar items set state

$(document).ready(function() {
    let url = window.location.href;
    $(".navbar-sidebar a").each(function() {
        if (this.href === url) {
            $(this).parent().addClass('active');
        }
    });
});
