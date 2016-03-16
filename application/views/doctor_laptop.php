<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />    
    <title>医生</title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>asserts/css/bootstrap-switch.min.css" rel="stylesheet">

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
      .control-container{
        position: fixed;
        top:0;
        right:0;
        //background:grey;
      }
      .thead-fixed{
        position: relative;
        /*top:0;
        left:0;*/
        background:rgb(247,245,240);
      }
      table{
        table-layout:fixed;
      }
      thead tr th{text-align:center; vertical-align:middle}
      tbody tr td{text-align:center; vertical-align:middle}
    </style>
  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="col-sm-8 text-center" id="div-table">
          <div id="div-thead"><!--  class="thead-fixed" -->
            <table class="table table-hover table-bordered" >
              <thead id="thead"><tr><th colspan=2>序号</th><th colspan=4>姓名</th><th colspan=2>性别</th><th colspan=2>年龄</th><th colspan=4>电话</th><th colspan=2>处方</th></tr></thead>
              <!--<tbody><tr><td>2</td><td>张三</td><td>男</td><td>45</td><td>12345678901</td></tr></tbody>-->
            </table>
          </div>
          <div id="div-morningTable" <?php if($isAfternoon != 0) echo "class='hide'";?> >
            <table class="table table-bordered">
              <tbody id="tbody">
            </tbody>
          </table>
        </div>
        <div id="div-afternoonTable" <?php if($isAfternoon != 1) echo "class='hide'";?> >
            <table class="table table-bordered">
              <tbody id="tbody2">
            </tbody>
          </table>
        </div>
        </div>
        <div class="col-sm-4 control-container">

          <div class="col-sm-12" id="div-select">
            <div class="col-sm-12" id="div-doctor">
              <?php 
                foreach ($doctors as $doctor){
                  if($doctor['id'] == $doctorId){
                    $doctorName = $doctor["name"];
                    break;
                }
              }?>
              <h1 class="text-center"><strong>医生:</strong><strong id="doctorText"><?=$doctorName?></strong></h1>
              <div class="btn-group btn-group-lg" role="group" id="doctors" name="<?=$doctorId?>">
                <?php foreach ($doctors as $doctor){ ?>
                    <button type="button" class="btn btn-default" name="<?=$doctor['id']?>"><?=$doctor["name"]?></button>
                  <?php }?>
              </div>
            </div>
        </div>

        <!-- <div class="col-sm-6"> -->
        <div class="col-sm-6" id="div-halfDay">
          <h1 class="text-center"><strong>显示</strong><strong id="halfDayText"><?php if($isAfternoon == 0) echo "上午"; else echo "下午"; ?></strong><strong>病人</strong></h1>
          <div class="btn-group btn-group-lg" role="group" id="halfDay" name="<?=$isAfternoon?>">
                <button type="button" class="btn btn-default" name="0">上午</button>
                <button type="button" class="btn btn-default" name="1">下午</button>
            </div>
        </div>
        <!-- </div> -->

        <div class="col-sm-6" id="div-display-count">
          <!-- <div class="col-sm-12"> -->
            <div class="col-sm-12 text-center" id="div-display">
              <?php 
              ?>
              <h1 class="text-center"><strong>显示器:</strong><strong id="displayTxt"><?php if($displayNoon == 0) echo "上午"; else echo "下午"; ?></strong></h1>
              <div  class="btn-group btn-group-lg" role="group" id="displayBtn" name="">
                  <button type="button" class="btn btn-default <?php if($displayNoon == 0) echo "btn-primary"; ?>" name="0">上午</button>
                  <button type="button" class="btn btn-default <?php if($displayNoon == 1) echo "btn-primary"; ?>" name="1">下午</button>
              </div>
            </div>
          <!-- </div> -->
        </div>

        <div class="col-sm-12 text-center" id="div-permit">
          <!-- <h1><strong>挂号控制</strong></h1> -->
          <div class="col-sm-6">
              <div class="col-sm-12" id="div-morning">
                <h1 class="text-center"><strong>上午</strong><strong>&nbsp;剩</strong><strong id="morningCount">0</strong><strong>人</strong></h1>
                <div class="btn-group btn-group-lg" role="group" id="morningForbidden" name="<?=$morningForbidden?>">
                    <button type="button" class="btn btn-default" name="0">允许</button>
                    <button type="button" class="btn btn-default" name="1">停止</button>
                </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="col-sm-12" id="div-afternoon">
              <h1 class="text-center"><strong>下午</strong><strong>&nbsp;剩</strong><strong id="afternoonCount">0</strong><strong>人</strong></h1>
              <div class="btn-group btn-group-lg" role="group" id="afternoonForbidden" name="<?=$afternoonForbidden?>">
                  <button type="button" class="btn btn-default" name="0">允许</button>
                  <button type="button" class="btn btn-default" name="1">停止</button>
              </div>
            </div>
          </div>      
        </div>   

        <div class="col-sm-12" id="div-next">
          <div class="col-sm-12">
            <button type="button" class="btn btn-lg btn-block btn-success" id="nextBtn"><h1><strong>下一位</strong></h1></button>
            <br>
          </div>
          <div class="col-sm-6">
            <button type="button" class="btn btn-lg btn-block btn-warning" id="recallBtn"><h1><strong>重叫</strong></h1></button>
          </div>
          <div class="col-sm-6">
            <button type="button" class="btn btn-lg btn-block btn-warning" id="keepBtn"><h1><strong>保留</strong></h1></button>
          </div>
          <div class="col-sm-6">
          <br>
            <button type="button" class="btn btn-lg btn-block btn-info" id="mOutBtn"><h1><strong>开药方</strong></h1></button>
          </div>
          <div class="col-sm-6">
          <br>
            <a target="_blank" href='<?=site_url()?>/mOut/index' type="button" class="btn btn-lg btn-block btn-info" id="newMOutBtn"><h1><strong>新建药方</strong></h1></a>
          </div>
        </div>  

        </div>
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
    <script>
    $(document).ready(function() {
      //global var
      var SELECTED = -1;
      var MORNING_DATA = <?=$morningData?>;
      var AFTERNOON_DATA = <?=$afternoonData?>;
      var isAfternoon = <?=$isAfternoon?>;
      var REFRESH_TIME = 1000;
      var REFRESH_FLAG = true;
      var morningCurrentId = -1;
      var afternoonCurrentId = -1;
      var moringNoPatientFlag = false;
      var afternoonNoPatientFlag = false;
      var REFRESH_SEEING_FLAG = false;
      var SAVE_NUMBER = -1;
      // var REFRESH_DISPLAY_FLAG = 1;
      var displayNoon = <?=$displayNoon?>;

      $("button").removeAttr("disabled");

      function getTrs(){
        if(isAfternoon == 0){
          return $("#tbody tr");
        }else{
          return $("#tbody2 tr");
        }
      }

      function setCurrentId(id){
        if(isAfternoon == 0){
          morningCurrentId = id;
        }else{
          afternoonCurrentId = id;
        }
      }

      function getCurrentId(){
        if(isAfternoon == 0){
          return morningCurrentId;
        }else{
          return afternoonCurrentId;
        }
      }

      function getNoPatientFlag(){
        if(isAfternoon == 0){
          return moringNoPatientFlag;
        }else{
          return afternoonNoPatientFlag;
        }
      }

      function setNoPatientFlag(flag){
        if(isAfternoon == 0){
          moringNoPatientFlag = flag;
        }else{
          afternoonNoPatientFlag = flag;
        }
      }

      //initial position
      function position(){
        // table font-size
        $("table").css("font-size", $(window).width()*0.014);
        $("h1").css("font-size", $(window).width()*0.015);
        $("h2").css("font-size", $(window).width()*0.018);
        $("button").css("font-size", $(window).width()*0.01);

        $("#morningCount").css("color", "red");
        $("#afternoonCount").css("color", "red");
                
        var HEIGHT = $(window).height();
        var height_select = $("#div-select").height();
        var height_head = $("#div-count").height();
        var height_next = $("#div-next").height();
        var height_perimit = $("#div-permit").height();
        var height_display = $("#displayBtn").height();
        var margin_next = (HEIGHT-height_head-height_next-height_perimit-height_select-height_display)/2-20;
        $("#div-next").css("margin-top",margin_next).css("margin-bottom",margin_next);

        // doctors
        var padding = ($("#div-doctor").width()-$("#doctors").width())/2;
        $("#doctors").css("padding-left",padding);

        // halfDay
        var padding = ($("#div-halfDay").width()-$("#halfDay").width())/2;
        $("#halfDay").css("padding-left",padding);

        
      }
      position();

      //fixed thead
        var thead_top = $("#div-thead").offset().top;
      $(window).scroll(function(event) {
        var scroll = $(window).scrollTop();
        $("#div-thead").css("top", thead_top+scroll);
      });

      function initHelper(group){
        var id = $("#"+group).attr("name");
        $("#"+group+" button[name="+id+"]").addClass("btn-primary");
      }

      function changeSelectHelper(group, btn){
        $("#"+group+" button").removeClass("btn-primary");
        $(btn).addClass("btn-primary");
        $("#"+group).attr("name",$(btn).attr("name"));
      }

      // select halfDay
      function initHalfDay(){
        initHelper("halfDay");
      }
      initHalfDay();

      function selectHalfDay(){
        $("#halfDay button").click(function(){
          // until refresh seeing done can do next
          if(REFRESH_SEEING_FLAG){
            return;
          }
          changeSelectHelper("halfDay",this);
          // change table
          isAfternoon = $("#halfDay").attr("name");
          // console.info("isAfternoon:"+isAfternoon);
          switchTBody();
          showTable();
          imgClick();


          $("#halfDayText").text($(this).text());

          // set recallBtn
          if(-1 == getCurrentId()){
            $("#recallBtn").attr("disabled","disabled");
          }else{
            $("#recallBtn").removeAttr("disabled");
          }

        });
      }
      selectHalfDay();

      // select doctor
      function initDoctor(){
        // initHelper("doctors");
        $("#doctors button[name="+$("#doctors").attr("name")+"]").addClass("btn-primary");
      }
      initDoctor();

      function selectDoctor(){
        $("#doctors button").click(function(){
          // changeSelectHelper("doctors",this);
          $("#doctors button").removeClass("btn-primary");
          $(this).addClass("btn-primary");
          $("#doctors").attr("name",$(this).attr("name"));
          $("#doctorText").text($(this).text());
        });
      }
      selectDoctor();

      // morning control
      function initControl(){
        initHelper("morningForbidden");
        initHelper("afternoonForbidden");
      }
      initControl();

      function selectControl(group, isAfternoon){
        $("#"+group+" button").click(function(){
          changeSelectHelper(group,this);
          var forbidden = $("#"+group).attr("name");
          // send control to DB
          $.get("<?=site_url()?>/guahao/insertControl/"+isAfternoon+"/"+forbidden+"/"+Math.random(), function(data){
              if(data == 1){
                // success control
                console.info("control result:"+data);
              }
          });
        });
      }
      selectControl("morningForbidden", 0);
      selectControl("afternoonForbidden", 1);

      // display control
      function selectDisplay(){
        $("#displayBtn button").click(function(){
          REFRESH_DISPLAY_FLAG = 0;
          // changeSelectHelper("displayBtn",this);
          // $("#displayTxt").text($(this).text());
          // var half = $("#displayBtn").attr("name");
          var half = $(this).attr("name");
          var url = "<?=site_url()?>/guahao/insertDisplay/"+half+"/"+Math.random();
          // console.info(url)
          $.get(url, function(data){
              if(data == 1){
                // success control
                // console.info("selectDisplay result:"+data);
                REFRESH_DISPLAY_FLAG = 1;
                refreshHalf();
              }
          });
        });
      }
      selectDisplay();
            
      //show table
      function switchTBody(){
        if(isAfternoon == 0){
          $("#div-afternoonTable").addClass("hide");
          $("#div-morningTable").removeClass("hide");
        }else{
          $("#div-morningTable").addClass("hide");
          $("#div-afternoonTable").removeClass("hide");
        }
      }
      function showTable(){
        // console.info("---showTable---")
        var data;
        var tbody;
        // console.info("isAfternoon:"+isAfternoon)
        if(isAfternoon == 0){
          data = MORNING_DATA;
          tbody = "#tbody";
        }else{
          data = AFTERNOON_DATA;
          tbody = "#tbody2";
        }
        $(tbody).empty();
        if(data == null || data == "null"){
          return;
        }
        for(var i = 0;i<data.length; i++){
          var gender = "女";
          if(data[i].gender == "male"){
            gender = "男";
          }
          var number = data[i].number;
          // number = number.substring(0,1) + "<br>" + number.substring(1,number.length);
          if(data[i].number.substring(0,1) == 0){
            number = "<span style='color:green;'>保留</span>";
          }
          var phone = data[i].phone;
          // phone = phone.substring(0,phone.length/2) + "<br>" + phone.substring(phone.length/2,phone.length);
          $("<tr name='"+data[i].id+"'><td colspan=2>"+number+"</td><td colspan=4><img height='40px' src='data:"+data[i].name+"' ></td><td colspan=2>"+gender+"</td><td colspan=2>"+data[i].age+"</td><td colspan=4>"+phone+"</td><td colspan=2><button name='"+data[i].id+"' class='btn btn-block btn-info'>查看</button></td></tr>").appendTo(tbody);
        }
      }
      showTable();
      
      // refresh table
      function refreshData(data){
        if(isAfternoon == 0){
          if(MORNING_DATA == null){
            MORNING_DATA = data;
          }else{
            MORNING_DATA = $.merge(MORNING_DATA, data);
          }
        }else{
          if(AFTERNOON_DATA == null){
            AFTERNOON_DATA = data;
          }else{
            AFTERNOON_DATA = $.merge(AFTERNOON_DATA, data);
          }
        }
        // console.info("--end refreshData---")
      }
      function refreshTable(){
        if(isAfternoon == 0){
          tbody = "#tbody";
        }else{
          tbody = "#tbody2";
        }
        var currentId = getTrs().last().attr("name");
        if(currentId == undefined){
          currentId = -1;
        }
        // console.info(currentId)
        $.get("<?=site_url()?>/guahao/getPatientTable/"+currentId+"/"+isAfternoon+"/"+Math.random(), function(data){
          if(data != null){
              // 新增数据合并到DATA
              refreshData(data);
              for(var i = 0;i<data.length; i++){
                // console.info("id:"+data[i].number)
                // console.info("phone:"+data[i].phone)
                  var gender = "女";
                  if(data[i].gender == "male"){
                    gender = "男";
                  }
                  var number = data[i].number;
                  // number = number.substring(0,1) + "<br>" + number.substring(1,number.length);
                  if(data[i].number.substring(0,1) == 0){
                    number = "保留";
                  }
                  var phone = data[i].phone;
                  // phone = phone.substring(0,phone.length/2) + "<br>" + phone.substring(phone.length/2,phone.length);
                  $("<tr name='"+data[i].id+"'><td colspan=2>"+number+"</td><td colspan=4><img height='40px' src='data:"+data[i].name+"' ></td><td colspan=2>"+gender+"</td><td colspan=2>"+data[i].age+"</td><td colspan=4>"+phone+"</td><td colspan=2><button name='"+data[i].id+"' class='btn btn-block btn-info'>查看</button></td></tr>").appendTo(tbody);
                  // let new row can select
                  // selectPatient();
              }
          }
          if(REFRESH_FLAG){
            setTimeout(refreshTable, REFRESH_TIME);
          }
        },
        "json");
      }
      refreshTable();

      // refresh count
      function refreshCount(){
        $.get("<?=site_url()?>/guahao/getPatientCount/"+Math.random(), function(data){
              if(data != null){
                // console.info(data.morningCount)
                $("#morningCount").text(data.morningCount);
                $("#afternoonCount").text(data.afternoonCount);
              }
              setTimeout(refreshCount, REFRESH_TIME);
          },
          "json");
      }
      refreshCount();

      // refresh control
      function refreshControl(){
        $.get("<?=site_url()?>/guahao/getControl/"+Math.random(), function(data){
              if(data != null){
                // console.info(data.morningForbidden)
                var selected = data.morningForbidden;
                changeSelectHelper("morningForbidden", "#morningForbidden button[name="+selected+"]");
                selected = data.afternoonForbidden;
                changeSelectHelper("afternoonForbidden", "#afternoonForbidden button[name="+selected+"]");
              }
              setTimeout(refreshControl, REFRESH_TIME);
          },
          "json");
      }
      refreshControl();

      // refresh pass patient
      function deleteItem(tr){
        
        if(tr.children().first().text() != "保留"){
          tr.css("background-color", "lightgrey");
          tr.css("text-decoration", "line-through");
        }
        tr.removeClass("active").removeClass("info").addClass("pass").css("color","black");
      }
      function highlightItem(tr, doctorId){
        if(doctorId == $("#doctors").attr("name")){
          color = "info";
        }else{
          color = "active";
        }
        $(tr).removeClass("danger").removeClass("active").removeClass("info").addClass(color)
              .css("color","red");
      }
      function seeingTable(trs, patient){
        if(patient == -1){
          return true;
        }
        var flag = false;
        trs.each(function(){
          if($(this).attr("name") == patient){
            flag = true;
          }
        });
        return flag;
      }
      
      function refreshSeeing(){
        var url = "<?=site_url()?>/guahao/getSeeingPatient/"+isAfternoon+"/"+Math.random();
        REFRESH_SEEING_FLAG = true;
        $.get(url, function(data){
              if(data != null){
                var seeingPatients = new Array();
                var maxPatientId = -1;
                for(var i = 0;i<data.length; i++){
                  var patientId = data[i]["patient"];
                  seeingPatients.push(patientId);
                  var doctorId = data[i]["doctor"];
                  // console.info(patientId)
                  if(getNoPatientFlag() == false){
                    highlightItem("tbody tr[name="+patientId+"]", doctorId);
                  }
                  if(patientId > maxPatientId){
                    maxPatientId = patientId;
                  }
                }
                setCurrentId(maxPatientId);
                // console.info(getCurrentId())
                // past patient
                var flag = seeingTable(getTrs(), getCurrentId());
                // console.info("flag->"+flag);
                getTrs().each(function(){
                  // console.info("past patient");
                  var name = $(this).attr("name");
                  // console.info("name:"+name);
                  // console.info(seeingPatients.indexOf(name));
                  if(parseInt(name) < parseInt(getCurrentId()) && seeingPatients.indexOf(name) < 0 && flag){
                    deleteItem($(this));
                  }
                });
                // able nextBtn
                // console.info(parseInt(getTrs().last().attr("name")) > parseInt(getCurrentId()))
                if(parseInt(getTrs().last().attr("name")) > parseInt(getCurrentId())){
                  ableBtn($("#nextBtn"), "下一位");
                  setNoPatientFlag(false);
                }
                else{
                  disableBtn($("#nextBtn"), "没有病人");
                }
              }else if(getTrs().length){
                ableBtn($("#nextBtn"), "下一位");
                setNoPatientFlag(false);
              }
              REFRESH_SEEING_FLAG = false;
              setTimeout(refreshSeeing, REFRESH_TIME);
          },  
          "json");
      }
      refreshSeeing();

      //select next patient
      function selectPatient(){
        $("tbody tr").click(function() {
            // past patients
            if($(this).hasClass("active") || $(this).hasClass("pass") || $(this).hasClass("info")){
              return;
            }
            $("tbody tr").removeClass("danger");
            $(this).addClass("danger");
            SELECTED = $(this).attr("name");
        });
      }
      // selectPatient();

      // call next patient
      $("#nextBtn").click(function(){
        // active recallBtn
        $("#recallBtn").removeAttr("disabled");
        // disabled until all things done
        $(this).attr("disabled","disabled");
        var seeingTableFlag = seeingTable(getTrs(), getCurrentId());
        // get SELECTED
        // console.info("getCurrentId():"+getCurrentId())
        if(getCurrentId() == -1){
          SELECTED = getTrs().first().attr("name");
        }else{
          if(SELECTED <= getCurrentId() && seeingTableFlag){
            getTrs().each(function(){
              var name = $(this).attr("name");
              if(name == getCurrentId() ){
                if(name != getTrs().last().attr("name")){
                  SELECTED = $(this).next().attr("name");
                }else{
                  SELECTED = parseInt(getCurrentId()) + 1;
                }
              }
            });
          }
        }

        // console.info("isAfternoon:"+isAfternoon)
        
        // console.info("SELECTED:"+SELECTED)
        // console.info("getCurrentId():"+getCurrentId())
        // console.info("seeingTableFlag:"+seeingTableFlag)
        if(parseInt(SELECTED) > parseInt(getTrs().last().attr("name")) || getTrs().children().length < 1){
          // no new patient
          // console.info("no new patient");
          setCurrentId(-1);
          //disabled nextBtn
          disableBtn($("#nextBtn"), "没有病人");
          setNoPatientFlag(true);
          getTrs().each(function(){
            if($(this).hasClass("active") || $(this).hasClass("info")){
              deleteItem($(this));
            }
          });
          // set SELECTED == currentId
          SELECTED = getCurrentId();
          $(this).removeAttr("disabled");
        }else if(SELECTED != -1){
          SAVE_NUMBER = SELECTED;
          var url = "<?=site_url()?>/guahao/callNext/"+SELECTED+"/"+$("#doctors").attr("name")+"/"+Math.random();
          // console.info(url);
          $.get(url, function(data){
              if(data != null){
                console.info("callNext result: "+ data);
              }
              $("#nextBtn").removeAttr("disabled");
          },
          "json");
        }
      });
      function disableBtn(btn, text){
        btn.attr("disabled", "disabled");
        // btn.html("<h1><strong>"+text+"</strong></h1>");
        btn.find("h1 strong").text(text);
      } 
      function ableBtn(btn, text){
        btn.removeAttr("disabled");
        //btn.html("<h1><strong>"+text+"</strong></h1>");
        btn.find("h1 strong").text(text);
      }

      // recall patient
      $("#recallBtn").click(function(){
        // console.info(isAfternoon+"|"+getCurrentId());return;
        $(this).attr("disabled","disabled");
        var url = "<?=site_url()?>/guahao/recall/"+$("#doctors").attr("name")+"/"+Math.random();
        $.get(url, function(data){
            if(data > 0){
              console.info("recall result: "+ data);
            }
            $("#recallBtn").removeAttr("disabled");
        },
        "json");
      });

      // keep patient
      $("#keepBtn").click(function(){
        if(SAVE_NUMBER == -1) {
          getTrs().each(function(){
            if($(this).hasClass("info")){
              SAVE_NUMBER = $(this).attr("name");
            }
          });
        }
        console.info(SAVE_NUMBER+"|"+getCurrentId());//return;
        if(SAVE_NUMBER == -1) {
          return;
        }
        $("tbody tr[name="+SAVE_NUMBER+"]").children().first().text("保留").css("color", "green");
        $(this).attr("disabled","disabled");
        var url = "<?=site_url()?>/guahao/keep/"+SAVE_NUMBER+"/"+Math.random();
        $.get(url, function(data){
            if(data > 0){
              console.info("keep result: "+ data);
            }
            $("#keepBtn").removeAttr("disabled");
        },
        "json");
      });

      // cancel keep patient
      function cancelKeep(patientId){
        var url = "<?=site_url()?>/guahao/cancelKeep/"+patientId+"/"+Math.random();
        $.get(url, function(data){
            if(data > 0){
              console.info("cancel keep result: "+ data);
            }
        },    
        "json");
      }
      function imgClick(){
        $("img").bind("click",function(){
          // alert("click")  
          var $xuhao = $(this).parent().parent().children().first();
          if($xuhao.text() == "保留"){
            var truthBeTold = window.confirm("取消保留该病人？"); 
            if (truthBeTold) { 
              var patient = $(this).parent().parent().attr("name");
              cancelKeep(patient);
              $xuhao.text("已看");
            }
          }
        });
      }
      imgClick();

      
      function refreshHalf(){
        $.get("<?=site_url()?>/guahao/getDisplayHalf/"+Math.random(), function(data){
            if(data != null && data != ""){
              // console.info("refreshHalf:" + data)
              displayNoon = data;
              var thisBtn;
              if(displayNoon == 0){
                thisBtn = "#displayBtn Button[name='0']";
              }else{
                thisBtn = "#displayBtn Button[name='1']";
              }
              changeSelectHelper("displayBtn",thisBtn);
              $("#displayTxt").text($(thisBtn).text());
              
          }
          // if(REFRESH_DISPLAY_FLAG == 1){
            displayTimeout = setTimeout(refreshHalf, REFRESH_TIME);
          // }
        });
      }
      refreshHalf();


      function changeHalf(hour){
        var today = new Date();
        if(today.getHours() >= hour){
          if(displayNoon == 0){
            var url = "<?=site_url()?>/guahao/insertDisplay/1/" + Math.random();
            // console.info("url")
            $.get(url, function(data){});
          }
        }else{
          if(displayNoon == 1){
            var url = "<?=site_url()?>/guahao/insertDisplay/0/" + Math.random();
            $.get(url, function(data){});
          }
        }
      }
      changeHalf(14);

      // mOut event
      $("#mOutBtn").on("click", function(){
        window.open("<?=site_url()?>/mOut/index/"+ getCurrentId());
      });

      $(document).on("click", "button", function(){
        if ($(this).text() == "查看") {
          window.open("<?=site_url()?>/mOut/index/"+ $(this).attr("name"));
        }
      })

    });
  </script>
  </body>
</html>