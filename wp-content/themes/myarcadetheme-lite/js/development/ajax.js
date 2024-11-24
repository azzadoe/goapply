jQuery(document).ready(function($) {
  // Friv-Style sorting
  $( "#friv_style_games" ).change(function() {
    if ( MtAjax.friv_banner ) {
      $('#cntpromotedgames ul li:not(:first)').remove();
    }
    else {
      $('#cntpromotedgames ul li').remove();
    }
    $('#cntpromotedgames ul').before('<span id="loadingpromotedgames">'+MtAjax.loading+'</span>');
    $('#cntpromotedgames .wp-pagenavi').remove();

    var value = $('#friv_style_games option:selected').val();
    var url = window.location.href;

    $.post(MtAjax.ajaxurl, {
      'action': 'myarcadetheme_ajax_action',
      'value': value,
      'type': 'sort',
      'nonce': MtAjax.nonce
    },
    function(html) {
      if ( MtAjax.friv_banner ) {
        $('#cntpromotedgames ul li:last').after(html);
      }
      else {
        $('#cntpromotedgames ul').html(html);
      }
      $('#cntpromotedgames').append('<div id="mt-wp-pagenavi"></div>');
      $( "#mt-wp-pagenavi" ).load(url+" #cntpromotedgames .wp-pagenavi", function() {
        $('#loadingpromotedgames').remove();
        $('#cntpromotedgames .lst-gams-friv li').show();
        if( typeof(echo) !== 'undefined' ){
          echo.render();
        }
      });
    });
  });

  // Promoted games sort
  $( "#promoted_games" ).change(function() {
    var value = $('#promoted_games option:selected').val();

    $('#cntpromotedgames ul').html('<li id="loadingpromotedgames">'+MtAjax.loading+'</li>');
    $.post(MtAjax.ajaxurl, {
      'action': 'myarcadetheme_ajax_action',
      'location':'index',
      'value': value,
      'type': 'sort',
      'nonce': MtAjax.nonce
    },
    function(html) {
      $('#cntpromotedgames > ul').html(html);
      $('#cntpromotedgames .lst-gams li').show();
      if( typeof(echo) !== 'undefined' ){
        echo.render();
      }
    });
  });

  // register
  $(document.body).on('click', '#mt_register_theme button' ,function(e){
    e.preventDefault();
    $(this).text(MtAjax.loading);
    var username = $('#mt_register_theme input[name=username]').val();
    var email = $('#mt_register_theme input[name=email]').val();
    var pass = $('#mt_register_theme input[name=pass]').val();
    var passb = $('#mt_register_theme input[name=passb]').val();
    $.post(MtAjax.ajaxurl, { 'action': 'myarcadetheme_ajax_action', 'username': username, 'email': email, 'pass': pass, 'passb': passb, 'type': 'register', 'nonce': MtAjax.nonce }, function(html){
      $('#mt_register_theme button').text(MtAjax.register);
      var myArray = html.split('|');
      if(myArray[0]!=''){
        if(myArray[0]==1){
          $('#mt_register_theme input[name=username]').parent().removeClass('frm-ok').addClass('frm-no');
        }

        if(myArray[0]==0){
          $('#mt_register_theme input[name=username]').parent().removeClass('frm-no').addClass('frm-ok');
        }

        if(myArray[1]==1){
          $('#mt_register_theme input[name=email]').parent().removeClass('frm-ok').addClass('frm-no');
        }

        if(myArray[1]==0){
          $('#mt_register_theme input[name=email]').parent().removeClass('frm-no').addClass('frm-ok');
        }

        if(myArray[2]==1){
          $('#mt_register_theme input[name=pass],#mt_register_theme input[name=passb]').parent().removeClass('frm-ok').addClass('frm-no');
        }

        if(myArray[2]==0){
          $('#mt_register_theme input[name=pass],#mt_register_theme input[name=passb]').parent().removeClass('frm-no').addClass('frm-ok');
        }
      }

      if(myArray.length==1){
        $('#mt_register_theme input[name=username]').parent().removeClass('frm-no').addClass('frm-ok');
        $('#mt_register_theme input[name=email]').parent().removeClass('frm-no').addClass('frm-ok');
        $('#mt_register_theme input[name=pass],#mt_register_theme input[name=passb]').parent().removeClass('frm-no').addClass('frm-ok');
        $('#mt_register_theme .modl-titl').append(html);
        $('#mt_register_theme button').remove();
      }
    });
  });

  // login
  $(document.body).on('click', '#mt_login_theme button' ,function(e){
    e.preventDefault();
    $(this).text(MtAjax.loading);
    var username = $('#mt_login_theme input[name=log]').val();
    var forever = $('#mt_login_theme input[name=rememberme]');
    var pass = $('#mt_login_theme input[name=pwd]').val();
    if(forever.is(':checked')) { var forever='forever'; }else{ var forever=0; }
    $.post(MtAjax.ajaxurl, { 'action': 'myarcadetheme_ajax_action', 'log': username, 'pwd': pass, rememberme: forever, 'type': 'login', 'nonce': MtAjax.nonce }, function(html){
      if(html==1){
        $('#mt_login_theme button').text(MtAjax.register);
        $('#mt_login_theme input[name=log],#mt_login_theme input[name=pwd]').parent().removeClass('frm-ok').addClass('frm-no');
      }else{
        $('#mt_login_theme input[name=log],#mt_login_theme input[name=pwd]').parent().removeClass('frm-no').addClass('frm-ok');
        $.post($( "#mt_login_theme" ).attr( "action" ), { 'log': $('#mt_login_theme input[name=log]').val(), 'pwd': $('#mt_login_theme input[name=pwd]').val(), rememberme: $('#mt_login_theme input[name=rememberme]').val(), 'user-cookie': 1 }, function(html){
          window.location = $('#redirect_to').val();
        });
      }
    });
  });
});