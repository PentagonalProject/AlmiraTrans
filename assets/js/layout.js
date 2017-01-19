+function (win) {
    /**
     * Check jQuery Global in windows
     */
    if (typeof win.jQuery != 'function') {
        return;
    }
    /**
     * Set jQuery
     */
    var $ = win.jQuery;
    /**
     * Init Document Ready
     */
    $(document).ready(function () {
        $('head')
            .find('link:last')
            .after('<link href="\/\/fonts.googleapis.com\/css?family=Lato:300,400,700" rel="stylesheet" type="text\/css">');

        /* --------------------------------------
         *              SITE
         * --------------------------------------
         */
        var $navigation = $('#header .navigation');
        var $aHref = $navigation.find('[href^=\\#]');
        if ($.fn.waypoint) {
            $('section[id]').waypoint(
                function () {
                    var $this = $(this.element),
                        $id = $this.attr('id');
                    if ($id) {
                        var $target = $navigation.find('li a[href=\\#'+ $id +']').parent('li');
                        if ($target.length) {
                            $navigation.find('ul li').removeClass('active');
                            $target.addClass('active');
                        }
                    }
                },
                {
                    offset: 'bottom-in-view'
                }
            );
        }
        $aHref.on('click', function (e) {
            e.preventDefault();
            var attrHref = $(this).attr('href');
            if (attrHref) {
                try {
                    var $targetId = $(attrHref);
                    if ($targetId.length) {
                        $('html, body').animate({
                            scrollTop: $targetId.offset().top + ($targetId.offset().top > 80 ? 5 : 0)
                        });
                    }
                } catch(err) {}
            }
        });

        $(window).on('scroll', function () {
            var $height = $('#top').height();
            if (!$height) {
                return;
            }
            $height -= 30;
            try {
                var $offset = this.scrollY;
                if ($height < $offset) {
                    if (!$navigation.hasClass('position-not-top')) {
                        $navigation.addClass('position-not-top');
                    }
                } else {
                    if ($navigation.hasClass('position-not-top')) {
                        $navigation.removeClass('position-not-top');
                    }
                }
            } catch(e){}
        });
        $(window).scroll();
        $navigation.find('li:first > a').trigger('click');
    });
}(window);