<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    exit;
}


if ($_POST['form_hidden'] == 'Y') {
    $nonce = $_POST['_wpnonce'];
    if (!wp_verify_nonce($nonce, 'submit_preload_POST')) {
      exit;
    }

    $preload_POST_LIST = $_POST['preload_POST_LIST'];
    update_option('preload_POST_LIST', $preload_POST_LIST);

    ?>
    <div class="updated"><p><strong><?php _e('已儲存.'); ?></strong></p></div>
    <?php
} else {
    $preload_POST_LIST = get_option('preload_POST_LIST');
}
?>
<style>
  #listURL{width:49%; height:400px;}
  #reloaded{border: solid 1px #333; padding:30px;}
  #loadframe{width:49%; height:400px; border:solid 1px #333;}
  #savebtn{display: inline-block; background: #222; color:#fff; padding:5px 10px; border:0; margin-bottom: 20px;}
  #START,#STOP{
    display: inline-block;
    background:#222;
    color:#fff;
    padding:7px 10px;
    margin-top: 7px;
  }
</style>
<h1>文章預載快取</h1>
<form name="preload_POST_LIST_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <?php wp_nonce_field('submit_preload_POST'); ?>
    <textarea name="preload_POST_LIST" id="listURL" cols="30" rows="10"><?php echo $preload_POST_LIST ?></textarea>
    <iframe id="loadframe" frameborder="0"></iframe>
    <input type="hidden" name="form_hidden" value="Y">
    <input type="submit" name="Submit" id="savebtn" value="<?php _e('儲存預載清單', 'jv_preload_POST_LIST' ) ?>" />
    <hr>
    <a href="#" id="START">開始</a> | <a href="#" id="STOP">停止</a>
    <div id="reloaded"></div>
    <hr>
    外掛開發：<a href="https://www.minwt.com">梅問題教學網</a>
    <hr>
</form>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script>
$(function(){
  var arr = $("#listURL").val().split(',');
  var arrTotal = arr.length;
  var i = 0;
  $("#START").click(function() {
    $("#reloaded").html('');
    i = 0;
    load(i);

    return false;
  });
  $("#STOP").click(function() {
    i = -1;

    return false;
  });

  var iframe;
   function load(i) {
     iframe = document.getElementById("loadframe");
     iframe.onload = iframe.onreadystatechange = iframeload;
     iframe.src = arr[i];
   }
   function iframeload() {
      if (!iframe.readyState || iframe.readyState == "complete") {
        if(i!= -1){
            $("#reloaded").html($("#reloaded").html()+i+"/"+(arrTotal-1)+arr[i]+"---已預截<br>");
           if(i!= arrTotal-1){
              i++;
          load(i);
           }
         }
      }
      console.log(i);
    }

});
</script>
