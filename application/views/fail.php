<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>fail</title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
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
          <strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;挂号失败</strong>
        </p>
        <p>请重新挂号!</p>
        <p><small>即将跳转到挂号页面……</small></p>
      </div>
		</div>
	</div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function(){
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
        setTimeout("location.href='<?=site_url()?>/guahao'",3500);
      });
    </script>
  </body>
</html>