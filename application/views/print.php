<html>
    <head>
        <title>打印页面-<?=$page?></title>
        <style>
        	body {font-family:"宋体"; font-size:14px;}
        	table{font-size:14px;}
            #title{position:absolute;top:2.4cm;left:9cm;font-size:15px;}
            #name{position:absolute;top:3.1cm;left:6.2cm;}
            #truename{position:absolute;top:3.2cm;left:7cm;}
            #gender{position:absolute;top:3.2cm;left:10.6cm;}
            #age{position:absolute;top:3.2cm;left:13.2cm;}
            #address{position:absolute;top:4cm;left:7cm;}
            #phone{position:absolute;top:4cm;left:12.6cm;}
            #diagnosis{position:absolute;top:4.8cm;left:7cm;}
            #year{position:absolute;top:4.8cm;left:11.3cm;}
            #month{position:absolute;top:4.8cm;left:12.8cm;}
            #day{position:absolute;top:4.8cm;left:13.6cm;}
            /*table{position:fixed;top:7cm;}*/
            #table-div{position:absolute;top:6.2cm;left:5.4cm;width:10.1cm}
            #zhenjin{position:absolute;top:17.4cm;left:6.2cm;font-size:13px;}
            #bingliben{position:absolute;top:17.4cm;left:10.6cm;font-size:13px;}
            #bingliben_head{position:absolute;top:16.5cm;left:10.3cm;font-size:13px;}
            #treat{position:absolute;top:17.4cm;left:9.5cm;font-size:13px;}
            #total{position:absolute;top:17.4cm;left:13cm;font-size:13px;}
        </style>
    </head>
    <body>
        <span id="title">东莞东坑谢永年卫生所</span>
        <?php 
        if ("" != $patientInfo['realname'])
            echo "<span id='truename'>".$patientInfo['realname']."</span>";
        else if ("" != $patientInfo['name'])
            echo "<span id='name'><img src='data:".$patientInfo['name']."' style='width:100px' /></span>";
        ?>
        
        <span id="gender"><?php echo ($patientInfo["gender"] == "male" ? "男" : "女");?></span>
        <span id="age"><?=$patientInfo["age"]?></span>
        <span id="address"><?=$patientInfo["address"]?></span>
        <span id="phone"><?=$patientInfo["phone"]?></span>
        <span id="diagnosis"><?=$patientInfo["diagnosis"]?></span>
        <span id="year"><?=date("Y")?></span>
        <span id="month"><?=date("m")?></span>
        <span id="day"><?=date("d")?></span>
        <div id="table-div"><table cellpadding="8px" style="width:100%">
        <?php 
        $totalPrice = 0;
        $treatPrice = 0;
        $zhenjin = "";
        $bingliben = "";
        $bingliben_head = "";
        $showCount = 0;
        $count = 0;
        $nextPage = false;
        $pageCount = 9;
        $kuohao = false;
        if (null != $medInfo) {
            for ($i=0;$i<count($medInfo);$i++) {
                $name  = $medInfo[$i]["name"];
                $price = $medInfo[$i]["price"];
                if (strpos($name,"耗材")===0 || strpos($name,"检查费")===0) 
                    $treatPrice += $price;
                if ($name == "诊金") 
                    $zhenjin = $price;
                if ($name == "病历本") {
                    $bingliben = $price;
                    $bingliben_head = "病历本";
                }
                $totalPrice += $price;
            }
            for ($i=0;$i<count($medInfo);$i++) {
                $name  = $medInfo[$i]["name"];
                $price = $medInfo[$i]["price"];
                $contain = $medInfo[$i]["contain"];
                $count++;
                if ($name == "诊金" || $name == "病历本" || strpos($name,"耗材")=== 0 || strpos($name,"检查费")=== 0) {
                    //echo "<tr><td>$name</td><td></td><td></td>"; 
                    // echo "<td  style='text-align:right'>$price</td></tr>";
                    // if (strpos($name,"耗材")===0 || strpos($name,"检查费")===0) $treatPrice += $price;
                    continue;
                } else {
                    $showCount++;
                }
                if ($showCount > $page*$pageCount) {
                    $page++;
                    // if (count($medInfo) >= $showCount) {
                        $nextPage = true;
                    // }
                    break;
                }
                $begin = ($page-1)*$pageCount+($count-$showCount);
                if ($page == 1) $begin = 0;
                if ($count <= $begin) {
                    continue;
                }
                // countPerDay
                $t = $medInfo[$i]["countPerDay"];
                if ($t == 1) $countPerDay = "qd";
                else if ($t == 2) $countPerDay = "bid";
                else if ($t == 3) $countPerDay = "tid";
                else $countPerDay = "-";//$t."次/天";
                // countPerTime
                $countPerTime = $medInfo[$i]["countPerTime"];
                // unit
                $basicUnit = $medInfo[$i]["basicUnit"];
                $unit = $medInfo[$i]["unit"];
                $remark = $medInfo[$i]["remark"];
                if (preg_match('/[0-9,.]+/',$remark,$arr)) {
                    $number = $arr[0];
                    $left = str_replace($number, "", $remark);
                    $number = $number*$countPerTime;
                    $basicUnit .= "($number$left)";
                    $kuohao = true;
                }
                $days = $medInfo[$i]['days'];
                if ($unit == "盒" && $medInfo[$i]["basicUnit"] != "盒") {
                    $count = ceil($countPerTime*$t*$days/$contain);
                    if ($kuohao == true && strlen($name) > 30) $basicUnit .= "<br>";
                    $basicUnit .= "(共".$count."盒)";
                    $basicUnit .= ($medInfo[$i]["basicUnit"] == "盒");
                }
                $countPerTime .= $basicUnit;
                if ($countPerDay == "-")
                    $thirdCol = "-";
                else
                    $thirdCol = $countPerDay." x ".$days;
                // 换行
                if (strlen($name) < 15 && (strpos($name, "(") > 0 || strpos($name, "（") > 0)) { //strlen($name) > 30 &&   
                    $name = str_replace("(", "<br>(", $name);
                    $name = str_replace("（", "<br>（", $name);
                }
                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td>$countPerTime</td>";
                echo "<td>".$thirdCol."</td>";
                if ("true" == $showPrice) echo "<td style='text-align:right'>$price</td>";
                echo "</tr>";
            }
        }
        ?>
            <tr>
                <td></td>
                <td></td>
               <!--  <td></td> -->
                <!-- <td>总价：￥<?=$totalPrice?></td> -->
            </tr>
        </table>
    </div>
        <span id="zhenjin"><?=$zhenjin?></span>
        <span id="bingliben_head"><?=$bingliben_head?></span>
        <span id="bingliben"><?=$bingliben?></span>
        <span id="treat"><?=$treatPrice?></span>
        <span id="total"><?=$totalPrice?></span>
    <script src="<?=base_url()?>asserts/bootstrap/js/jquery.min.js"></script>        
    <!-- print -->
    <script type="text/javascript" src="<?=base_url()?>asserts/print/jquery.printPage.js"></script>        
    <script type="text/javascript">
        function getRandom() {
          return Math.ceil(Math.random()*35);
        }
    </script>
    <?php
    if (true === $nextPage) {
        echo "<script>";
        echo "window.open('".site_url()."/mOut/showPrintPage/".$patientId."/".$page."/false/' + getRandom());";
        echo "</script>";
    } 
    ?>
    </body>
</html>