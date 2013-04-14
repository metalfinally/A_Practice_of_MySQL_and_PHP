<?php
	//取得表單資料
	$tw_name = $_POST["tw_name"]; 
  	$rental_fee = $_POST["rental_fee"]; 
  	$rental_period = $_POST["rental_period"]; 
	$extended_fee = $_POST["extended_fee"]; 
	$compensation = $_POST["compensation"];

	//建立資料連接
	$link = mysql_connect("localhost", "3116", "3116");
	if (!$link) die("建立資料連接失敗");
			
	//開啟資料表
	$db_selected = mysql_select_db("3116", $link);
	if (!$db_selected) die("開啟資料庫失敗");
	
	$sql = "SELECT * FROM video WHERE tw_name = '$tw_name'";
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query($sql, $link);
	$num = mysql_num_rows($result);
	if ($num ==0 ) {echo "輸入錯誤的名字" ;}
	else
	   {
	    mysql_free_result($result);
		
		$sql = "UPDATE video SET rental_fee='$rental_fee',rental_period='$rental_period',extended_fee ='$extended_fee'
				,compensation='$compensation' WHERE tw_name = '$tw_name'";
		mysql_query("SET NAMES 'utf8'");
		$result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
	
		else
	   	   {
	    	echo "影片修改成功<br>";
			echo "請點選<a href='alterF.html'>這裡</a>返回修改網頁";
	   	   }
	   }
	//關閉資料連接	
	mysql_close($link);
	
?>
