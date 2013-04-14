<?php
	//取得表單資料
	$sn = 0000000000;
  	$tw_name = $_POST["tw_name"];
  	$en_name = $_POST["en_name"]; 
  	$country = $_POST["country"]; 
	$category = $_POST["category"];
	switch($_POST["media"])
          {
           case "dvd";
                $media = "DVD";
                break;
           case "vcd";
                $media = "VCD";
          }
  	$rental_fee = $_POST["rental_fee"]; 
  	$rental_period = $_POST["rental_period"]; 
	$extended_fee = $_POST["extended_fee"]; 
	$compensation = $_POST["compensation"];
	$stock = $_POST["stock"];
	//建立資料連接
	$link = mysql_connect("localhost", "3116", "3116");
	if (!$link) die("建立資料連接失敗");
			
	//開啟資料表
	$db_selected = mysql_select_db("3116", $link);
	if (!$db_selected) die("開啟資料庫失敗");
	
	$set_time=date ("Y-m-d");		
	for($j=0 ; $j < $stock ; $j++)
	   {
		$sql = "INSERT INTO video ( sn, set_time, tw_name, en_name, country, category, 
	                            	media, rental_fee, rental_period, extended_fee, compensation) 
				VALUES ( '$sn', '$set_time', '$tw_name', '$en_name', '$country', '$category', 
			         	'$media', '$rental_fee', '$rental_period', '$extended_fee', '$compensation')";
		mysql_query("SET NAMES 'utf8'");
		$result = mysql_query($sql, $link);
		
	   }
	if (!$result) die("執行 SQL 命令失敗");
	
	else
	   {
	    echo "影片新增成功<br>";
		echo "請點選<a href='joinF.html'>這裡</a>返回新增網頁";
	   }
	//關閉資料連接	
	mysql_close($link);
	
?>
