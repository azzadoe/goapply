jQuery(document).ready(function($){
  $( "#mt_design_tag" ).change(function() {
    var value = this.value;
    var url = window.location.href;

    $('#ajaxtag > main').html('<span id="loading" class="fa-spinner">'+MtTag.loading+'</span>');

    $.post(MtTag.ajaxurl, {
      'action': 'mt_tag_action',
      'design': value,
      'type': 1,
      'nonce': MtTag.nonce
    },
    function(html) {
      $( "#ajaxtag" ).load( url+" #ajaxtag > main", function() {
        $("select").selecter({customClass:"mt-slct"});
        $.getScript(MtTag.file);
        if ( typeof(echo) !== 'undefined' ){
          echo.render();
        }
      });
    });
  });

  $( "#mt_order_tag" ).change(function() {
    var value = this.value;
    var url = window.location.href;

    $('#ajaxtag > main').html('<span id="loading" class="fa-spinner">'+MtTag.loading+'</span>');

    $.post(MtTag.ajaxurl, {
      'action': 'mt_tag_action',
      'order': value,
      'type': 2,
      'nonce': MtTag.nonce
    },
    function(html) {
      $( "#ajaxtag" ).load( url+" #ajaxtag > main", function() {
        $("select").selecter( {customClass:"mt-slct"} );
        $.getScript(MtTag.file);
        if ( typeof(echo) !== 'undefined' ) {
          echo.render();
        }
      });
    });
  });

  $( ".description-trigger-button .fa-angle-down" ).on( 'click', function() {
    $( ".titl .description div").removeClass("collapsed");
    $( ".description-trigger-button .fa-angle-down").addClass("hide");
    $( ".description-trigger-button .fa-angle-up").removeClass("hide");
  });
  $( ".description-trigger-button .fa-angle-up" ).on( 'click', function() {
    $( ".titl .description div").addClass("collapsed");
    $( ".description-trigger-button .fa-angle-down").removeClass("hide");
    $( ".description-trigger-button .fa-angle-up").addClass("hide");
  });
});
