$.fn.extend({
    recalcImg: function(r) {
        let $img = $(this);
        let $parent = $img.parents('.img');
        $img.removeAttr('style');
        $img.addClass('ok')
        let w = $img.width();
        let h = $img.height();
        $img.addClass('ow' + w);
        let ratio = r;
        let imgRatio = w / h;
        let pw = $parent.width();
        let ph = $parent.height();
            ph=w/ratio;
            $parent.height(ph);
        if (imgRatio > ratio) {
            //wider
            $img.addClass('wider')
            $img.css({
                'height': '100%',
                'maxWidth': 'none',
                'width':'auto'
            });
            let w = $img.width();
            $img.css({'marginLeft': -((w - pw) / 2)})
        } else if (imgRatio < ratio) {
            // alert(w)
            $img.addClass('taller')
            $img.css({
                'marginTop': -((h - ph) / 2)
            });

        }
        /*let ratio = 1;
        let frameWidth = $frame.width();
        let frameHeight = frameWidth / ratio;
        $frame.css({'height': frameHeight});
        let orgRatio = $img.width() / $img.height();
        if(orgRatio > ratio){
            $img.css({'width':'initial','height':'100%','maxWidth':'none'});
            let w = $img.width();
            let offset = (w - frameWidth) / 2;
            $img.css({'marginLeft' : -offset})
        }
        if(orgRatio < ratio){
            let h = $img.height();
            let offset = (h - frameHeight) / 2;
            $img.css({'marginTop' : -offset})

        }*/
    }
})
$(function() {
    //create swiper
    {
        let count = 0;
        $('.swiper-container').each(function(i) {
            let $this = $(this);
            let name = 'swiper' + i;
            let $pagination = $('.swiper-pagination', $this);
            let $next = $('.swiper-button-next', $this.parent())
            let $prev = $('.swiper-button-prev', $this.parent())
            let prop = {
                pagination: $pagination,
                paginationClickable: true,
                nextButton: $next,
                prevButton: $prev
            }
            let $wrapper = $this.find('.swiper-wrapper');
            let gridIndex = $wrapper.attr('class').indexOf('grid')
            if (gridIndex > 0) {
                let num = $wrapper.attr('class').substr(gridIndex + 4, 1);
                prop.slidesPerView = num;
            }
            if($this.data('autoplay')){
                prop.autoplay = 3000;
                prop.speed = 1000;
                prop.loop = true;
            }
            createSwiper(name, $this, prop);
        })

        function createSwiper(name, $this, prop) {
            window[name] = new Swiper($this, prop);
            $this.attr('data-swiper',name)
        }
        /*var swiper = new Swiper('.swiperb', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });*/
        $('.top .swiper-slide.img img').each(function(){
            $(this).recalcImg(16/6.5);
            $(this).on('load', function(){
                $(this).recalcImg(16/6.5);
            })
        });
        $('.profile-tbl .product img').each(function(){
            $(this).recalcImg(1);
            $(this).on('load', function(){
                $(this).recalcImg(1);
            })
        });
        $('[class*=grid]').not('.grid-intro').find('.img img').each(function(){
            $(this).recalcImg(1.5);
            $(this).on('load', function(){
                $(this).recalcImg(1.5);
            })
        })
    }

    //header nav
    {
        let $sub = $('.submenu');
        $sub.parents('li').hover(function() {
            $this = $(this);
            $this.find('.submenu').not(':animated').slideDown(200);
        }, function() {
            $this.find('.submenu').slideUp(200);
            console.log('exit');
        })
    }

    // custom select / form
    {
        let $cs = $('body').find('.custom-select');
        $('body').on('click', '.custom-select .ttl', function() {
            let $p = $(this).parent();
            $p.find('.opt').slideToggle(200);
        });

        //change form title
        $('body').on('click','.opt li',function() {
            let $p = $(this).parents('.custom-select');
            let $ttl = $p.find('.ttl');
            let v = $(this).text();
            $ttl.html(v);
            if ($p.attr('target')){
                console.log($p.attr('target'))
                $($p.attr('target')).val(v);
            }
            $p.find('.opt').slideToggle(200);
        })
    }

    //resize exhibit ad img size
    {
        let $frame = $('.exhibit .ad .img');
        let $img = $('.exhibit .ad img');
        $img.on('load', function() {
            console.log('load')
            let frameRatio = $frame.width() / $frame.height();
            let imgRatio = $img.width() / $img.height();
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
            let $img = target;
            $img.removeAttr('style');
            $img.addClass('ok')
            let $frame = $img.parents('.img');
            $img.css({ 'width': '100%' });
            let ratio = 1.5;
            let frameWidth = $frame.width();
            let frameHeight = frameWidth / ratio;
            $frame.css({ 'height': frameHeight });
            let orgRatio = $img.width() / $img.height();
            if (orgRatio > ratio) {
                $img.css({ 'width': 'initial', 'height': '100%', 'maxWidth': 'none' });
                let w = $img.width();
                let offset = (w - frameWidth) / 2;
                $img.css({ 'marginLeft': -offset })
            }
            if (orgRatio < ratio) {
                let h = $img.height();
                let offset = (h - frameHeight) / 2;
                $img.css({ 'marginTop': -offset })

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
        let pagename = $('body').attr('id').substr(5);
    }
    $('.page-index .ttl-bar .tab li').click(function(e) {/*
        e.stopPropagation();
        let $this = $(this);
        let $parent = $this.parent();
        let hasSub = $this.find('.submenu').length;
        let target = $this.data('target')
        let index = $this.index();
        let text = $this.text();
        let $sect = $this.parents('section');
        let $content = $sect.find('.content');
        if(!hasSub){
            $content.find('[class^=cat]').removeClass('active');
        }
        if ($parent.hasClass('submenu')) {
            $this.parents('.tab').find('li').removeClass('active');
            $this.parent().parents('li').addClass('active');
            $this.addClass('active').siblings().removeClass('active');
            $content.find('.' + target).addClass('active');

        } else {
            if(!hasSub){
                $this.addClass('active').siblings().removeClass('active');
                $content.find('.cat' + (index + 1)).addClass('active');
                $content.find('.cat' + (index + 1) + ' .swiper-container').addClass('poiqwe')
                $('.fc-today-button').click()
                
            }
            console.log('nosub')
            
        }
        $('[class*=grid]').not('.grid-intro').find('.img img').each(function() {
            resizeImg($(this))
        })
        console.log(typeof(pagename) != 'undefined')
        if (typeof(pagename) != 'undefined') {
            $('.breadcrumb').find('.name').html(text).attr('href', '/' + pagename + '/' + text);
            window.history.pushState("state", "title", text);
        }
        let swiperName = $sect.find('.content>.active .swiper-container').attr('data-swiper');
        console.log(swiperName)
        window[swiperName].update();
    */})

    //add input column
    {
        $('.custom-input .btn-add').click(function() {
            let $this = $(this);
            let $ul = $this.parent().next().find('ul');
            let $input = $ul.find('input');
            let type = $input.attr('type');
            $ul.append(
                $('<li>').append(
                    $('<input>').attr({ 'type': type })
                    )
                )
        })
        let ulInnerHtml = [];

        function multiAdd($this) {
            ulInnerHtml.push($this.find('ul.custom-input').prop('innerHTML'));
                console.log(ulInnerHtml)
            $this.find('.btn-add-sp').click(function() {
                let $this = $(this);
                let $parent = $this.parents('.form .multiadd');
                let $index = $parent.data('index');
                console.log(ulInnerHtml[$index]);
                $parent.find('ul.custom-input').append(ulInnerHtml[$index]);
            })
        }
        $('.form .multiadd').each(function() {
            multiAdd($(this));

        })
    }
    //show more info in porfessional
    $('.professional .btn-more-box').click(function() {
        let $this = $(this);
        let $parent = $this.parent();
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
    $('.sort .ttl').on('change',function(){
        alert('asd')
        // var sort = $('#type').val();
        // if( sort != '' ) window.location.href='/post?sort='+sort;
    })
})