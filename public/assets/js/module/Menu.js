class Menu {
    // Set header's CSS class based on window width
    setMenuClass() {
        if ($(window).width() >= 768) {
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

    // Open menu when clicked -- For mobile version
    openMenu() {
        $('#open_nav').on('click', function () {
            $('#open_nav').addClass('hide');
            $('#close_nav').removeClass('hide');
            $('#nav').removeClass('hide');
            $('#menu').removeClass('menu_hide').addClass('menu_show');
        })
    }

    // Close menu when clicked -- For mobile version
    closeMenu() {
        $('#close_nav').on('click', function () {
            $('#close_nav').addClass('hide');
            $('#open_nav').removeClass('hide');
            $('#nav').addClass('hide');
            $('#menu').removeClass('menu_show').addClass('menu_hide');
        })
    }
}

export default Menu;