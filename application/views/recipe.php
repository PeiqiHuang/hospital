<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>处方</title>

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
          <h1 class="text-center">处方</h1>
          <table class="table table-bordered" >
            <thead id="infoHead">
              <tr><th>姓名</th><th>性别</th><th>年龄</th><th>电话</th><th>地址</th><th>诊断</th></tr>
            </thead>
            <tbody id="infoBody"></tbody>
          </table>
          <table class="table table-bordered" >
            <thead id="medicineHead">
              <tr><th>药名</th><th>剂量</th><th>每天次数</th><th>天数</th><th>备注</th></tr>
            </thead>
            <tbody id="medicineBody">
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td></td><td></td><td></td><td></td><td></td></tr>
            </tbody>
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

// -------- set info -------- //
var name = "<?=$name?>";
var gender = "<?=$gender?>";
var age = "<?=$age?>";
var phone = "<?=$phone?>";
var address = "<select><option></option>";
var area = 
["CA长安","CP常平","CS茶山","DC东城","DJ道滘","DK东坑","DLS大岭山","DL大朗","FG凤岗","GB高埗","GC莞城","GZ广州","HJ厚街","HJ黄江","HL横沥","HM洪梅","HM虎门","LB寮步","MC麻涌","NC南城","QQ清溪","QS企石","QT桥头","SJ石碣","SL石龙","SP石排","ST沙田","SZ深圳","TX塘厦","WJ万江","WND望牛墩","XG谢岗","XG香港","ZMT樟木头","ZT中堂"];

for (var i = 0;i < area.length; i++) {
  address += "<option>" + area[i] + "</option>";
}
address += "</select>";

var zhenduan = "<select><option></option>";
var zds = ["感冒","银屑病","脱发"];
for (var i = 0;i < zds.length; i++) {
  zhenduan += "<option>" + zds[i] + "</option>";
}
zhenduan += "</select>";

$("<tr><td>"+name+"</td><td>"+gender+"</td><td>"+age+"</td><td>"+phone+"</td><td>"+address+"</td><td>"+zhenduan+"</td></tr>").appendTo("#infoBody");
// -------- end set info -------- //

// -------- set medicine -------- //
var MEDICINE_DATA = <?=$medicines?>;
var medicineSelect = "<select name='medicineName'><option></option>";
for (var i = 0;i < MEDICINE_DATA.length; i++) {
  medicineSelect +="<option>" + MEDICINE_DATA[i]["name"] + "</option>";
}
dosageSelect += "</select>";

var dosageSelect = "<select><option></option>";
for (var i = 1;i < 101; i++) {
  dosageSelect +="<option>" + i + "</option>";
}
dosageSelect += "</select>";

var tds = $("#medicineBody").children();
// alert(tds.length);
for (var i = 0;i < tds.length; i++) {
  tds.eq(i).children().first().html(medicineSelect);
  tds.eq(i).children().eq(1).html(dosageSelect);
}

$("#medicineBody tr td select[name='medicineName']").bind("change", function(){
  var url = "<?=site_url()?>/recipe/getMedicine/" + $(this).val();
  var $select = $(this);
  $.get(url, function(medicine){
    var $dosage = $select.parent().parent().children().eq(1).children().first();
    alert($dosage.find("option[text='"+medicine.countPerTime+"']").text())
    // $dosage.find("option[text='"+medicine.countPerTime+"']").attr("selected",true);
  },"json");
});

// -------- end set medicine -------- //
});

</script>
  </body>
</html>