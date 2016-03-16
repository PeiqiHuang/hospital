var SUCCESS_TIP = "<div id='tip' style='display:none'><div class='alert-success navbar-fixed-bottom'  style='padding:5px'><h1 class='text-center'><span class='glyphicon glyphicon-ok' aria-hidden='true'>&nbsp;</span><span id='tip-text'></span></h1></div></div>";
var FAIL_TIP = "<div id='tip' style='display:none'><div class='alert-danger navbar-fixed-bottom'  style='padding:5px'><h1 class='text-center'><span class='glyphicon glyphicon-remove' aria-hidden='true'>&nbsp;</span><span id='tip-text'></span></h1></div></div>";
var INFO_TIP = "<div id='tip' style='display:none'><div class='alert-info navbar-fixed-bottom'  style='padding:5px'><h1 class='text-center'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'>&nbsp;</span><span id='tip-text'></span></h1></div></div>";
$("body").append(INFO_TIP);   

function showTipHelper(text, time) {
    if ("undefined" == typeof(time))
        time = 1000;
    $("#tip-text").text(text);
    $("#tip").fadeIn(time/2);
    $("#tip").fadeOut(time/2+time*3);
}

function showSuccessTip(text, time) {
    $("#tip").remove();
	$("body").append(SUCCESS_TIP);
    showTipHelper(text, time);
}

function showFailTip(text, time) {
    $("#tip").remove();
	$("body").append(FAIL_TIP);
    showTipHelper(text, time);
}

function showInfoTip(text, time) {
    $("#tip").remove();
	$("body").append(INFO_TIP);
    showTipHelper(text, time);
}


function showTip(text, time) {
	if (text.indexOf("成功") > -1)
        showSuccessTip(text, time);
    else if (text.indexOf("失败") > -1)
        showFailTip(text, time);
    else 
        showInfoTip(text, time);
}

