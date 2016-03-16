<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>显示器 - <?php if($isAfternoon == 0) echo "上午"; else echo "下午";?></title>

    <!-- Bootstrap -->
    <link href="<?=base_url()?>asserts/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    	body {
data:image/png;base64,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    		background-color: rgb(247,245,240);
    		text-align:center;
    	}
    	table{
    		//table-layout:fixed;
    	}
    	thead tr th{
    		font-size: 450%;
    		text-align:center;
    	}
    	tbody tr td{
    		font-size: 350%;
    		text-align:center;
    	}
    	h1 strong{
    		font-size: 300%;
    		text-align:center;
    	}
    	h2 strong{
    		font-size: 180%;
    		text-align:center;
    	}
    	#notify{
    		width:100%;
    		position:fixed;
    		top:0;
    		background-color:rgb(247,245,240);
    		/*filter:alpha(opacity=85); 
			-moz-opacity:0.85; 
			opacity:0.85;*/
    	}
    	#notify img{
    		background-color:rgb(247,245,240);
    		width: 100%;
    		/*height: 100%;*/
    	}
    </style>
  </head>
  <body>
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<!-- <h2><strong>挂号信息</strong></h2> -->
			    <table class="table table-striped table-condensed table-bordered">
			    	<thead id="thead"><tr><th>序号</th><th>姓名</th><th>状态</th><th>人数</th></tr></thead>
			    	<tbody id="tbody">
					</tbody>
				</table>
			</div>
		</div>
	</div>

    <div class='hidden' id="notify">
    	<h1><strong>请</strong><strong id="notify_h1"></strong><strong>号进入诊室就诊</strong></h1>
    	<img id="notify_img" src="">
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>asserts/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>asserts/js/ion.sound.min.js"></script>
<script>
$(document).ready(function(){
// avoid cache
//$.ajaxSetup({cache:false});
//////////// GLOBAL DATA ////////////////
var DATA = <?=$data?>;   

var WIDTH = $(window).width();
var HEIGHT = $(window).height();

var SHOW_TIME = 4000;
var ROWS = <?=$row?>;
var COLUNNS = 4;
var CURRENT_ROW = 1;
var PAGES = 1;
var CURRENT_PAGE = 1;

var CALL_TIME = 1000;
var NOTIFY_TIME = 17000;
var NOTIFY_DATA;
var NOTIFY_INDEX = 0;
var NOTIFY_FLAG = false;

var REFRESH_SHOWDATA_TIME = 1000;

var HALF_TIME = 1000;

var isAfternoon = <?=$isAfternoon?>;

// var NEXT_SOUND;

//////////// END GLOBAL DATA /////////////

function position(){
	// $("thead tr th").css("font-size", $(window).width()*0.018);
	// $("table td").css("height",$(window).height()*0.2);
}
position();

// load sounds
ion.sound({
    sounds: [
    	{name: "上午"},
    	{name: "下午"},
        {name: "0国语"},
        {name: "1国语"},
        {name: "2国语"},
        {name: "3国语"},
        {name: "4国语"},
        {name: "5国语"},
        {name: "6国语"},
        {name: "7国语"},
        {name: "8国语"},
        {name: "9国语"},
        {name: "请国语"},
        {name: "号进入诊室就诊国语"},
        {name: "0粤语"},
        {name: "1粤语"},
        {name: "2粤语"},
        {name: "3粤语"},
        {name: "4粤语"},
        {name: "5粤语"},
        {name: "6粤语"},
        {name: "7粤语"},
        {name: "8粤语"},
        {name: "9粤语"},
        {name: "请粤语"},
        {name: "号进入诊室就诊粤语"},
    ],
    // main config
    path: "<?=base_url()?>asserts/sounds/",
    preload: true,
    multiplay: true,
    volume: 1.0
});

function broadcastSound(sound){
	ion.sound.play(sound);
}

function broadcastSentence(number){
	var numbers = number.split("");
	var baseTime = 600;
	var index = 2;
	if(isAfternoon == 0){
		broadcastSound("上午");
	}else{
		broadcastSound("下午");
	}
	setTimeout(broadcastSound, baseTime*index, "请粤语");
	index +=1;
	for(var i=1;i<numbers.length;i++){
		setTimeout(broadcastSound, baseTime*(index++), (numbers[i])+"粤语");
	}
	setTimeout(broadcastSound, baseTime*index, "号进入诊室就诊粤语");	
	index +=6;
	setTimeout(broadcastSound, baseTime*(index++), "请国语");
	for(var i=1;i<numbers.length;i++){
		setTimeout(broadcastSound, baseTime*(index++), (numbers[i])+"国语");
	}
	setTimeout(broadcastSound, baseTime*index, "号进入诊室就诊国语");
}

function initTbody(){
	for(i=0;i<ROWS;i++){
		var row = "<tr style='width:50'><td></td><td></td><td></td><td></td></tr>";
		$("tbody").append(row);
	}
}
initTbody();

function initNotify(){
	var notify = $("#notify");
	var img = $("#notify_img");
	var h1 = $("#notify_h1");
	notify.height(HEIGHT);
}
initNotify();

function show(){
	if(DATA == null){
		// console.info("DATA == null");
		for(var i = 0; i < ROWS; i++){
			clearRow(i);
		}
		setTimeout(show, SHOW_TIME);
		return;
	}
	var TRS = $("tbody").children();
	var length = DATA.length;
	PAGES = length/ROWS;
	var fragment = false;
	if(length%ROWS!=0){
		PAGES++;
		fragment = true;
	}
	var beginIndex = (CURRENT_PAGE-1)*ROWS;
	var endIndex = beginIndex+ROWS;
	if(endIndex > length){
		endIndex = length;
	}
	//alert(beginIndex+","+endIndex);
	for(var i = beginIndex; i<endIndex; i++){
		var row = i%ROWS;
		var tds = TRS.eq(row).children();

		var id = tds.eq(0);
		id.text(DATA[i].number);
		var name = tds.eq(1);
		name.empty();
		var src = "data:"+DATA[i].name;
		if(WIDTH>=HEIGHT){
			var thead_height = $("#thead").height();
			$("<img class=''></img>").attr("src",src).height((HEIGHT-thead_height)*0.85/ROWS).appendTo(name);
		}else{
			$("<img class=''></img>").attr("src",src).width(WIDTH*0.3).appendTo(name);
		}
		var waitTime = tds.eq(2);
		var waitCount = tds.eq(3);
		waitTime.text(DATA[i].waitTime);
		if(waitTime.text() == "正在就诊"){
			TRS.eq(row).addClass("info");
		}else{
			TRS.eq(row).removeClass("info");
		}
		if(waitTime.text() == "已过号，前来咨询"){
			TRS.eq(row).addClass("warning");
		}else{
			TRS.eq(row).removeClass("warning");
		}
		waitCount.text(DATA[i].waitCount);
	}
	//最后一页，要清空没有数据的行
	if(endIndex == length && fragment){
		for(var i = length%ROWS; i < ROWS; i++){
			clearRow(i);
		}
	}
	CURRENT_PAGE++;
	if(CURRENT_PAGE > PAGES){
		CURRENT_PAGE = 1;
	}
	//loop 直接写方法名，不用"show()"
	setTimeout(show, SHOW_TIME);
}
show();

function refreshShowData(){
	$.get("<?=site_url()?>/guahao/refreshDisplay/"+isAfternoon+"/"+Math.random(), function(data){
        if(data != null){
			DATA = data;
        	// console.info("病人数："+DATA.length);
        }else{
        	DATA = null;
        	// console.info("没有病人");
        }
        if(!NOTIFY_FLAG){
	        setTimeout(refreshShowData, REFRESH_SHOWDATA_TIME);
        }
    },
    "json");
}
refreshShowData();

function clearRow(i){
	var TRS = $("tbody").children();
	var tds = TRS.eq(i).children();
	for(var j = 0; j<COLUNNS; j++){
		var td = tds.eq(j);
		td.text("");
	}
}

//////////////////////// 医生叫人，弹出名字 ////////////////////////
function notifyOne(data){
	var img = $("#notify_img");
	var title = $("#notify_h1");
	if(data!=null){
		img.attr("src","data:"+data.name);
	}else{
		return;
	}
	// only show will have height and width != 0
	$("#notify").removeClass("hidden");
	var padding = (HEIGHT-img.height()-title.height())/2;
	img.css("padding-top",padding);
	title.text(data.number);
	// broacast sound
	broadcastSentence(data.number);
	// show img
	//setTimeout(cancellNotify, NOTIFY_TIME);
}

function cancellNotify(){
	$("#notify").addClass("hidden");
	NOTIFY_FLAG = false;
	// restart loop method affected by notify
	callLoop();
	refreshShowData();
}

function notify(){
	// console.info("正在call的index："+NOTIFY_INDEX);
	notifyOne(NOTIFY_DATA[NOTIFY_INDEX]);
	NOTIFY_INDEX++;
	if(NOTIFY_INDEX<NOTIFY_DATA.length){
		setTimeout(notify, NOTIFY_TIME);
	}else{
		// console.info("cancellNotify");
		setTimeout(cancellNotify, NOTIFY_TIME);
	}
}

function callLoop(){
	$.get("<?=site_url()?>/guahao/call/"+Math.random(), function(data){
        if(data != null){
			//console.info(data);
        	// console.info("需要call的人数："+data.length);
        	NOTIFY_DATA = data;
        	NOTIFY_INDEX = 0;
        	NOTIFY_FLAG = true;
        	notify();
        }
	    if(!NOTIFY_FLAG){
		  	setTimeout(callLoop, CALL_TIME);
	    }
    },
    "json");
}
callLoop();

function refreshHalf(){
	$.get("<?=site_url()?>/guahao/getDisplayHalf/"+Math.random(), function(data){
	    if(data != null && data != ""){
			// console.info(data)
	    	isAfternoon = data;
	    	if(isAfternoon == 0){
	    		$("title").text("显示器 - 上午");
	    	}else{
	    		$("title").text("显示器 - 下午");
	    	}
	    	
		}
		setTimeout(refreshHalf, HALF_TIME);
	});
}
refreshHalf();



//////////////////////// END 医生叫人，弹出名字 ////////////////////////


});
</script>
     
  </body>
</html>