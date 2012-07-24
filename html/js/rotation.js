$(function() {
  var souris_clic = false;
  var nouveau_left = 0;
  var left_initial = -(($('.visuel').width() - $('.container').width()) / 2);
  var x_de_depart = 0;

  $('.visuel').css({
    left: left_initial
  });
  $('.visuel_bis').css({
    left: left_initial + $('.visuel').width()
  });

  var mousedownCallback = function(e) {
    souris_clic = true;
    x_de_depart = e.clientX;
    left_initial = Number($(this).find('.visuel').css('left').replace('px',''));
    $('body').css({
      cursor: 'e-resize'
    });
    $(this).addClass('current');

    e.preventDefault;
    return false;
  };
  var mouseupCallback = function(e) {
    souris_clic = false;
    $('body').css({
      cursor: 'auto'
    });
    $('.container').removeClass('current');

    e.preventDefault;
    return false;
  }
  var mousemoveCallback = function(e) {
    if (souris_clic) {
      var decalage = e.clientX - x_de_depart;
      nouveau_left = left_initial + decalage;
      $('.current .visuel').css({
        left: nouveau_left
      });
      $('.current .visuel_bis').css({
        left: nouveau_left - $('.visuel').width()
      });
      if (nouveau_left <= 0) {
        $('.current .visuel_bis').css({
          left: nouveau_left + $('.visuel').width()
        });
      }
      if (nouveau_left > $('.visuel').width()) {
        $('.current .visuel').css({
          left: nouveau_left - $('.visuel').width()*2
        });
      }
      if (nouveau_left < -($('.visuel').width())) {
        $('.current .visuel').css({
          left: nouveau_left + $('.visuel').width()*2
        });
      }
    }
  }

  $('.container').mousedown(mousedownCallback);
  $('body').mouseup(mouseupCallback)
  $('body').mousemove(mousemoveCallback);
});