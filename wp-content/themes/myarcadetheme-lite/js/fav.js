jQuery(document).ready(function($){
  $('#lnkfav').on("click", ".wpfp-link", function(e) {
    e.preventDefault();
    var type = $(this).data( "type" );
    var id = $(this).data( "id" );
    var href = $(this).attr('href');
    url = document.location.href.split('#')[0];
    params = href.replace('?', '') + '&ajax=1';

    $(".wpfp-linkmt").hide();

    if(type=='remove'){
      var type_f = 'add';
      var classfav = 'fa-heart mtfav-add';
      var textfav = MtFav.txt_add;
      var content = '&#xf057;';
    }

    if(type=="add"){
      var type_f = 'remove';
      var classfav = 'fa-times-circle mtfav-remove';
      var textfav = MtFav.txt_remove;
      var content = '&#xf004;';
    }

    jQuery.get(url, params, function(data) {
      // Update data
      $('.wpfp-span .wpfp-img').hide();
      $('#lnkfav .wpfp-span .wpfp-linkmt').replaceWith('<a data-type="'+type_f+'" data-id="'+id+'" data-tp="1" class="wpfp-link wpfp-linkmt ictxt '+classfav+'" href="?wpfpaction='+type_f+'&amp;postid='+id+'" title="'+textfav+'" rel="nofollow">'+content+'</a>');
      $(".wpfp-linkmt").show();
    });
  });
});