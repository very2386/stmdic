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
            createSwiper(name, $this, prop);
        })

        function createSwiper(name, $this, prop) {
            window[name] = new Swiper($this, prop);
        }
        /*var swiper = new Swiper('.swiperb', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });*/
    }

    // $('.swiper-containera') = new Swiper();

    // custom select / form
    {
        let $cs = $('.custom-select');
        $cs.find('.ttl').on('click', function() {

            let $p = $(this).parent();
            $p.find('.opt').slideToggle(200);
        });

        //change form title
        $cs.find('.opt li').click(function() {
            let $p = $(this).parents('.custom-select')
            let $ttl = $p.find('.ttl');
            let v = $(this).text();
            $ttl.html(v);
            $p.find('.opt').slideToggle(200);
        })
    }

    //resize exhibit ad img size
    {
        let $frame = $('.exhibit .ad .img');
        let $img = $('.exhibit .ad img');
        $img.on('load', function() {
            let frameRatio = $frame.width() / $frame.height();
            let imgRatio = $img.width() / $img.height();
            if (imgRatio > frameRatio) {
                $img.css({
                    'height': '100%',
                    'maxWidth': 'initial'
                });
                console.log($frame.width())
                $img.css({ 'marginLeft': -(($img.width() - $frame.width()) / 2) })
            } else if (imgRatio < frameRatio) {
                $img.css({
                    'width': '100%'
                    
                })
            	console.log($img.height());
            	$img.css({'marginTop': -(($img.height() - $frame.height()) / 2)})
            }
            // console.log(imgRatio)
        })
    }
})