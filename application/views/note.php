<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>记录</title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container-fluid"><div class="row"><div class="col-md-12 text-center">
        <h1><?=$header?></h1>
        <textarea class="form-control" rows="20" style="font-size:20px;" id="text"></textarea>
    </div></div></div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>

    <script>
      $(function(){
        $("#text").val("");
        var type = "<?=$type?>";
        var id = "<?=$id?>";
        var url = "<?=site_url()?>/common/getNote/"+type+"/"+id;
        $.get(url, function(content){
          $("#text").val(content);
        });

        $("#text").blur(function(){
          var url = "<?=site_url()?>/common/updateNote";
          var data = {"type" : type, "typeId" : id, "content" : $("#text").val()};
          $.post(url, data, function(){
            // alert("fixed");
          });
        });
      })
    </script>
  </body>
</html>