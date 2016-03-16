<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>药品库</title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      select{
        margin: 0 10px 0 0;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="text-center">药品管理</h1>
          <table class="table" >
            <thead>
              <tr>
                <th colspan=3><button class="btn btn-success  btn-block" id="newMedBtn">新增药品</button></th>
                <th colspan=3><input type="text"  style="float:right;" class="" id="searchText"/></th>
                <th colspan=3><button class="btn btn-success  btn-block" id="searchMedBtn">搜索</button></th>
                <th colspan=1><select id="delSelect"  style="float:right;" class=""></select></th>
                <th colspan=3><button class="btn btn-warning   btn-block" id="delMedBtn">删除药品</button></th>
              </tr>
            </thead>
          </table>
<!--           <div class="col-xs-6" style="padding:0 0 10px 0;text-align:left;">
            <button class="btn btn-success btn-lg" id="newMedBtn">新增药品</button>
          </div>
          <div class="col-xs-6" style="padding:0 0 10px 0;text-align:right;">
            <input type="text" />
            <button class="btn btn-success btn-lg" id="newMedBtn">新增药品</button>
            <select id="delSelect"></select>
            <button class="btn btn-warning btn-lg" id="delMedBtn">删除药品</button>
          </div> -->
          <table class="table table-bordered table-hover" >
            <thead id="thead">
              <tr><th>号码</th><th>编码</th><th>药名</th><th>单位</th><th colspan=2>含量</th><th>剂量</th><th>次/天</th><th>天数</th><th>公司</th><th>备注</th><th>售价</th><th>操作</th></tr>
            </thead>
            <tbody id="medicineBody"></tbody>
          </table>
        </div>
      </div>
    </div>
    

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
<!--<script src="<?=base_url()?>asserts/js/jquery.min.js"></script>-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
<?php if($isMobile == 1)
  echo "<script src='".base_url()."asserts/js/touche.min.js'></script>";
?>
<script type="text/javascript">

$(document).ready(function(){

  var MEDICINE_DATA = <?=$medicines?>;
  var $medicineBody = $("#medicineBody");
  // var $medicineItem = $("#medicineBody tr");
  var $newMedBtn = $("#newMedBtn");

  function showAllMedicines(){
    for(var i = 0;i<MEDICINE_DATA.length; i++){
      prependMedicineRow(MEDICINE_DATA[i]);
    }
  }
  showAllMedicines();

  function prependMedicineRow(data){
      var id = data["id"];
      var code = data["code"];
      var name = data["name"];
      var unit = data["unit"];
      var contain = data["contain"];
      var basicUnit = data["basicUnit"];
      var countPerTime = data["countPerTime"] + data["basicUnit"] + "/次";
      var countPerDay = data["countPerDay"] + "次/天";
      var days = data["days"] + "天";
      var company = data["company"];
      var remark = data["remark"];
      var price = data["price"];
      price = price == null ? "" : price;

      if(company == null){
        company = "-";
      }
      if(remark == null){
        remark = "-";
      }

      var tr = "<tr>";
      tr += "<td>" + id + "</td>";
      tr += "<td>" + code + "</td>";
      tr += "<td>" + name + "</td>";
      tr += "<td>" + unit + "</td>";
      tr += "<td>" + contain + "</td>";
      tr += "<td>" + basicUnit + "</td>";
      tr += "<td>" + countPerTime + "</td>";
      tr += "<td>" + countPerDay + "</td>";
      tr += "<td>" + days + "</td>";
      tr += "<td>" + company + "</td>";
      tr += "<td>" + remark + "</td>";
      tr += "<td>" + price + "</td>";
      tr += "<td>";
      tr += "<a target='_blank' href='file/"+code+"' name='file'><span class='glyphicon glyphicon-file' aria-hidden='true'>说明书</span></a>";
      tr += "&nbsp";
      tr += "<a target='_blank' href='seein/"+id+"' name='seein'><span class='glyphicon glyphicon-copy' aria-hidden='true'>进货记录</span></a>";
      tr += "</td>";
      tr += "</tr>";
      $medicineBody.prepend(tr);
  }

  function updateMedicine(){
    $(document).on("click", "#medicineBody tr td", function(){
      if ("file" == $(this).children().first().attr("name")) return;
      //------ ignore new line
      if($(this).find("select").length > 0) return;
      if($(this).find("input").length > 0) return;
      //------
      $(this).css("background-color", "yellow");
      var index = $(this).index();
      var idText = $(this).parent().children().first().text();
      var thisText = $(this).text();
      var url = "<?=site_url()?>/medicine/updateMedicine/" + idText + "/" + index + "/";
      var item = "";
      switch(index){
        case 0 :
          item = showPrompt("号码");
          break;
        case 1 :
          item = showPrompt("编码");
          break;      
        case 2 :
          item = showPrompt("药名");
          break;
        case 3 :
          item = showPrompt("单位");
          break;
        case 4 :
          item = showPrompt("含量");
          if (isNaN(item)) {
            alert("请输入数字");
            item = null;
          }
          break;
        case 5 :
          item = showPrompt("小单位");
          break;
        case 6 :
          item = showPrompt("剂量");
          if (isNaN(item)) {
            alert("请输入数字");
            item = null;
          }
          break;
        case 7 :
          item = showPrompt("次/天");
          if (isNaN(item)) {
            alert("请输入数字");
            item = null;
          }
          break;
        case 8 :
          item = showPrompt("天数");
          if (isNaN(item)) {
            alert("请输入数字");
            item = null;
          }
          break;                    
        case 9 :
          item = showPrompt("公司名");
          break;   
        case 10 :
          item = showPrompt("备注");
          break;     
         case 11 :
          item = showPrompt("价格");
          if (isNaN(item)) {
            alert("请输入数字");
            item = null;
          }
          break;                                
      }
      if(item != null){
        url += item;
        var $td = $(this);
        // alert(url)
        $.get(url, function(result){
          if (1 != result) {
            alert(result);
            return;
          }
          $td.css("background-color", "lightgreen");
          if (index == 6 || index == 7 || index == 8) {
            var result = item + thisText.replace(/[0-9]/ig, "");
            $td.text(result);
          } else {
            $td.text(item);
          }
        });
      }else{
          $(this).css("background-color", "white");
      }
    });
  }
  updateMedicine();


  function showPrompt(tips){
    var item = prompt(tips,"");
    return item;
  }

  function newMedLine(){
    $newMedBtn.on("click", function(){
      if($(this).text() == "新增药品"){
        $(this).text("提交");
        var url = "<?=site_url()?>/medicine/getUnits";
        $.get(url, function(data){
          var unitArray = data.split(",");
          var basicUnit = unitArray[0];
          var ids = getIdOptions();
          var units = getUnitOptions(unitArray);
          // var numbers = getNumberOptions();
          var tr = "<tr>";
          tr += "<td>"+ids+"</td>";
          tr += "<td><input type='text'name='code' /></td>";
          tr += "<td><input type='text'name='name' /></td>";
          tr += "<td>"+units+"</td>";
          tr += "<td>"+getNumberOptions()+"</td>";
          tr += "<td>"+units+"</td>";
          tr += "<td>"+getNumberOptions("countPerTime")+"<span name='basicUnit'>"+basicUnit+"</span>/次</td>";
          tr += "<td>"+getNumberOptions("countPerDay")+"次/天</td>";
          tr += "<td>"+getNumberOptions("days")+"天</td>";
          tr += "<td><input type='text'name='company' /></td>";
          tr += "<td><input type='text'name='remark' /></td>";
          tr += "<td><input type='text'name='price' /></td>";
          tr += "</tr>";
          $medicineBody.prepend(tr);
          // --------- set basic unit ---------
          var $select = $medicineBody.find("select").eq(3);
          $select.bind("change", function(){
            $("span[name='basicUnit']").text($(this).find("option:selected").first().text());
          });
          // ----------------------------------
        });
      }else if($(this).text() == "提交"){
        // var trs = $medicineBody.children().last().children();
        var id = getSelected(0);
        var code = getInput(0);
        var name = getInput(1);
        var price = getInput(4);
        if(id == ""){
          alert("号码不能为空");
          return;
        }  
        if(code == ""){
          alert("编码不能为空");
          return;
        }
        if(name == ""){
          alert("药名不能为空");
          return;
        }
        if(price == ""){
          alert("售价不能为空");
          return;
        }
        var url = "<?=site_url()?>/medicine/checkMedicineIdUnique/"+id;
        $.get(url, function(taken){
          if(taken == 0){
            var unit = getSelected(1);
            var contain = getSelected(2);
            var basicUnit = getSelected(3);
            var countPerTime = getSelected(4);
            var countPerDay = getSelected(5);
            var days = getSelected(6);
            var company = getInput(2);
            var remark = getInput(3);
            if ("" == company) company = "-";
            if ("" == remark) remark = "-";

            var url = "<?=site_url()?>/medicine/insertNewMedicine/"+id+"/"+code+"/"+name+"/"+unit+"/"+contain+"/"+basicUnit+"/"+countPerTime+"/"+countPerDay+"/"+days+"/"+company+"/"+remark+"/"+price;
            $.get(url, function(data){
              $medicineBody.children().first().remove();
              var newRowData = {
                  "id":id,
                  "code":code,
                  "name":name,
                  "unit":unit,
                  "contain":contain,
                  "basicUnit":basicUnit,
                  "countPerTime":countPerTime,
                  "countPerDay":countPerDay,
                  "days":days,
                  "company":company,
                  "remark":remark,
                  "price":price
                };
              prependMedicineRow(newRowData);
              $newMedBtn.text("新增药品");
            });
          }else{
            alert("该编码已使用！")
          }
        });
      }
    });
  }
  newMedLine();


  function getSelected(selectIndex){
    return $medicineBody.find("option:selected").eq(selectIndex).text();
  }  
  function getInput(inputIndex){
    return $medicineBody.find("input").eq(inputIndex).val();
  }

  function getUnitOptions(unitArray){
    var options = "";
    for(var i = 0;i<unitArray.length; i++){
      if(unitArray[i] == "") continue;
      options += "<option>" + unitArray[i] + "</option>";
    }
    return "<select>"+options+"</select>";
  }
  // create a number select
  function getNumberOptions(type, unit) {
    var begin = 1, end = 999, step = 1;
    if ("countPerTime" == type) {
      begin = 0.5;
      end = 100;
      step = 0.5;
    } else if ("countPerDay" == type) {
      begin = 1;
      end = 3;
    } else if ("days" == type) {
      var days = [1,2,3,5,7,10,14,15,20,28,30,45,60];
      var result = "<select name='"+type+"'>";
      for (var i=0; i < days.length; i++) {
        result += "<option value='"+days[i]+"'>"+days[i]+"</option>";
      }
      result += "</select>";
      return result;
    }
    var result = "<select name='"+type+"'>";
    for (var i=begin; i <= end; i+=step) {
      result += "<option value='"+i+"'>"+i+"</option>";
    }
    result += "</select>";
    return result;
  }  
  function getIdOptions(){
    var url = "<?=site_url()?>/medicine/getUsedMedicineIds/" + getRandom();
    // alert(url)
    var options = "";
    $.ajaxSetup({async : false}); // make options return
    $.get(url, function(ids){
      var max = 999;
      for(var i = 1;i<=max; i++){
        if(containsId(ids, i)) continue;
        options += "<option>" + i + "</option>";
      }
    },"json");
    $.ajaxSetup({async : true}); // retore
    return "<select>"+options+"</select>";
  }
  function containsId(ids, id){
    if(ids == null) return false;
    var result = false;
    $.each(ids, function(){
      if (this.id == id) {
        // console.info("already id = " + id);
        result = true;
        return false;
      }
    });
    return result;
  }

  function setDelSelectData(){
    var options = "<option></option>";
    for(var i = 0;i<MEDICINE_DATA.length; i++){
      options += "<option>"+MEDICINE_DATA[i]["name"]+"</option>";
    }
    // alert(options)
    $("#delSelect").append(options);
  }
  setDelSelectData();

  function delMedicine(){
    $("#delMedBtn").on("click",function(){
      var selected = $("#delSelect option:selected").text();
      // alert(selected)
      if(selected != ""){
        var url = "<?=site_url()?>/medicine/delMedicine/"+selected;
            // alert(url)
            $.get(url, function(data){
              // delete table item
              $medicineBody.children().each(function(i,tr){
                if($(tr).children().eq(1).text() == selected){
                  $(tr).remove();
                }
              });
              // delete select item
              $("#delSelect").children().each(function(i,option){
                if($(option).text() == selected){
                  $(option).remove();
                }
              });
            });
      }
    });
  }
  delMedicine();

  function getRandom() {
    return Math.ceil(Math.random()*35);
  }

  $("#searchText").val("");

  $(document).on("keydown", "#searchText", function(e){
    if (e.keyCode && 13 == e.keyCode) {
      filterTable();
    }
  });
  $(document).on("click", "#searchMedBtn", function(e){
    filterTable();
  });

  function filterTable() {
    var text = $("#searchText").val();
    $("#medicineBody").children().each(function(){
      if ("" == text) {
        $(this).css("display","");
      }else {
        text = text.toUpperCase();
        var number = $(this).children().eq(0).text();
        var code = $(this).children().eq(1).text();
        if (code.indexOf(text) == 0 || number.indexOf(text) == 0) {
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