<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?=$title?></title>

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
    <div class="container-fluid"><div class="row">
        <h2 class="text-center"><?=$title?></h2>
      <div class="col-md-6 col-md-offset-3" style="padding-bottom:10px">
          <div class="col-md-4">
            <select style="" class="form-control" id="searchType" ></select>
          </div>
          <div class="col-md-4">
            <input type="text"  style="" class="form-control" id="searchText"/>
          </div>
          <div class="col-md-4">
            <button class="btn btn-success btn-block" id="searchMedBtn">搜索</button>   
          </div> 
      </div>
      <table class="table table-bordered table-hover" id = "table">
      </table>
      <div class="col-md-12 text-center" style="margin-top:-10px"><h4><?php echo $this->pagination->create_links();?></h4></div>
    </div></div></div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>asserts/js/table.js"></script>
    <script src="<?=base_url()?>asserts/js/tip.js"></script>

    <script>
      $(function(){
        var table = "<?=$table?>";
        var offset = <?=$offset?>;
    // create a table and make some config
        var t = new Table("table");
        var editable = <?=$editable?>;
        t.setEditable(editable);
        var headerInfo = <?=$headerInfo?>;
        
        var editCols = <?=$editColumnInfo?>;
        if (editable)
          t.setEditCols(editCols);
          //t.setNewLineData(["","","",13,"",90000]);

        var delFun = function($tr) {
          var id = $tr.attr("name");
          var url = "<?=site_url()?>/common/delRow/"+table+"/"+id;
          $.get(url, function(result){
            showTip(result);
          });
        }
        // add change event
        var chgFun = function($tr) { 
          var id = $tr.attr("name");
          var data = [];
          $tr.find("input").each(function(){
            data.push($(this).val());
          });
          var data = {"table":table,"id":id,"data":JSON.stringify(data)};
          // if ("undefined" == id) {
            var url = "<?=site_url()?>/common/replaceRow";
            $.post(url, data, function(result){
              showTip(result.info);
              // set row id
              if ("" != result.id && "undefined" == id)
                $tr.attr("name", result.id);
            }, 
            "json").error(function() { 
              showTip("已存在"); 
            });
        }
        // add look event
        var lookFun = function($tr) {
          var id = $tr.attr("name");
          var url = "<?=$lookUrl?>";
          if ("" != url) 
              window.open(url+"/"+id);
        }        
        t.setDelFun([delFun]);
        t.setChgFun([chgFun]);
        t.setLookFun([lookFun]);
        
    // initial table data
        function initialTable(rowsData, offset) {
          $("#table").children().remove();
          t.setHead(headerInfo);
          var rowIndex = 1;
          if (offset)
            rowIndex = offset;
          $.each(rowsData, function(){
              var row = this;
              var line = [];
              $.each(headerInfo, function(){
                line.push(row[this]);
              });
            t.addLine(line, row["id"], rowIndex++);
          });
        }
        initialTable(<?=$rowsInfo?>, offset);
        // 分页
        // var colspan = 1;
        // alert(colspan)
        // colspan += headerInfo.length();
        // $("#table").append("<tr><td colspan='5'><?php echo $this->pagination->create_links();?></td></tr>");

        // search
        $("#searchText").val("");
        $.each(headerInfo, function(i){
          $("#searchType").append("<option value='"+(i+1)+"'>"+this+"</option>");

        });

        $(document).on("keydown", "#searchText", function(e){
          if (e.keyCode && 13 == e.keyCode) {
            showSearchTable(table);
          }
        });
        $(document).on("click", "#searchMedBtn", function(e){
          showSearchTable(table);
        });

        function showSearchTable(table) {
          var colIndex = $("#searchType").val();
          var text = $("#searchText").val();
          text = text.toUpperCase();
          if (text == "") return;
          var url = "<?=site_url()?>/common/search/"+table+"/"+colIndex+"/"+text;
          var data = {"table":table,"colIndex":colIndex,"value":text};
          $.post(url, data, function(rowData){
            initialTable(rowData);
          }, "json");
        }

        function filterTable() {
          var colIndex = $("#searchType").val();
          var text = $("#searchText").val();
          $("#table tbody").children().each(function(){
            if ("" == text) {
              $(this).css("display","");
            }else {
              var $node = $(this).children().eq(colIndex);
              var code = "";
              if ($node.children().first().is("input"))
                code = $node.children().first().val();
              else
                code = $node.text();
              text = text.toUpperCase();
              if (code.indexOf(text) == 0) {
                $(this).css("display","");
              } else {
                $(this).css("display","none");
              }
            }
          });
        }

      });
    </script>
  </body>
</html>