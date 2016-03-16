<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>success</title>

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
      p{
        /*font-size: 400%;*/
      }
      p strong{
        color:red;
      }
      small{
        color:grey;
      }
    </style>
  </head>
  <body>
	<div class="container-fluid">
		<div class="row">
		  <div class="col-md-12 text-center">
        <p>
          <strong  style='color:green'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;挂号成功</strong>
        </p>
        <?php if($number != -1) 
          echo "<p>您的号码是：<strong>$number</strong></p>";
        ?>
        <p>请耐性等候</p>
        <p><small>即将跳转至挂号页面</small></p>
      </div>
		</div>
	</div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function(){
        $("body").fadeIn("3500");
        function position(){
          var HEIGHT = $(window).height();
          $("p").css("font-size", HEIGHT*0.15);
        }
        position();

        var HEIGHT = $(window).height();
        var h = $(".row").height();
        var margin = (HEIGHT-h)/3;
        $(".row").css("margin-top",margin);
        // go to main page
        var WAIT_TIME = 3000;
        setTimeout("location.href='<?=site_url()?>/guahao'",WAIT_TIME);
      });
    </script>
  </body>
</html>