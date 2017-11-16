$('.gallery p').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    variableWidth: true,
    adaptiveHeight: true
});

$('.gallery img').click(function(event){
    var $target = $(event.currentTarget);
    $.slimbox($target.attr('src'));
});