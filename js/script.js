(function($){
    $(".c-header__button").on('click',function(){
        $(".c-menu").toggleClass("js-menu");
        $(".c-header__button").toggleClass("js-menu");
    }
    );
    $(".p-single-index__button").on('click',function(){
        $(".p-single-index__list").toggleClass("js-index");        
        if ($(this).text() === '閉じる') {
            $(this).text('開く');
          } else {
            $(this).text('閉じる');
          }
    }
    );

})( jQuery );
