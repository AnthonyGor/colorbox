$(function () {
   $('.typography-slider').slick({
       slidesToScroll: 1,
       autoplay: true,
       prevArrow: '        <button class="left-arrow">\n' +
           '            <img src="./img/slider-arrow-left.png" width="95" height="156" alt="">\n' +
           '        </button>   ',
       nextArrow:'        \n' +
           '        <button class="right-arrow">\n' +
           '            <img src="./img/slider-arrow-right.png" width="95" height="156" alt="">\n' +
           '        </button>\n' +
           '        ',
       centerMode: true,
       variableWidth: true
   });
});

$(document).ready(function(){
    $(".nav").on("click","a", function (event) {
        //отменяем стандартную обработку нажатия по ссылке
        event.preventDefault();

        //забираем идентификатор бока с атрибута href
        var id  = $(this).attr('href'),

            //узнаем высоту от начала страницы до блока на который ссылается якорь
            top = $(id).offset().top;

        var anchorOffset = $(window).width() < 1240 ? 0 : 150;
        //анимируем переход на расстояние - top за 1500 мс
        $('body,html').animate({scrollTop: top - anchorOffset}, 1500);
    });

    $('.ask-btn, .ask-btn-border').on('click', function (event) {
        $('.popup').fadeIn();
    });
    $('.close').on('click', function () {
        $('.popup').fadeOut();
    });
    $('#number').inputmask('+7 ( 999 ) 9999 - 999');



});


















