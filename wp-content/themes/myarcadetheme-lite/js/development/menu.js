jQuery(document).ready(function($){
  var mouse_mt_menu = false;

  // open
  $(document.body).on('click', '#header_magazine .menu-botn' ,function(e){
    e.preventDefault();
    $('.menu > ul').toggleClass('in');
  });

  // close
  $('#header_magazine .menu').hover(function(){
    mouse_mt_menu=true;
  }, function(){
    mouse_mt_menu=false;
  });

  $("body").mouseup(function(){
    if(! mouse_mt_menu) $('#header_magazine .menu > ul').removeClass('in');
  });

  // submenu
  $("#header_magazine .menu-item-has-children > a").click(function(e) {
    e.preventDefault();
    $( this ).toggleClass( "submdbact" );
    $( this ).next().toggleClass( "submdb" )
  });

  var menu_active = false;

  $('#header_horizontal .menu-botn').click(function () {
    if ( ! menu_active ) {
      $('#header_horizontal .cont .menu').animate({left:'0px'}, 100);
      menu_active = true;
    }
    else {
      $('#header_horizontal .menu').animate({left:'-350px'}, 100);
      menu_active = false;
    }
  });
});