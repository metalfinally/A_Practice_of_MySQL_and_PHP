<?php
	//取得表單資料
  	$uo_sn = $_POST["uo_sn"];
	$A = array();
	$B = array();
	$C = array(租借中,歸還,延期歸還,損毀 );

	//建立資料連接
	$link = mysql_connect("localhost", "3116", "3116");
	if (!$link) die("建立資料連接失敗");
	
	//開啟資料表
	$db_selected = mysql_select_db("3116", $link);
	if (!$db_selected) die("開啟資料庫失敗");
	
	//檢查訂單編號是否正確
	$sql = "SELECT * FROM upper_order WHERE uo_sn = '$uo_sn'";
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query($sql, $link);
	if (!$result) die("執行 SQL 命令失敗");
	
	//如果訂單編號錯誤
	if (mysql_num_rows($result) == 0)
	{
	  //釋放 $result 佔用的記憶體
		mysql_free_result($result);
		
		//關閉資料連接
		mysql_close($link);
		
		//顯示訊息要求使用者輸入正確的帳號密碼
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('訂單資料庫查不到這組編號，請重新輸入');";
		echo "history.back();";
		echo "</SCRIPT>";
	}
	//如果訂單編號正確
	else
	{
		$sql = "SELECT uo_sn AS '訂單編號', sn AS '出租影片', bar_check AS '出租狀態' FROM sub_order WHERE uo_sn = '$uo_sn'";
		mysql_query("SET NAMES 'utf8'");
	    $result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
		$temp = mysql_num_rows($result);
		$num = $temp ; 
		for($i=0 ; $i<$num ; $i++)
		   {
		    $A[$i] =  mysql_result($result , $i , 1) ;
		   }
		mysql_free_result($result);
		for($i=0 ; $i<$num ; $i++)
		   {
			$sql = "SELECT tw_name FROM video WHERE sn = '$A[$i]'";
			mysql_query("SET NAMES 'utf8'");
	    	$result = mysql_query($sql, $link);
			$B[$i] = mysql_result($result , 0 , 0) ;
			mysql_free_result($result);
			}		
		$sql = "SELECT uo_sn AS '訂單編號', sn AS '出租影片', bar_check AS '出租狀態' FROM sub_order WHERE uo_sn = '$uo_sn'";
		mysql_query("SET NAMES 'utf8'");
	    $result = mysql_query($sql, $link);
		echo "<TABLE BORDER = '1' ALIGN = 'CENTER'><TR ALIGN = 'CENTER'>";
		for($i=0;$i<mysql_num_fields($result);$i++)
           {
            $meta=mysql_fetch_field($result,$i);
            echo "<TD>".$meta->name."</TD>";
           }
		echo "</TR>";
		for($j=0 ; $j<mysql_num_rows($result) ; $j++)
	   	   {
	       	echo "<TR>";
		  	for($k=0 ; $k<mysql_num_fields($result) ; $k++)
		       {
			   	if($k == 1)
				  {
				    echo "<TD>".$B[$j]."</TD>";
					$k = $k+1 ;
				  }
				if($k == 2)
				  {
				    $l = mysql_result($result , $j, 2);
				    echo "<TD>".$C[$l]."</TD>";
					break;
				  }
			    echo "<TD>".mysql_result($result , $j, $k)."</TD>";
			   }
		  	echo "</TR>";			    
	   	   }
		echo "</TABLE>";
		mysql_free_result($result);
		mysql_close($link);

		
	}
?>
		