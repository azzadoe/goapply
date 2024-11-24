jQuery(document).ready( function($) {
  $(document).keyup( function(e){
    if( e.keyCode==27 )
      $(".lgtbxbg-pofi").fadeOut(150)
  });

  $(".lgtbxbg-pofi").click( function(e) {
    e.preventDefault();
    $(".lgtbxbg-pofi").fadeOut(150)
  });

  $(".trnlgt").click( function(e) {
    e.preventDefault();
    $(".lgtbxbg-pofi").fadeIn(150)
  });

  $(".lgtbxbg-pofi").css("opacity",0.7);
})