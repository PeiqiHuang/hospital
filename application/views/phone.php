<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>phone</title>

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
        background-color: rgb(247,245,240);//#F9F9F9;
      }
      button strong{
        /*font-size: 300%;*/
      }
      h1 strong{
        /*font-size: 200%;*/
      }
      #div-table div{
        padding: 0 5px 5px 0;
      }
    </style>
  </head>
  <body>
  <div class="container" id="container">
    <div class="row">
      <div class="col-md-12 text-center" id="div-head">
        <h1><strong id="inputTxt">请输入联系电话</strong></h1>
      </div>
      <div class="col-md-12 text-center" id="div-table">
        <div class="col-md-12">
          <button class="btn  btn-primary"><strong>1</strong></button>
          <button class="btn  btn-primary"><strong>2</strong></button>
          <button class="btn  btn-primary"><strong>3</strong></button>
        </div>
        <div class="col-md-12">
          <button class="btn  btn-primary"><strong>4</strong></button>
          <button class="btn  btn-primary"><strong>5</strong></button>
          <button class="btn  btn-primary"><strong>6</strong></button>
        </div>
        <div class="col-md-12"> 
          <button class="btn  btn-primary"><strong>7</strong></button>
          <button class="btn  btn-primary"><strong>8</strong></button>
          <button class="btn  btn-primary"><strong>9</strong></button>
        </div>
        <div class="col-md-12"> 
          <button class="btn  btn-warning" id="resetBtn"><strong>重写</strong></button>
          <button class="btn  btn-primary"><strong>0</strong></button>
          <button class="btn  btn-success" id="submitBtn"><strong>确认</strong></button>
      </div>
    </div>
  </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
    <?php if($isMobile == 1)
      echo "<script src='".base_url()."asserts/js/touche.min.js'></script>";
    ?>
    
    <script type="text/javascript">
      $(document).ready(function(){
        
        function position(){
          var HEIGHT = $(window).height();
          var WIDTH = $(window).width();

          $("#container").height(HEIGHT);
          // #div-head
          $("#div-head").height(HEIGHT*0.15);
          // #div-table
          $("#div-table").height(HEIGHT*0.75);
          var btnHeight = $("#div-table").height()/4-20;
          //button
          $("#div-table button").height(btnHeight);
          $("button").width($("button").height());

          // 文字大小
          $("#div-head h1").css("font-size", $("#div-head").height()*0.6);
          $("button strong").css("font-size", $("#div-head").height()*0.4);
        }
        position();

        $(window).resize(function() {
          position();
        });

        var primaryTxt = $("#inputTxt").text();
        var wrongTxt = "号码错误，请重输";

        // number click
        $(".btn-primary").click(function(){
          var oldTxt = $("#inputTxt").text();
          if($("#inputTxt").text() == primaryTxt || $("#inputTxt").text() == wrongTxt){
            oldTxt = "";
          }
          if(oldTxt.length<11){
            if(oldTxt.length == 0 && $(this).text() == 0){
              // don't show
            }else{
              $("#inputTxt").text(oldTxt + $(this).text());
            }
          }
        });

        // reset click
        $("#resetBtn").click(function(){
          $("#inputTxt").text(primaryTxt);
        });

        // submit click
        $("#submitBtn").click(function(){
          var phone = $("#inputTxt").text();
          if((phone.length == 8 || phone.length == 11) && phone != primaryTxt && phone != wrongTxt){
            var url = "<?=site_url()?>/guahao/finish/" + phone;
            location.href = url;
            // alert(localStorage.Guahao_isAfternoon)
            $("#isAfternoon").val(localStorage.Guahao_isAfternoon);
            $("#name").val(localStorage.Guahao_name);
            $("#gender").val(localStorage.Guahao_gender);
            $("#age").val(localStorage.Guahao_age);
            $("#phone").val(phone);
            $("#form").submit();
          }else{
            $("#inputTxt").text(wrongTxt);
          }
        });

        // var tablePadding = (HEIGHT-$("#div-table").height()-$("#div-head").height())/2;
        // var tablePadding2 = ($("#container").width()-$("#div-table").width())/2;

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

<form method="post" action="<?=site_url()?>/guahao/finish" id="form">
  <input type="hidden" id="isAfternoon" name="isAfternoon"/>
  <input type="hidden" id="name" name="name"/>
  <input type="hidden" id="gender" name="gender"/>
  <input type="hidden" id="age" name="age"/>
  <input type="hidden" id="phone" name="phone"/>
</form>      
  </body>
</html>