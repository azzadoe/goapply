jQuery(document).ready(function($){
  $( "#mt_design_cat" ).change(function() {
    var value = this.value;
    var url = window.location.href;

    $('#ajaxcat > main').html('<span id="loading" class="fa-spinner">'+MtCat.loading+'</span>');

    $.post(MtCat.ajaxurl, {
      'action': 'mt_cat_action',
      'design': value,
      'type': 1,
      'nonce': MtCat.nonce
    },
    function(html) {
      $( "#ajaxcat" ).load( url+" #ajaxcat > main", function() {
        $("select").selecter({customClass:"mt-slct"});
        $.getScript(MtCat.file);
        if ( typeof(echo) !== 'undefined' ){
          echo.render();
        }
      });
    });
  });

  $( "#mt_order_cat" ).change(function() {
    var value = this.value;
    var url = window.location.href;

    $('#ajaxcat > main').html('<span id="loading" class="fa-spinner">'+MtCat.loading+'</span>');

    $.post(MtCat.ajaxurl, {
      'action': 'mt_cat_action',
      'order': value,
      'type': 2,
      'nonce': MtCat.nonce
    },
    function(html) {
      $( "#ajaxcat" ).load( url+" #ajaxcat > main", function() {
        $("select").selecter( {customClass:"mt-slct"} );
        $.getScript(MtCat.file);
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
