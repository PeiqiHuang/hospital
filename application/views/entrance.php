<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>门诊系统</title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style>
      .col-xs-4{margin:50px 0;}
      h1 strong{font-size:60px}
      a strong{font-size:40px}
  </style>
  <body>
  <div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
          	<h1 class="text-center"><strong>门诊系统</strong></h1>
	        <div class="col-xs-4">
		        <a href="<?=site_url()?>/guahao" type="button" class="btn btn-lg btn-block btn-primary"><strong><span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> 挂号处</strong></a>
	        </div>  
	        <div class="col-xs-4">
		        <a href="<?=site_url()?>/guahao/doctor" type="button" class="btn btn-lg btn-block btn-primary"><strong><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 医生</strong></a>
	        </div> 
	        <div class="col-xs-4">
		        <a href="<?=site_url()?>/guahao/display/5" type="button" class="btn btn-lg btn-block btn-primary"><strong><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> 显示屏</strong></a>
	        </div> 	    
	        <div class="col-xs-4">
		        <a href="<?=site_url()?>/medicine/" type="button" class="btn btn-lg btn-block btn-warning"><strong><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> 药品库</strong></a>
	        </div> 	 
	        <div class="col-xs-4">
              <a href="<?=site_url()?>/common/table/patient/false" type="button" class="btn btn-lg btn-block btn-warning"><strong><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> 处方</strong></a>
	        </div>
	        <div class="col-xs-4">
		        <a href="<?=site_url()?>/common/table/unit/true" type="button" class="btn btn-lg btn-block btn-warning"><strong><span class="glyphicon glyphicon-grain" aria-hidden="true"></span> 药物单位</strong></a>
	        </div> 		
          <div class="col-xs-4">
            <a href="<?=site_url()?>/common/table/diagnosis/true" type="button" class="btn btn-lg btn-block btn-danger"><strong><span class="glyphicon glyphicon-grain" aria-hidden="true"></span> 诊断管理</strong></a>
          </div> 
          <div class="col-xs-4">
            <a href="<?=site_url()?>/common/table/药品捆绑/true" type="button" class="btn btn-lg btn-block btn-danger"><strong><span class="glyphicon glyphicon-grain" aria-hidden="true"></span> 药品捆绑</strong></a>
          </div>  
          <div class="col-xs-4">
            <a href="<?=site_url()?>/common/table/入货/true" type="button" class="btn btn-lg btn-block btn-danger"><strong><span class="glyphicon glyphicon-grain" aria-hidden="true"></span> 入货</strong></a>
          </div>          		                   	        
        </div>      
    </div>
  </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>