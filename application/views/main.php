<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>挂号处</title>

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
          background-color: rgb(247,245,240);//#F2F2F2;//#F9F9F9;  
        }        
      #div-head h1 strong{
            /*font-size: 3em;*/
      }
        button h1 strong{
          /*font-size: 2em;*/
        }
        div h1 strong{
          /*font-size: 2em;*/
        }
    </style>
  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12" id="div-head">
          <h1 class="text-center"><strong>挂号处</strong></h1>
        </div>  
      <div class="col-xs-6" id="div-morning">
        <h1 class="text-center"><strong>上午等待人数:</strong><strong id="morningCount"></strong></h1>
        <button type="button" class="btn btn-lg btn-block btn-success" id="morningBtn"><h1 class="text-center"><strong>挂上午号</strong></h1></button>
      </div>  
      <div class="col-xs-6" id="div-afternoon">
        <h1 class="text-center"><strong>下午等待人数:</strong><strong id="afternoonCount"></strong></h1>
        <button type="button" class="btn btn-lg btn-block btn-success" id="afternoonBtn"><h1 class="text-center"><strong>挂下午号</strong></h1></button>
      </div>      
    </div>
  </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
    <?php 
      if($isMobile == 1)
        echo "<script src='".base_url()."asserts/js/touche.min.js'></script>";
    ?>
    <script>
    $(document).ready(function() {

      // clear localStorage
      // localStorage.removeItem("Guahao_isAfternoon");
      localStorage.removeItem("Guahao_name");
      localStorage.removeItem("Guahao_gender");
      localStorage.removeItem("Guahao_age");
      localStorage.removeItem("Guahao_phone");


      $("button").removeAttr("disabled");
      
      //initial position
      function position(){
        var HEIGHT = $(window).height();
                $("#div-head").height(HEIGHT*0.3);
                $("morningCount").height(HEIGHT*0.2);
                $("afternoonCount").height(HEIGHT*0.2);
                $("#morningBtn").height(HEIGHT*0.4);
                $("#afternoonBtn").height(HEIGHT*0.4);
                
        var height_head = $("#div-head").height();
        var height_morning = $("#div-morning").height();

                //文字大小
                $("div h1").css("font-size", height_head*0.3);
                $("div button h1").css("font-size", height_head*0.4);
                $("#div-head h1").css("font-size", height_head*0.5);

        //var height_afternoon = $("#div-afternoon").height();
        var margin_next = (HEIGHT-height_head-height_morning)/2-20;
        //$("#div-morning").css("margin-top",margin_next).css("margin-bottom",margin_next);
        //$("#div-afternoon").css("margin-top",margin_next).css("margin-bottom",margin_next);
      }
      position();

      //click now
      $("#morningBtn").click(function(){
        localStorage.Guahao_isAfternoon = 0;
        btnClickHelper();
      });

      //click afternoon
      $("#afternoonBtn").click(function(){
        localStorage.Guahao_isAfternoon = 1;
        btnClickHelper();
      });

      function btnClickHelper(){
        $("body").fadeOut();
        window.location.href = "<?=site_url()?>/guahao/name";
      }

      var moringBtnPrimaryTxt = $("#morningBtn").text();
      var afternoonBtnPrimaryTxt = $("#afternoonBtn").text();
      var moringBtnForbiddenTxt = "上午号满";
      var afternoonBtnForbiddenTxt = "下午号满";
      var lastMorningState = 0;
      var lastAfternoonState = 0;
      //refresh count
      function refresh(){
                $.get("<?=site_url()?>/guahao/refreshMain/"+Math.random(), function(data){
                    //alert(data.morningCount)
            $("#morningCount").html(data.morningCount);
            $("#afternoonCount").html(data.afternoonCount);
            // is allowed 
                    if(data.morningForbidden == 0){
                      if(lastMorningState == 1){
                      $("#morningBtn").removeAttr("disabled");
                      $("#morningBtn h1 strong").text(moringBtnPrimaryTxt);
                      lastMorningState = 0;
                    }
                    }else{
                      $("#morningBtn").attr("disabled", "disabled");
                      $("#morningBtn h1 strong").text(moringBtnForbiddenTxt);
                      lastMorningState = 1;
                    }

                    if(data.afternoonForbidden == 0){
                      if(lastAfternoonState == 1){
                      $("#afternoonBtn").removeAttr("disabled");
                      $("#afternoonBtn h1 strong").text(afternoonBtnPrimaryTxt);
                      lastAfternoonState = 0;
                    }
                    }else{
                      $("#afternoonBtn").attr("disabled", "disabled");
                      $("#afternoonBtn h1 strong").text(afternoonBtnForbiddenTxt);
                      lastAfternoonState = 1;
                    }
                },
                "json");
          setTimeout(refresh, 3000);
      }
      refresh();
            
      $("body").fadeIn("3500");
    });
  </script>

  </body>
</html>