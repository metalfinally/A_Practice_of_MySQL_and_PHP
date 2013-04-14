<?php
   $sn = $_POST["sn"]; 
   //建立資料連接
   $link = mysql_connect("localhost", "3116", "3116");
   if (!$link) die("建立資料連接失敗");
			
   //開啟資料表
   $db_selected = mysql_select_db("3116", $link);
   if (!$db_selected) die("開啟資料庫失敗");
   
   $sql = "UPDATE sub_order SET bar_check='1' WHERE id='$sn'";
   mysql_query("SET NAMES 'utf8'");
   $result = mysql_query($sql, $link);
   if (!$result) die("執行 SQL 命令失敗");
   else
	  {
	    echo "影片歸還成功<br>";
		echo "請點選<a href='return.html'>這裡</a>返回歸還網頁";
	  }
   mysql_free_result($result);                               
   mysql_close($link);                                              

?>

