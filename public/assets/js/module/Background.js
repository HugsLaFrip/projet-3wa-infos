class Background {
    setSize() {
        $('.container').css({
            'min-height': $(window).height() - $('header').height() - 1
        })
    }
}

export default Background;