<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>开药</title>
    <!-- autocomplete -->
  <style>
  .autocomplete-suggestions { border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
  .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
  .autocomplete-no-suggestion { padding: 2px 5px;}
  .autocomplete-selected { background: #F0F0F0; }
  .autocomplete-suggestions strong { font-weight: bold; color: #000; }
  .autocomplete-group { padding: 2px 5px; }
  .autocomplete-group strong { font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }
  
  table,div {font-size: 15px;}
  .patient-input {width : 125px;}
  #middleDiv {height: 600px; overflow-y:auto;}
  #rightDev {height: 600px;}
  /*#showInput {height: 31px;}*/
  #candidate {height: 529px; overflow-y:auto;}
  /*#medHead {background:pink;position: fixed;top:0;}*/
  </style>
    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="scroll=no">
  <div class="container-fluid" style="padding:10px 10px">
    <div class="row">
      <!-- <div class="col-md-12"> -->
      <div class="col-xs-2">
        <table class="table table-bordered table-hover table-condensed" id="baseInfo">
          <thead><th colspan=1>病人信息</th></thead>
          <tbody>
            <tr>
              <td><img width='130px' src='' id="name"></td>
            </tr>
            <tr>
              <td>姓名&nbsp;<input type="text" class="patient-input" id="realname" value=""/></td>
            </tr>
            <tr>
              <td id="ageTD">年龄&nbsp;</td>
            </tr>
            <tr>
              <td>性别&nbsp;
                <input type="radio" name="gender" value="male" id="male"/> 男
                <input type="radio" name="gender" value="female"id="female"/> 女
              </td>
            </tr>
            <tr>
              <td>电话&nbsp;<input type="text" class="patient-input" id="phone" value=""/></td>
            </tr>
            <tr>
              <td id="addressTD" >地址&nbsp;<input type="text" class="patient-input" id="address" value=""/></td>
            </tr>
            <tr>
              <td>诊断&nbsp;<input type="text" class="patient-input" id="diagnosis" value=""/></td>
            </tr>
            <tr>
              <!-- <td><input type="text" id="totalDiagnosis" value=""/></td> -->
              <td><textarea id="totalDiagnosis" ></textarea></td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered table-hover table-condensed" id="baseInfo">
          <thead><th colspan=1>算钱</th></thead>
          <tbody>
            <tr><td>实收&nbsp;<input class="patient-input" type="text" id="giveMoney"></tr>
            <tr><td>应收&nbsp;<input class="patient-input" type="text" id="totalMoney"></tr>
            <tr><td>找零&nbsp;<input class="patient-input" type="text" id="returnMoney" style="color:red"></tr>
          </tbody>
        </table>

        <div class="btn-group btn-group-justified" role="group">
          <div class="btn-group" role="group">
            <button class="btn btn-primary" id="save" save="">保存</button>
          </div>
          <div class="btn-group" role="group">
            <button class="btn btn-info btn-large" id="preview">预览</button>
          </div>
          <div class="btn-group" role="group">
            <a href="" class="btn btn-success btn-large" id="print">打印</a>
          </div>
        </div>

      </div>
      <div class="col-xs-7" id="middleDiv">  
        <table class="table table-hover table-condensed">
          <thead id="medHead">
            <th>药名</th><th>剂量</th><th>次/天</th><th colspan=2>天数</th><th>价格</th><th></th>
          </thead>
          <tbody id="medList">
          </tbody>
        </table>

      </div>

      <div class="col-xs-3" id="rightDev">
        <div class="panel panel-success" id="inputContainer">
          <div class="panel-heading" id="showInput">&nbsp;<span id="codeInput"></span><span class="badge" style="float:right" id="medCount"></span></div>
          <div class="list-group" id="candidate"></div>
        </div>
      </div>
      <!-- </div> -->
    </div>
  </div>
    

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
<!--<script src="<?=base_url()?>asserts/print/jquery-1.4.4.min.js"></script>-->
<!--<script src="<?=base_url()?>asserts/js/jquery.min.js"></script>-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
<!-- autocomplete -->
<script type="text/javascript" src="<?=base_url()?>asserts/js/jquery.autocomplete.js"></script>
<!-- print -->
<script type="text/javascript" src="<?=base_url()?>asserts/print/jquery.printPage.js"></script>
<?php if($isMobile == 1)
  echo "<script src='".base_url()."asserts/js/touche.min.js'></script>";
?>

<script type="text/javascript">
    // 取消body滚动条
    $(document.body).css({
       "overflow-x":"hidden",
       "overflow-y":"hidden"
     });
    $("#middleDiv").height($(window).height()-20);
    $("#rightDev").height($(window).height()-50);
    // $("#showInput").height($(window).height()-30);
    $("#candidate").height($(window).height()-90);

    var DAYS = [0,1,2,3,5,7,10,14,15,20,28,30,45,60];

    $(document).ready(function(){
      // initial patient info
      var patientInfo = <?=$patientInfo?>;
      if (null == patientInfo) {
        patientInfo = new Object();
        patientInfo.id = "";
        patientInfo.name = "";
        $("#name").css("display", "none");
        patientInfo.age = 1;
        patientInfo.gender = "male";
        patientInfo.address = "";
        patientInfo.diagnosis = "";
      }
      if (null != patientInfo) {
        if ("" == patientInfo.name)
          $("#name").css("display", "none");
        else
          $("#name").attr("src", "data:"+patientInfo.name);
        $("#realname").val(patientInfo.realname);
        $("#ageTD").append(createSelect("age", patientInfo.age));
        $("#phone").val(patientInfo.phone);
        if (patientInfo.gender == "male") {
          document.getElementById("male").checked = true;
        } else {
          document.getElementById("female").checked = true;
        }
        $("#address").val(patientInfo.address);

        $("#diagnosis").val("");
        // $("#totalDiagnosis").css("width", $("#totalDiagnosis").width()*2);
        $("#totalDiagnosis").val(patientInfo.diagnosis);
      }
      $("#giveMoney").val("");
      $("#returnMoney").val("");

      // initial med info
      var MED_DATA = <?=$medInfo?>;
      if (null != MED_DATA) {
        var priceArray = [];
        $.each(MED_DATA, function(){
          priceArray.push(addMed(this));
        });
        updateTotalPrice(priceArray);
      } else {
        $("#totalMoney").val("");
        // 默认把诊金,病历本写入为一种药
        addMedByCode("ZHENJIN");
        addMedByCode("BINGLIBEN");
      }

      // print
      $("#print").printPage();


      // -----global var -----//
      
      var CANDIDATE_DATA = [];
      var GLOBAL_KEYBOARD = true;
      var ADDRESS_DATA = [
        //东莞镇区
        "CA长安","CP常平","CS茶山","DC东城","DJ道滘","DK东坑","DLS大岭山","DL大朗","FG凤岗","GB高埗","GC莞城","HJ厚街","HJ黄江","HL横沥","HM洪梅","HM虎门","LB寮步","MC麻涌","NC南城","QX清溪","QS企石","QT桥头","SJ石碣","SL石龙","SP石排","ST沙田","TX塘厦","WJ万江","WND望牛墩","XG谢岗","ZMT樟木头","ZT中堂",
        //广东省市
        "GZ广州","SZ深圳","ZH珠海","ST汕头","SG韶关","FS佛山","JM江门","ZJ湛江","MM茂名","ZQ肇庆","HZ惠州","MZ梅州","SW汕尾","HY河源","YJ阳江","QY清远","ZS中山","CZ潮州","JY揭阳","YF云浮",
        //全国省份
        "XG香港","AM澳门","TW台湾","BJ北京","TJ天津","CQ重庆","SH上海","HB河北","SX山西","LN辽宁","JL吉林","HLJ黑龙江","JS江苏","ZJ浙江","AH安徽","FJ福建","JX江西","SD山东","HN河南","HB湖北","HN湖南","HN海南","SC四川","GZ贵州","YN云南","SX陕西","GS甘肃","QH青海","NMG内蒙古","GX广西","XZ西藏","NX宁夏","XJ新疆"
      ];
      var DIAGNOSIS_DATA = <?=$diagnosis?>;
      // var DIAGNOSIS_DATA = ["","SZ湿疹","XMZ荨麻疹","CC痤疮","SJXPY神经性皮炎","GM感冒","FS发烧","NPX牛皮癣","YLB鱼鳞病","BS鼻塞","KY溃疡","FY发炎"];
      // ---------------------//

      // autocomplete for address
      $('#address').autocomplete({
        lookup: ADDRESS_DATA,
        minChars:0,
        triggerSelectOnValidInput:false,
        lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
          return  suggestion.value.toLowerCase().indexOf(queryLowerCase) == 0;
        },
        onSelect: function(suggestion) {
           $('#address').val(removeAlpha(suggestion.value));
        }
      });
      // autocomplete for diagnosis
      $('#diagnosis').autocomplete({
        lookup: DIAGNOSIS_DATA,
        minChars:0,
        triggerSelectOnValidInput:false,
        lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
          return  suggestion.value.toLowerCase().indexOf(queryLowerCase) == 0;
        },
        onSelect: function(suggestion) {
          var total = $("#totalDiagnosis").val();
          var separtor = ",";
          if ("" == total) separtor = "";
          $("#totalDiagnosis").val(total+separtor+removeAlpha(suggestion.value));
          $('#diagnosis').val("");
        }
      });

      // set input area to blank
      $("#codeInput").text("");

      // show med count
      $("#medCount").text(<?=$count?>);

      // EVENT -----------------------------------------------------------------------------------------------//
      $("body").on("keydown", function(e) {
        var code = e.keyCode;
        var codeChar = String.fromCharCode(code);
        // console.info("keycode="+code);
        if (8 == code || 27 == code) {
          // Backspace || Esc
          $("#codeInput").text("");
          $("#candidate").empty();
          // 防止浏览器后退
          if (GLOBAL_KEYBOARD) {
            if(e.preventDefault){
              e.preventDefault();
          } 
         }
        } else if (13 == code) {
          // Enter
          if (!isCandidateShow()) {
            toggleCandidate();
          } else {
            selectCandidate();
          }
        } else if (38 == code || 40 == code) {
          // 38 up 40 down
          var canLength = $("#candidate").children().length;
          $("#candidate").children().each(function(i){
            if ($(this).attr("class").indexOf("active") > -1) {
              if (38 == code && i != 0) {
                $("#candidate").children().eq(i-1).attr("class", "list-group-item active");
                $(this).attr("class", "list-group-item"); // remove active
              }else if (40 == code && i != canLength-1) {
                $("#candidate").children().eq(i+1).attr("class", "list-group-item active");
                $(this).attr("class", "list-group-item"); // remove active
              }
              return false;
            }
          });
        } else if ((code >= 48 && code <= 57) || (code >= 65 && code <= 90)) {
          // 数字或者字母
          if (GLOBAL_KEYBOARD) {
            var currentText = $("#codeInput").text();
            $("#codeInput").text(currentText + codeChar);
            currentText = $("#codeInput").text();
            if (code >= 48 && code <= 57) {
              searchMedById(currentText);
            } else {
              searchMedByCode(currentText);
            }
         }
        }
      });

  // autocomplete 输入去除字母
  // $(document).on("blur", "#address", function(){
  //   $(this).val(removeAlpha($(this).val()));
  // });

    // 输入电话地址等，防止输入药的代码
    $(document).on("focus", "input[type='text'],textarea", function(){
      GLOBAL_KEYBOARD = false;
      // if (this.id == "address" || this.id == "diagnosis")
      //  if ("" != $(this).val()) $(this).val("");
    });
      $(document).on("blur", "input[type='text']", function(){
      GLOBAL_KEYBOARD = true;
    });

      // 鼠标选择candidate
      $(document).on("mouseover", "a[class='list-group-item']", function(){
         $("#candidate").children().attr("class", "list-group-item");
         $(this).attr("class", "list-group-item active");
      });
      $(document).on("click", "a[class='list-group-item active']", function(){
         selectCandidate();
      });

      // click 删除按钮
      $(document).on("click", "button[name='delete']", function(){
        // var medId = $(this).attr("medId");
        // $("tr[name='"+medId+"']").remove();
        $(this).parent().parent().remove();
        // update duplicate info
        checkDuplicate();
      });

      // click 代码显示区
      $("#showInput").on("click", function(){
        toggleCandidate();
      });

      // 上传数据并且进入打印页面
      $("#save").on("click", function(){
        createRecipel();
      });
      $("#preview").on("click", function(){
        console.info("preview")
        openPrintPage();
      });
      $("#print").on("click", function(){
        var href = "<?=site_url()?>/mOut/showPrintPage/";
        var patientId = patientInfo.id;
        href += patientId + "/1/false/" + getRandom();
        $(this).attr("href", href);
      });

      // 剂量选择后如果有备注，更新备注
      $(document).on("change", "select[name='countPerTime']", function(){
        var remark = $(this).parent().attr("remark");
        var unit = $(this).parent().attr("unit");
        var newText = unit +getTip($(this).find("option:selected").val(), remark);
        $(this).next().text(newText);
      });

      // END OF EVENT ----------------------------------------------------------------------------------------//

      function removeAlpha(str) {
        var reg = /[a-zA-Z]/g;
        return str.replace(reg,"");
      }

      function isCandidateShow() {
        if ($("#candidate").children()) {
          return $("#candidate").children().length==0 ? false : true;
        }
        return false;
      }

      function toggleCandidate() {
        if(isCandidateShow()) {
          $("#candidate").empty();
        } else {
          searchRecentMed();
        }
      }

      // return the candidate med list
      function searchMedById(number) {
        var url = "<?=site_url()?>/mOut/getMedicineById/"+number + "/" + getRandom();
        $.get(url, function(data){
          if ("null" != data)
            CANDIDATE_DATA = eval(data);
          showCandidate(CANDIDATE_DATA);
        });
      }
      function searchMedByCode(code) {
        var url = "<?=site_url()?>/mOut/getMedicineByCode/"+code + "/" + getRandom();
        $.get(url, function(data){
          if ("null" != data)
            CANDIDATE_DATA = eval(data);
          showCandidate(CANDIDATE_DATA);
        });
      }

      function searchRecentMed() {
        var recentMedData = window.localStorage? localStorage.getItem("MOUT_RECENT_MED"): Cookie.read("MOUT_RECENT_MED");
        if (null != recentMedData) {
          var idStr = "";
          var tmpArray = recentMedData.split(",");
        $.each(tmpArray, function(){
          if ("" != this) {
            idStr += this + "_";
          }
        });
        idStr = idStr.substring(0, idStr.length-1);
          // recentMedData = recentMedData.replace(/,+/g, '_');
          var url = "<?=site_url()?>/mOut/getMedicineByIdArray/"+idStr + "/" + getRandom();
          $.get(url, function(data){
            if ("null" != data)
              CANDIDATE_DATA = data;
            showCandidate(data);
          }, "json");
        }
      }

      function saveRecentMed(id) {
        var recentMedData = window.localStorage? localStorage.getItem("MOUT_RECENT_MED"): Cookie.read("MOUT_RECENT_MED");
        var tmpArray;
        if (null == recentMedData) {
          tmpArray = [];
        } else {
          tmpArray = recentMedData.split(",");
        }
        // remove same value
        var medArray = [];
        $.each(tmpArray, function(){
          if (this != id && "" != this) {
            medArray.push(this);
          }
        });
        if (medArray.length >= 10) {
          medArray.pop();
        }
        medArray.unshift(id);
        if (window.localStorage) {
            localStorage.setItem("MOUT_RECENT_MED", medArray);  
        } else {
            Cookie.write("MOUT_RECENT_MED", medArray);  
        }
      }

      // show the candidate list
      function showCandidate(medInfo) {
        if (null != medInfo && medInfo.length > 0) {
          var candidate = "";
          var first = true;
          $.each(medInfo, function(i){
            // 过滤掉已经在table的Medicine
            // if ($.inArray(this.id, getInsertedMed()) < 0) {
              var text = this.id + " - " + this.name;
              if (first) {
                candidate += "<a class='list-group-item active'>" + text + "</a>";
                first = false;
              } else {
                candidate += "<a class='list-group-item'>" + text + "</a>";
              }
            // }
          });
          // console.info(candidate)
          $("#candidate").empty();
          $("#candidate").append(candidate);
        }
      }

      // create a medicine in the table
      function selectCandidate() {
        var id;
        $("#candidate").children().each(function(){
          if ($(this).attr("class").indexOf("active") > -1) {
            var text = $(this).text();
            var textArr = text.split("-");
            id = textArr[0].trim();
            addMedFromCandidate(id);
            addBindMeds(id);
            $("#codeInput").text("");
            $("#candidate").empty();
            return false;
          }
        });
        // save this med in local
        saveRecentMed(id);
      }

      // add a medicine on the page
      function addMedFromCandidate(id) {
        var medObj = {};
        $.each(CANDIDATE_DATA, function(){
          if (this.id == id) {
            medObj = this;
            return false;
          }
        });
        addMed(medObj);
      }

      function addMedByCode(code) {
        var url = "<?=site_url()?>/mOut/getMedicineByCode/"+code + "/" + getRandom();
        var objArr = [];
        $.get(url, function(data){
          objArr = eval(data);
          $.each(objArr, function(){
            addMed(this);
          });
        });
      }

      function addMed(medObj) {
        // 允许重复药品出现
        // check if already in the table 
        // if ($.inArray(medObj.id, getInsertedMed()) < 0) {
            var node = "<tr name='"+medObj.id+"'>";
            var price = medObj.outPrice;
            if (isNaN(price)) {
              price = "";
            }
            var prefix = "";
            if ("" != price) {
              prefix = "¥";
            }
            node += "<td>"+medObj.name+"</td>";
            node += "<td remark='"+medObj.remark+"' unit='"+medObj.basicUnit+"'>"+createSelect("countPerTime", medObj.countPerTime,medObj.unit,medObj.basicUnit)+"&nbsp<span>"+medObj.basicUnit+getTip(medObj.countPerTime,medObj.remark)+"</span></td>";
            // node += "<td>"+medObj.basicUnit+"</td>";
            node += "<td>"+createSelect("countPerDay", medObj.countPerDay,medObj.unit,medObj.basicUnit)+"</td>";
            // var daysType = createSelect("days", medObj.days,medObj.unit,medObj.basicUnit)
            // node += "<td><input type='text' name='days' style='width:50px' value='"+medObj.days+"' /></td>";
            node += "<td>"+createSelect("days", medObj.days,medObj.unit,medObj.basicUnit)+"</td>";
            var input_days = "";
            if ($.inArray(parseInt(medObj.days), DAYS) < 0) {
              input_days = medObj.days;
            }
            node += "<td><input type='text' name='input-days' style='width:30px' value='"+input_days+"' /></td>";
            node += "<td><span name='medPrice'>"+ prefix + price+"</span></td>";
            node += "<td colspan=1><button class='btn btn-xs btn-block btn-danger' name='delete' medId='"+medObj.id+"'>删除</button></td>";
            node += "</tr>";
            $("#medList").append(node);
            // 合并耗材
            checkHaoCai();
            // 静推加上耗材
            addHaoCai(medObj.name);
            // update duplicate info
            checkDuplicate();
            return parseFloat(price);
        // }
      }

      function getTip(countPerTime, remark) {
        var number = parseFloat(remark);
        if ("" == remark || isNaN(number))
          return "";
        var unit = remark.replace(number, "");
        var result = parseFloat(countPerTime*10)*number/10;
        return "("+result + unit+")";
      }

      // 获取已经添加的Medicine
      function getInsertedMed() {
        var result = [];
        if ($("#medList").children()) {
          $("#medList").children().each(function(){
            result.push($(this).attr("name"));
          });
        }
        return result;
      }

      // create a number select
      function createSelect(type, selected, unit,basicUnit) {
        var begin, end, step = 1;
        if ("age" == type) {
          begin = 1;
          end = 100;
        } else if ("countPerTime" == type) {
          begin = 0.5;
          end = 1000;
          step = 1;
          if ("瓶" == unit||"套" == unit||"人" == unit||"本" == unit||("盒"== unit && "盒"== basicUnit)) {
            step = 1;
            begin = 1;
          }
          if ("人" == unit||"本" == unit||"套" == unit) {
            end = 1;
          }
        } else if ("countPerDay" == type) {
          if ("瓶" == unit||"套" == unit||"人" == unit||"本" == unit||("盒"== unit && "盒"== basicUnit)||("支"== unit && "支"== basicUnit)) {
            var result = "<select name='"+type+"'>";
            result += "<option selected value='0'>0</option>";
            result += "</select>";
            return result;
          }
          begin = 1;
          end = 3;
        } else if ("days" == type) {
          if ("瓶" == unit||"套" == unit||"人" == unit||"本" == unit||("盒"== unit && "盒"== basicUnit)||("支"== unit && "支"== basicUnit)) {
            var result = "<select name='"+type+"'>";
            result += "<option selected value='0'>0</option>";
            result += "</select>";
            return result;
            // return 0;
          }
          // return 1;
          var result = "<select name='"+type+"'>";
          for (var i=0; i < DAYS.length; i++) {
            if (DAYS[i]==selected) {
              result += "<option selected value='"+DAYS[i]+"'>"+DAYS[i]+"</option>";
            } else {
              result += "<option value='"+DAYS[i]+"'>"+DAYS[i]+"</option>";
            }
          }
          result += "</select>";
          return result;
        }
        var result = "<select name='"+type+"'>";
        for (var i=begin; i <= end; i+=step) {
          if (i==selected) {
            result += "<option selected value='"+i+"'>"+i+"</option>";
          } else {
            result += "<option value='"+i+"'>"+i+"</option>";
          }
          if (i == 0.5)
            i = 0;
        }
        result += "</select>";
        return result;
      }

      function Med(id, count, countPerDay, days) {
        this.id = id;
        this.count = count;
        this.countPerDay = countPerDay;
        this.days = days;
      }

      function createRecipel() {
        var medList = [];
        $("#medList").children().each(function(){
          var id = $(this).attr("name");
          var $seletes = $(this).find("select");
          var countPerTime = $seletes.first().find("option:selected").val();
          var countPerDay = $seletes.eq(1).find("option:selected").val();
          var days = $seletes.eq(2).find("option:selected").val();
          var input_days = $(this).find("input[name='input-days']").first().val();
          if (input_days != "") {
            days = input_days;
          }
          // var days = $(this).find("input").first().val();
          var myMed = {"patientId":patientInfo.id, "medId":id, "countPerTime":countPerTime, "countPerDay":countPerDay, "days":days};
          medList.push(myMed);
        });
        submitRecipel(medList);
      }

      function submitRecipel(medList) {
        var patientId = patientInfo.id;
        var age = $("#ageTD select").first().find("option:selected").val();
        var gender;
        var male = document.getElementById("male").checked;
        var female = document.getElementById("female").checked;
        if (true == male) {
          gender = "male";
        } else if (true == female) {
          gender = "female";
        }
        var phone = $("#phone").val();
        // var address = $("#addressTD select").first().find("option:selected").val();
        var address = $("#address").val();
        var totalDiagnosis = $("#totalDiagnosis").val();
        var realname = $("#realname").val();
        var url = "<?=site_url()?>/mOut/updatePatient/";//+patientId+"/"+age+"/"+gender+"/"+phone+"/"+address + "/" + getRandom();
        var patientJson = {"id":patientId,"realname":realname, "age":age,"gender":gender,"phone":phone,"address":address,"diagnosis":totalDiagnosis};
        /*
        1. 更新病人信息
        2. 删除已经存在的用药信息
        3. 写入新的用药信息
        */
        var update = true;
        if(medList.length < 1) {
          update = confirm("没有用药信息录入，如此病人已有用药信息会全部删除，是否继续？");
        }
        if (update) {
          $.post(url, patientJson, function(data){
            if (1 == data.flag) {
              patientInfo.id = data.id;
              patientId = data.id;
              url = "<?=site_url()?>/mOut/delMed/" + patientId + "/" + getRandom();
              $.get(url, function(data){
                if (1 == data) {
                  url = "<?=site_url()?>/mOut/outMed/" + patientId;
                  $.post(url, {"data":JSON.stringify(medList)}, function(priceArray) {
                    updateTotalPrice(priceArray);
                    updateMedprice(priceArray);
                    $("#totalMoney").val(price);
                    // $("#giveMoney").val((parseInt(price/100)+1)*100);
                    $("#giveMoney").focus();
                    // openPrintPage();

                  }, "json");
                } else {
                  alert("删除已经存在的用药信息失败");
                }
              });
            } else {
              alert("更新病人信息失败");
            }
          },"json");
        }
      }

      $("#giveMoney").keyup(function(){
        countReturnMoney();
      });
      $("#giveMoney").focus(function(){
        $(this).val("");
      });

      function updateTotalPrice(priceArray) {
        var price = 0;
        $.each(priceArray, function(){
          price += this;
        });
        $("#totalMoney").val(price);
      }

      function updateMedprice(priceArray) {
        $("span[name=medPrice]").each(function(i){
          $(this).text("¥" + priceArray[i]);
        });
      }

      function openPrintPage() {
        var patientId = patientInfo.id;
        window.open("<?=site_url()?>/mOut/showPrintPage/" + patientId + "/1/false/" + getRandom());
      }
      function countReturnMoney() {
        var returnMoney = $("#giveMoney").val()-$("#totalMoney").val();
        $("#returnMoney").val(returnMoney);
      }

      function getRandom() {
        return Math.ceil(Math.random()*35);
      }

      function addBindMeds(id) {
        // $.each(BIND_DATA, function(){
        //   if (id == this.addMed) {
        //     var url = "<?=site_url()?>/mOut/getMedicineById/"+this.followMed + "/" + getRandom();
        //     $.get(url, function(data){
        //       if ("null" != data) {
        //         var array = eval(data);
        //         addMed(array[0]);
        //       }
        //     });
        //   }
        // });
        var url = "<?=site_url()?>/mOut/getBindMedInfo/"+ id + "/" + getRandom();
        $.get(url, function(data){
          $.each(data, function(){
            addMed(this);
          });
        }, "json");
      }

      function checkDuplicate() {
        var list = [];
        var $rows = $("#medList").children();
        $rows.each(function(){
          var medName = $(this).first().text();
          list.push(medName);
          $(this).first().children().first().css("color", "black");
        });
        for (var i = 0; i < list.length-1; i++) {
          var flag = false;
          for (var j = i+1; j < list.length; j++) {
            if (list[i] == list[j]) {
              $rows.eq(j).children().first().css("color", "red");
              flag = true;
            }
          }
          if (flag)
            $rows.eq(i).children().first().css("color", "red");  
        }
      }
      checkDuplicate();

      // 2个20元 静滴 -> 30元 静滴
      function checkHaoCai() {
        var $rows = $("#medList").children();
        var haocai = "耗材";
        var jingdi = "静滴";
        var oneping = "1瓶";
        var first = null, second = null;
        $rows.each(function(){
          var medName = $(this).first().text();
          if (medName.indexOf(haocai) > -1
            && medName.indexOf(jingdi) > -1
            && medName.indexOf(oneping) > -1) {
              if (first == null) {
                first = this;
              } else {
                second = this;
              }
          }
        });
        if (first != null && second != null) {
          $(first).remove();
          $(second).remove();
          addMedByCode("HCJD2");
        }
      }

      // 静推 加上 耗材
      function addHaoCai(medName) {
        if (medName == "静推0.9NS 20mL") {
          addMedByCode("HCJT");
        }
      }

      // function fixhead() {
      //   $("#medList").parent().css("padding-top", $("#medHead").height());
      // }
      // fixhead();
    });
</script>
  </body>
</html>