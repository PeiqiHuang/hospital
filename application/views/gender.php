<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>gender</title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
      <style>
    body{
            display: none;
          background-color: rgb(247,245,240);//#F9F9F9;
        }  
      </style>
  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12" id="div-head"><h1 class="text-center"><strong>请选择性别</strong></h1></div>
      <div class="col-xs-6 text-center" id="div-male"><button type="button" class="btn btn-lg btn-block btn-info" id="maleBtn"><h1 class="text-center"><strong>男</strong></h1></button></div>
      <div class="col-xs-6  text-center" id="div-female"><button type="button" class="btn btn-lg btn-block btn-warning" id="femaleBtn"><h1 class="text-center"><strong>女</strong></h1></button></div>
    </div>    
  </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
    <?php if($isMobile == 1)
      echo "<script src='".base_url()."asserts/js/touche.min.js'></script>";
    ?>
    <script>
    $(document).ready(function() {

      // animation
      $("body").fadeIn("3500");

      function position(){
        var HEIGHT = $(window).height();
        $("#div-head").height(HEIGHT*0.15);
        $("#maleBtn").height(HEIGHT*0.35).css("margin-top",HEIGHT*0.25);
        $("#femaleBtn").height(HEIGHT*0.35).css("margin-top",HEIGHT*0.25);

        //文字大小
        $("#div-head h1").css("font-size", $("#div-head").height()*0.6);
        $("button h1").css("font-size", $("#div-head").height()*0.7);
      }
      position();

      $("#maleBtn").click(function(){
        localStorage.Guahao_gender = "male";
        clickHelper();
      });
      $("#femaleBtn").click(function(){
        localStorage.Guahao_gender = "female";
        clickHelper();
      });     

      function clickHelper(){
        $("body").fadeOut();
        window.location.href = "<?=site_url()?>/guahao/age";
      }

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


    });
    </script>


  </body>
</html>