<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>name</title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  <script src="<?=base_url()?>asserts/jSignature/libs/modernizr.js"></script>
  <!--[if lt IE 9]>
  <script type="text/javascript" src="jSignature/libs/flashcanvas.js"></script>
  <![endif]-->
  <style type="text/css">
    body{
            display: none;
          background-color: rgb(247,245,240);//#F9F9F9;  
        }  
    input {
      padding: .5em;
      margin: .5em;
    }
    select {
      padding: .5em;
      margin: .5em;
    }
    
    #signatureparent {
      color:darkblue;
      //background-color:darkgrey;
      /*max-width:600px;*/
      padding:20px;
    }
    
    /*This is the div within which the signature canvas is fitted*/
    #signature {
      border: 2px dotted black;
      background-color:lightgrey;
    }

    /* Drawing the 'gripper' for touch-enabled devices */ 
    html.touch #content {
      float:left;
      width:92%;
    }
    html.touch #scrollgrabber {
      float:right;
      width:4%;
      margin-right:2%;
      background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)
    }
    html.borderradius #scrollgrabber {
      border-radius: 1em;
    }
     
  </style>    
  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12" id="div-head">
          <h1 class="text-center"><strong>请写上你的名字</strong></h1>
          <h2 class="text-center" style="color:red;"><strong>请在灰框内书写</strong></h2>
        </div>
    </div>
  </div>
  <div id="canvas" style="width:100%;">
    <div id="content" style="width:100%">
      <div id="signatureparent" style="width:100%">
        <!--<div style="text-align:center;">请输入你的名字</div>-->
        <div id="signature"></div>
      </div>
      <!--<div id="tools"></div>-->
      <!--<div><p>Display Area:</p><div id="displayarea"></div></div>-->
    </div>
    <!--<div id="scrollgrabber"></div>-->
  </div>  
  <div class="container-fluid" id="div-btn">
    <div class="row">
      <div class="col-xs-6 text-center">
        <button type="button" class="btn btn-lg btn-block btn-warning" id="reSetBtn"><h1><strong>重写</strong></h1></button>
      </div>
      <div class="col-xs-6 text-center">
        <button type="button" class="btn btn-lg btn-block btn-success" id="nextBtn"><h1 class="text-center"><strong>下一步</strong></h1></button>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>asserts/js/touche.min.js"></script>

<!-- signature -->
<script>
/*  @preserve
jQuery pub/sub plugin by Peter Higgins (dante@dojotoolkit.org)
Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.
Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
http://dojofoundation.org/license for more information.
*/
(function($) {
  var topics = {};
  $.publish = function(topic, args) {
      if (topics[topic]) {
          var currentTopic = topics[topic],
          args = args || {};
  
          for (var i = 0, j = currentTopic.length; i < j; i++) {
              currentTopic[i].call($, args);
          }
      }
  };
  $.subscribe = function(topic, callback) {
      if (!topics[topic]) {
          topics[topic] = [];
      }
      topics[topic].push(callback);
      return {
          "topic": topic,
          "callback": callback
      };
  };
  $.unsubscribe = function(handle) {
      var topic = handle.topic;
      if (topics[topic]) {
          var currentTopic = topics[topic];
  
          for (var i = 0, j = currentTopic.length; i < j; i++) {
              if (currentTopic[i] === handle.callback) {
                  currentTopic.splice(i, 1);
              }
          }
      }
  };
})(jQuery);

</script>
<script src="<?=base_url()?>asserts/jSignature/src/jSignature.js"></script>
<script src="<?=base_url()?>asserts/jSignature/src/plugins/jSignature.CompressorBase30.js"></script>
<script src="<?=base_url()?>asserts/jSignature/src/plugins/jSignature.CompressorSVG.js"></script>
<script src="<?=base_url()?>asserts/jSignature/src/plugins/jSignature.UndoButton.js"></script> 
<script src="<?=base_url()?>asserts/jSignature/src/plugins/signhere/jSignature.SignHere.js"></script>

<!-- shake -->
<script src="<?=base_url()?>asserts/js/jshaker.js"></script>

    <?php if($isMobile == 1)
      echo "<script src='".base_url()."asserts/js/touche.min.js'></script>";
    ?>

<script>
$(document).ready(function() {
+    $("body").fadeIn("3500");
  // This is the part where jSignature is initialized.
  var $sigdiv = $("#signature").jSignature({"lineWidth":7});
  // var emptyInput = $("#signature").jSignature('getData', 'image');

  //initial position
  function position(){
    var HEIGHT = $(window).height();
        $("#div-head").height(HEIGHT*0.15);
        var margin = (HEIGHT*0.7-$("#content").height())/2-30;
        $("#content").css("margin-top", margin).css("margin-bottom", margin);

        $("#div-btn").height(HEIGHT*0.15);
        
    var height_head = $("#div-head").height();

        //文字大小
        $("#div-head h1").css("font-size", height_head*0.6);
  }
  position();
  
  $("#reSetBtn").click(function(){
    $sigdiv.jSignature('reset');
  });

  // record write name
  var WRITE_FLAG = false;
  $("#signature").click(function(){
    WRITE_FLAG = true;
  });

  $("#nextBtn").click(function(){
    var data = $("#signature").jSignature('getData', 'image');

    if(!WRITE_FLAG){
      $("#canvas").shake(2,10,400);
      $("#div-head").shake(2,10,400);
    }else{
      localStorage.Guahao_name = data;
      $("body").fadeOut();
      window.location.href = "<?=site_url()?>/guahao/gender";
    }
  });

  // no touch return to main
  function returnToMain(){
    window.location.href = "<?=site_url()?>/guahao";
  }
  var WAIT_TIME = 10000;
  var rtm = setTimeout(returnToMain, WAIT_TIME);
  $("body").click(function(){
    clearTimeout(rtm);
    rtm = setTimeout(returnToMain, WAIT_TIME);
  });

})
</script>   


  </body>
</html>