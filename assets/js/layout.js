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
        $('html').removeClass('no-js').addClass('js');
        // $('head')
        //     .find('link:last')
        //     .after('<link href="\/\/fonts.googleapis.com\/css?family=Lato:300,400,700|Lobster" rel="stylesheet" type="text\/css">');
        if (window.location.href.match(/\#/)) {
            window.history.pushState("", document.title, window.location.pathname);
        }
        /* --------------------------------------
         *              SITE
         * --------------------------------------
         */
        var $navigation = $('#header .navigation');
        var $aHref = $navigation.find('a[href^=\\#]');
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
        $('a[href^=\\#]').on('click', function (e) {
            e.preventDefault();
            var attrHref = $(this).attr('href');
            if (attrHref) {
                var $this = $(this);
                try {
                    var $targetId = $(attrHref);
                    if ($targetId.length) {
                        $('html, body').animate({
                            scrollTop: $targetId.offset().top + ($targetId.offset().top > 80 ? 0 : 0)
                        }, function () {
                            $aHref.parent().removeClass('active');
                            var $Parent = $this.parent('li');
                            if ($Parent.length) {
                                $Parent.addClass('active');
                            }
                        });
                    }
                } catch(err) {}
            }
        });
        var $selectorOpacity = $('#top-feature .contain-top');
        var selectorOffset = $selectorOpacity.offset().top;
        var $carJazz = $('#car-scroll .car-jazz');
        var $carJazzInner = $carJazz.find('.inner');
        if ($carJazzInner.length) {
            var carJazzInnerWidth = $carJazzInner.width();
            $carJazzInner.css('margin-left', $(window).width()+'px');
        }

        $(window).on('scroll', function () {
            var fadeStart = 100; // 100px scroll or less will equiv to 1 opacity
            var $top =  $('#top');
            var $height = $top.height();
            if (!$height) {
                return;
            }
            if ($selectorOpacity.length) {
                var fromTop = $(this).scrollTop();
                var calc = 1;
                if (fromTop <= fadeStart ){
                    calc = 1;
                }else if( fromTop <= $height){
                    calc = 1 - fromTop / $height;
                }
                if (fromTop > 5) {
                    $selectorOpacity.css({
                        'margin': (selectorOffset + fromTop) + 'px 0px 0px 0px',
                        opacity: calc
                    });
                } else {
                    $selectorOpacity.css({
                        'margin': null,
                        opacity: null
                    })
                }
            }

            if ($carJazzInner.length) {
                var carTop = $carJazz.offset().top;
                var calcJass = -(fromTop - carTop);
                $carJazzInner.css('margin-left', calcJass);
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
        $(window).on('resize', function () {
            $(this).scroll();
        });
        $navigation.find('li:first > a').trigger('click');
        console.log('\n'
            + '\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -'
            + '\n-     _____  ____  ______  ___  ______  _____  ____  ______ ______   ___    -'
            + '\n-    /  __ \\/ __ \\/  __  \\/  /_ \\___  \\/ __  \\/ __ \\/  __  \\\\___  \\ /  /    -'
            + '\n-    / /_/ /  ___/  / /  /  __//  _   / /_/  / /_/ /  / /  /  _   //  /     -'
            + '\n-   /  .__/\\____/\\_/ /__/\\____/\\___._/\\__   /\\____/\\_/ /__/\\___._//  /      -'
            + '\n-  /  /  _________________________  ____/  /                     /  /____   -'
            + '\n- /__/  \\________________________/ /______/                     ._______/   -'
            + '\n-                                                                           -'
            + '\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -'
        );
    });
}(window);