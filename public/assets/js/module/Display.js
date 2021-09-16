class Display {
    // Set header's CSS class based on window width
    displayMenu() {
        if ($(window).width() >= 1024) {
            $('#menu').addClass('menu_show');
            $('#open_nav').addClass('hide');
            $('#close_nav').addClass('hide');
            $('#nav').removeClass('hide');
        }
        else {
            $('#menu').addClass('menu_hide').removeClass('menu_show');
            $('#open_nav').removeClass('hide')
            $('#close_nav').addClass('hide');
            $('#nav').addClass('hide');
        }
    }
    // Set what type of content to display
    displayContent() {
        if ($(window).width() >= 768) {
            $('#px768').removeClass('hide');
            $('#px300').addClass('hide');
        }
        else {
            $('#px768').addClass('hide');
            $('#px300').removeClass('hide');
        }
    }
}

export default Display;