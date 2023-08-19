document.addEventListener('DOMContentLoaded', () => {
    var e = $(".js-nav-button"),
        t = $(".js-nav-menu-link"),
        i = $(".js-nav-menu-item");
    
    e.on("click", function() {
        $(".header").toggleClass("menu-opened");
        $("html").toggleClass("menu-opened");
    });
    t.on("click", function() {
        $(this).closest(i).toggleClass("is-opened")
    });
});

document.addEventListener('DOMContentLoaded', () => {
    $(".js-main-menu-switcher").on("click", function(e) {
        var t = $(this).nextAll(".js-main-menu-dropdown");
        
        t.length && (e.preventDefault(), t.toggleClass("main-menu__dropdown_visible"));
    });
});

/*
document.addEventListener('DOMContentLoaded', () => {
    $('#category-filter input[type=radio]:checked').on('click', (e) => {
        $(e.currentTarget).prop('checked', false).trigger('change');
    });
    
    $('#category-filter input[type=checkbox], #category-filter input[type=radio]').on('change', function(e) {
        $(e.currentTarget).parents('form').submit();
    });
});
*/

document.addEventListener('DOMContentLoaded', () => {
    $('.product-thumbs-track').on('click', '.pt', function(){
        $('.product-thumbs-track .pt').removeClass('active');
        $(this).addClass('active');
        
        let imgurl = $(this).data('imgbigurl'),
            bigImg = $('.product-big-img').attr('src');
        
        if (imgurl !== bigImg) {
            $('.product-pic-zoom').attr({href: imgurl});
            $('.product-big-img').attr({src: imgurl});
            $('.zoomImg').attr({src: imgurl});
        }
    });

    if ($(window).width() > 769) {

        $('.product-pic-zoom').zoom();
    }

    
    $('.popup-gallery .product-pic-zoom').magnificPopup({
        type: 'image',
        closeOnContentClick: true
    });
    
    let $product_thumbs = $('.product-thumbs .product-thumbs-track .owl-carousel.owl-theme');
    if ($product_thumbs.length) {
        $product_thumbs.owlCarousel({
            margin:10,
            loop: false,
            nav:false,
            dots:true,
            navText: [ '<span class="btn btn-dark fa fa-angle-left"></span>', '<span class="btn btn-dark fa fa-angle-right"></span>' ],
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:3
                }
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {

  $(".section-title h2").sticky({topSpacing:0});


    $('#catalog-sort').on('change', (e) => {
        let $val = $(e.currentTarget).find(':selected'),
            order = $val.data('order'),
            direction = $val.data('direction');
        
        let queryParams = new URLSearchParams(window.location.search);
            queryParams.set('order', order);
            queryParams.set('direction', direction);
    
        location = location.pathname + '/?' + queryParams.toString();
    });
    
    let $fieldset = $('.products-catalog__filters .products-catalog__fieldset');
        $fieldset.find('.products-catalog__filter-name').on('click', (e) => {
            $(e.currentTarget)
                .parents('fieldset[data-name]')
                .toggleClass('spoiler-active')
                .find('.products-catalog__fields')
                .toggleClass('d-none d-flex')
            ;
            
            $(e.currentTarget)
                .parents('fieldset:not([data-name])')
                .toggleClass('spoiler-active')
                .find('.products-catalog__fields')
                .toggleClass('d-none d-block')
            ;
        });
    
    $('[data-catalog-item] .product-card__color').on('mouseover', function(e) {
        let $el = $(e.currentTarget),
            $parent = $el.parents('[data-catalog-item]'),
            $img = $parent.find('[data-lazyload-image]:not(.action)'),
            $sale = $parent.find('img.action'),
            $a = $parent.find('a.merch, a.product-card__btn');
        
        $img.attr('src', $el.attr('data-img'));
        $a.attr('href', $el.attr('href'));
        $sale.toggle($el.attr('data-sale') === 'true');
    });
});
