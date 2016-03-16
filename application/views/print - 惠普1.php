<html>
    <head>
        <title>打印页面</title>
        <style>
        	body {font-family:"宋体"; font-size:13px;}
        	table{font-size:13px;}
            #title{position:absolute;top:2.5cm;left:4cm;}
            #name{position:absolute;top:3.2cm;left:1.2cm;}
            #gender{position:absolute;top:3.3cm;left:5.3cm;}
            #age{position:absolute;top:3.3cm;left:8cm;}
            #address{position:absolute;top:4.1cm;left:1.5cm;}
            #phone{position:absolute;top:4.1cm;left:7.6cm;}
            #diagnosis{position:absolute;top:4.9cm;left:1.5cm;}
            #year{position:absolute;top:4.9cm;left:6.3cm;}
            #month{position:absolute;top:4.9cm;left:7.6cm;}
            #day{position:absolute;top:4.9cm;left:8.5cm;}
            table{position:absolute;top:6.6cm;left:0cm;}
            #zhenjin{position:absolute;top:17.2cm;left:1.1cm;}
            #bingliben{position:absolute;top:17.2cm;left:5.9cm;}
            #bingliben_head{position:absolute;top:16.5cm;left:5.35cm;}
            #total{position:absolute;top:17.2cm;left:8.4cm;}
        </style>
    </head>
    <body>
        <span id="title">东莞东坑谢永年卫生所</span>
        <?php 
        if ("" != $patientInfo['realname'])
            echo "<span id='name'>".$patientInfo['realname']."</span>";
        else
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
        <table cellpadding="4px" style="width:100%">
        <?php 
        $totalPrice = 0;
        $zhenjin = "";
        $bingliben = "";
        $bingliben_head = "";
        if (null != $medInfo) {
            for ($i=0;$i<count($medInfo);$i++) {
                $name  = $medInfo[$i]["name"];
                $price = $medInfo[$i]["price"];
                $contain = $medInfo[$i]["contain"];
                $totalPrice += $price;
                if ($name == "诊金" || $name == "病历本") {
                    //echo "<tr><td>$name</td><td></td><td></td>"; 
                    // echo "<td  style='text-align:right'>$price</td></tr>";
                    if ($name == "诊金") $zhenjin = $price;
                	if ($name == "病历本") {
                		$bingliben = $price;
                		$bingliben_head = "病历本";
                	}
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
                $badicUnit = $medInfo[$i]["basicUnit"];
                $unit = $medInfo[$i]["unit"];
                $remark = $medInfo[$i]["remark"];
                if (preg_match('/[0-9,.]+/',$remark,$arr)) {
                    $number = $arr[0];
                    $left = str_replace($number, "", $remark);
                    $number = $number*$countPerTime;
                    $badicUnit .= "($number$left)";
                }
                $days = $medInfo[$i]['days'];
                if ($unit == "盒") {
                    $count = ceil($countPerTime*$t*$days/$contain);
                    $badicUnit .= "(共".$count."盒)";
                }
                if ($countPerDay == "-")
                    $thirdCol = "-";
                else
                    $thirdCol = $countPerDay." x ".$days;
                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td>$countPerTime$badicUnit</td>";
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
        <span id="zhenjin"><?=$zhenjin?></span>
        <span id="bingliben_head"><?=$bingliben_head?></span>
        <span id="bingliben"><?=$bingliben?></span>
        <span id="total"><?=$totalPrice?></span>
    </body>
</html>