$.fn.extend({
    recalcImg: function(ratio, type) {
        var type = type;
        var $img = $(this);
        $img.addClass('type'+type)

        $img.removeAttr('style');
        $img.css('maxWidth','none');
        var $frame = $img.parents('.img');
        var iw = $img.width();
        var ih = $img.height();
        var imgRatio = iw / ih;
        var fw = $frame.width();
        var fh = $frame.height();
        fh = fw / ratio;
        var wider = imgRatio > ratio;
        var taller = imgRatio < ratio;
        $frame.height(fh);
        if (wider) {
            $img.addClass('wider-first')
        }
        if (taller) {
            $img.addClass('taller-first')
            $img.height(fh).width('auto');
            iw = $img.width();
        }
        if(!wider && !taller){
            $img.width('100%');
            return;
        }
        if (!type) {
            console.log('default')
        }
        switch (type) {
            case 'fill':
                if (wider) {
                    var nh = $img.height();
                    $img.height('100%');
                    $img.addClass('fh'+ fh)
                    $img.addClass('rat'+ imgRatio)
                    $img.width(fh * imgRatio);
                    var nw = $img.width();
                    $img.css({ 'marginLeft': -((nw - fw) / 2) });
                } else if (taller) {
                    $img.width('100%');
                    var nw = $img.width();
                    $img.height(nw / imgRatio);
                    var nh = $img.height();
                    $img.css({ 'marginTop': -((nh - fh) / 2) });
                }
                break;
            case 'fit':
                if (wider) {
                    $img.addClass('widerfit')
                    $img.css({ 'marginTop': (fh - ih) / 2 }).addClass('fff');
                } else if (taller){
                    $img.addClass('tallerfit')
                    $img.css({ 'marginLeft': (fw - iw) / 2 })
                }



        }

    }
})
$(function() {
    //create swiper
    var windowWidth = $(window).width(); {
        var count = 0;
        $('.swiper-container').each(function(i) {
            let $this = $(this);
            let name = 'swiper' + i;
            let $pagination = $('.swiper-pagination', $this);
            let $next = $('.swiper-button-next', $this.parent());
            let $prev = $('.swiper-button-prev', $this.parent());
            let prop = {
                pagination: $pagination,
                paginationClickable: true,
                nextButton: $next,
                prevButton: $prev,
                loop: true
            }
            let $wrapper = $this.find('.swiper-wrapper');
            let gridIndex = $wrapper.attr('class').indexOf('grid')
            if (gridIndex > 0) {
                let num = $wrapper.attr('class').substr(gridIndex + 4, 1);
                prop.slidesPerView = num;
            }
            if ($this.data('autoplay')) {
                prop.autoplay = $this.data('autoplay');
                prop.speed = 1000;
                prop.loop = true;
            }
            if (!$this.data('loop')) {
                prop.loop = false;
            }
            if ($this.data('fade')) {
                prop.effect = 'fade';
            }
            if ($this.data('vertical')) {
                prop.direction = 'vertical';
            }
            if ($this.data('left') || $this.data('right')) {
                var $left = $('.' + $this.data('left'));
                var $right = $('.' + $this.data('right'));
                prop.prevButton = $left;
                prop.nextButton = $right;

            }
            if ($this.data('col') > 1) {
                // prop.spaceBetween = 20;
                prop.spaceBetween = $this.data('space') ? $this.data('space') : 0;
                if (windowWidth > 1000) {
                    prop.slidesPerView = $this.data('col');

                }
            }
            createSwiper(name, $this, prop);

        })

        function createSwiper(name, $this, prop) {
            window[name] = new Swiper($this, prop);
            $this.attr('data-swiper', name)
        }
        /*var swiper = new Swiper('.swiperb', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });*/
        // $('.top .swiper-slide.img img').each(function(){
        //     $(this).recalcImg(16/9);
        //     $(this).on('load', function(){
        //         $(this).recalcImg(16/9);
        //     })
        // });
        // $('.profile-tbl .product img').each(function(){
        //     $(this).recalcImg(1);
        //     $(this).on('load', function(){
        //         $(this).recalcImg(1);
        //     })
        // });
        // $('[class*=grid]').not('.grid-intro').find('.img img').each(function(){
        //     // $(this).recalcImg(1.5);
        //     $(this).on('load', function(){
        //         // $(this).recalcImg(1.5);
        //     })
        // });
        let recalcImgAry = [
        ['.top.two-side .swiper-slide.img img', 3/2, 'fit'],
        ['.page-market .top .swiper-slide.img img', 120 / 45, 'fit'],
        ['.profile-tbl .product img', 1, 'fit'],
        ['.hot .cat img', 1.5, 'fit'],
        ['.manufacturers .cat img', 1.5, 'fit'],
        ['.page-index [class*=grid] img', 1.5, 'fit'],
        ['.page-market [class*=grid] img', 1.5, 'fit'],
        ['.exhibit [class*=grid] img', 1.5, 'fit'],
        ['.marketing-list img', 1.5, 'fit'],
        ['.yellow-pages .grid6 img', 1.5, 'fit'],
        ['.prod .swiper-slide img', 1, 'fit'],
        ['.news-index .left img', 1.5, 'fit'],
        ['.post2 .side-left .fig img', 4/3, 'fill'],
        ['.news-inner .side-left img', 4/3, 'fit'],
        ['.news-inner .side-right .hot-post img', 4/3, 'fit']
        ];

        $(window).resize(function(){
            recalcImgAry.forEach(function(v) {

                let r = v[1];
                let l = v[2];
                $(v[0]).each(function() {
                    console.log('aaa')
                    $(this).recalcImg(r, l);
                    $(this).on('load', function() {
                        console.log($(this).attr('src'))
                        $(this).recalcImg(r, l);
                    });
                });
            });
        }).resize();
    }

    //header nav
    {
        var $sub = $('.submenu');
        $sub.parents('li').hover(function() {
            $(this).find('>.submenu').not(':animated').slideDown(1);
        }, function() {
            $(this).find('>.submenu').slideUp(1);
        })
    }

    // custom select / form
    {
        var $cs = $('body').find('.custom-select');
        $('body').on('click', '.custom-select .ttl', function() {
            var $p = $(this).parent();
            $p.find('.opt').slideToggle(200);
        });

        //change form title
        $('body').on('click', '.opt li', function() {
            var $p = $(this).parents('.custom-select');
            var $ttl = $p.find('.ttl');
            var v = $(this).text();
            $ttl.html(v);
            if ($p.attr('target')) {
                console.log($p.attr('target'))
                $($p.attr('target')).val(v);
            }
            $p.find('.opt').slideToggle(200);
        })
    }

    //resize exhibit ad img size
    {
        var $frame = $('.exhibit .ad .img');
        var $img = $('.exhibit .ad img');
        $img.on('load', function() {
            console.log('load')
            var frameRatio = $frame.width() / $frame.height();
            var imgRatio = $img.width() / $img.height();
            if (imgRatio > frameRatio) { //width
                $img.css({
                    'height': '100%',
                    'maxWidth': 'initial'
                });
                console.log($frame.width())
                $img.css({ 'marginLeft': -(($img.width() - $frame.width()) / 2) })
            } else if (imgRatio < frameRatio) { //tall

                $img.css({
                    'width': '100%'
                })
                console.log($img.height());
                $img.css({ 'marginTop': -(($img.height() - $frame.height()) / 2) })
            }
            // console.log(imgRatio)
        })
    }
    //resize most img ratio
    {

        function resizeImg(target) {
            var $img = target;
            $img.removeAttr('style');
            $img.addClass('ok')
            var $frame = $img.parents('.img');
            $img.css({ 'width': '100%' });
            var ratio = 1.5;
            var frameWidth = $frame.width();
            var frameHeight = frameWidth / ratio;
            $frame.css({ 'height': frameHeight });
            var orgRatio = $img.width() / $img.height();
            if (orgRatio > ratio) {
                //wider
                $img.css({ 'width': '100%', 'height': 'auto' });
                var h = $img.height();
                var ph = $img.parents('.img').height();
                $img.css({ 'marginTop': (ph - h) / 2 })
            }
            if (orgRatio < ratio) {
                //taller
                $img.css({ 'width': 'auto', 'height': '100%' });
                var w = $img.width();
                var pw = $img.parents('.img').width();
                $img.addClass('asd' + pw)
                $img.css({ 'marginLeft': (pw - w) / 2 });
            }


        }
        //get img ratio when img ready
        /*$('[class*=grid]').not('.grid-intro').find('.img img').on('load', function() {
            resizeImg($(this));
        })*/

        // $('[class*=grid]').find('img').css({'height':'100px'})
    }

    //tab function
    if ($('body').attr('id')) {
        var pagename = $('body').attr('id').substr(5);
    }
    $('.ttl-bar .tab li').click(function(e) {
        e.stopPropagation();
        var $this = $(this);
        var $parent = $this.parent();
        var hasSub = $this.find('.submenu').length;
        var target = $this.data('target');
        console.log(target)
        var index = target.substr(-1, 1);
        var text = $this.text();
        var $sect = $this.parents('section');
        var $content = $sect.find('.content');
        if (!hasSub) {
            $content.find('[class^=cat]').removeClass('active');
            console.log('!hasSub')
        }
        if ($parent.hasClass('submenu')) {
            $this.parents('.tab').find('li').removeClass('active');
            $this.parent().parents('li').addClass('active');
            $this.addClass('active').siblings().removeClass('active');
            $content.find('.' + target).addClass('active');
            console.log(target)
            console.log('hassubmenu')

        } else {
            if (!hasSub) {
                $this.addClass('active').siblings().removeClass('active');
                $content.find('.cat' + (index)).addClass('active');
                $content.find('.cat' + (index) + ' .swiper-container').addClass('poiqwe')
                $('.fc-today-button').click()
                console.log('!hassubmenu')
            } else {
                $this.addClass('active').siblings().removeClass('active');
                $content.find('div').removeClass('active');
                $content.find('.' + target).addClass('active');
                $content.find('.' + target + ' .swiper-container').addClass('poiqwe');
            }
            console.log('nosub')
        }
        $('[class*=grid]').not('.grid-intro').find('.img img').each(function() {
            resizeImg($(this))
        })
        console.log(typeof(pagename) != 'undefined')
        if (typeof(pagename) != 'undefined') {
            $('.breadcrumb').find('.name').html(text).attr('href', '/' + pagename + '/' + text);
            // window.history.pushState("state", "title", text);
        }
        var swiperName = $sect.find('.content>.active .swiper-container').attr('data-swiper');
        if (swiperName) {
            console.log(swiperName)
            window[swiperName].update();
        }
    })

    //add input column
    {
        $('.custom-input .btn-add').click(function() {
            var $this = $(this);
            var $ul = $this.parent().next().find('ul');
            var $input = $ul.find('input');
            var type = $input.attr('type');
            $ul.append(
                $('<li>').append(
                    $('<input>').attr({ 'type': type })
                    )
                )
        })
        var ulInnerHtml = [];
        var inputIndex = 0;
        function multiAdd($this) {
            ulInnerHtml.push($this.find('ul.custom-input').prop('innerHTML'));
            $this.find('.btn-add-sp').click(function() {
                inputIndex++;
                var $this = $(this);
                var $parent = $this.parents('.form .multiadd');
                var $index = $parent.data('index');
                console.log(ulInnerHtml[$index]);
                $parent.find('ul.custom-input li').addClass('ok');
                $parent.find('ul.custom-input').append(ulInnerHtml[$index]);
                $parent.find('ul.custom-input li').not('.ok').find('.custom-radio li').each(function(){
                    var $this = $(this);
                    var $input = $this.find('input[type^=checkbox]');
                    var $label = $this.find('label');
                    var inputId = $input.attr('id');
                    var labelFor = $label.attr('for');
                    $input.attr('id', inputId + '-' + inputIndex).attr('name','prods['+inputIndex+'][]');
                    $label.attr('for', labelFor + '-' + inputIndex);

                })
                $parent.find('.tags').not('.ok').find('#myTags-0').attr('id','myTags-'+inputIndex).tagit({
                    fieldName:"tags["+inputIndex+"][]",
                });
            })
        }
        $('.form .multiadd').each(function() {
            multiAdd($(this));

        })
    }
    //show more info in porfessional
    $('.professional .btn-more-box').click(function() {
        var $this = $(this);
        var $parent = $this.parent();
        $('p', $parent).css({ 'height': 'auto' })
    })

    //login enter button;
    $('#login_password').on('keyup', function(e) {
        if (e.keyCode == 13) {
            $('#loginform').submit();
        }
    });

    $('.forum .res .btn-reply').click(function(e) {
        if ($(this).parent().prev().css('display') == 'none') {
            e.preventDefault();
            $(this).parent().prev().css({ 'display': 'block' })
        }
    })
    $('.sort .ttl').on('change', function() {
        alert('asd')
        // var sort = $('#type').val();
        // if( sort != '' ) window.location.href='/post?sort='+sort;
    })
    $('.tabs li').click(function() {
        var $this = $(this);
        var $p = $this.parents('.tab-wrap');
        var index = $this.index();
        console.log(index)
        $this.addClass('active').siblings().removeClass('active')
        $p.find('.tab-content>li').eq(index).addClass('active').siblings().removeClass('active');
    });


    $('.submenu-pic li').click(function() {
        var $this = $(this);
        if (!$this.hasClass('active')) {
            var $p = $this.parents('.content');
            var $img = $this.find('img');
            var $aImg = $('.submenu-pic li.active').find('img');
            var src = $this.find('img').attr('src');
            var asrc = $aImg.attr('src');
            var len = src.length;
            var alen = asrc.length;
            var target = $this.data('target');
            $aImg.attr('src', asrc.substr(0, alen - 6) + '.png');
            $this.addClass('active').siblings().removeClass('active');
            $img.attr('src', src.substr(0, len - 4) + '-c.png');
            $p.find('.' + target).addClass('active').siblings().removeClass('active');
            $('[class*=grid]').not('.grid-intro').find('.img img').each(function() {
                resizeImg($(this))
            });
            var swiperName = $p.find('.active .swiper-container').attr('data-swiper');
            if (swiperName) {
                console.log(swiperName)
                window[swiperName].update();
            }
        }
    })
})