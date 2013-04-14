<?php
	//取得使用者id
	$id = $_COOKIE["id"];
	
	//取得購物車資料
	$video_sn_array=explode(",",$_COOKIE["video_sn_list"]);
	$video_rental_fee_array=explode(",",$_COOKIE["video_rental_fee_list"]);
	
	if (empty($_COOKIE["video_sn_list"])){
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('沒有買東西不需要結帳！');";
		echo "history.back();";
		echo "</SCRIPT>";
	}else if(count($video_sn_array)>7){
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('數量超過6個！');";
		echo "history.back();";
		echo "</SCRIPT>";
	}else{
		
		//建立資料連接
		$link = mysql_connect("localhost", "3116", "3116");
		if (!$link) die("建立資料連接失敗");
		
		//開啟資料表
		$db_selected = mysql_select_db("3116", $link);
		if (!$db_selected) die("開啟資料庫失敗");
		
		$s_day=date ("Y-m-d");
		
		//執行 SQL 命令，新增此上層購物紀錄
		$sql = "INSERT INTO upper_order ( set_time, id, total_price, amount ) 
				VALUES ( '$s_day', '$id', '0', '0')";
		
		$result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
		
		//取得購物編號
		$sql = "SELECT * FROM upper_order Where id = '$id' ORDER BY uo_sn DESC";
		$result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
		
		$uo_sn = mysql_result($result, 0, "uo_sn");
		mysql_free_result($result);
		
		//把購物車內容加入訂單		
		for ($i = 1; $i < count($video_sn_array); $i++){
			//計算總計
			$total += $video_rental_fee_array[$i];
			
			$sql = "INSERT INTO sub_order ( uo_sn, sn, bar_check ) 
				VALUES ( '$uo_sn', '$video_sn_array[$i]', '0')";
			//bar_check代表出租狀態，0是出租中，1是已還片，2是延期，3是損毀
			$result = mysql_query($sql, $link);
			if (!$result) die("執行 SQL 命令失敗");
		}
		
		//更新upper_order
		$i=$i-1;
		$sql = "UPDATE upper_order SET total_price = '$total',
				amount = '$i' WHERE uo_sn ='$uo_sn'";
		$result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
		
		//釋放 $result 佔用的記憶體	
		mysql_free_result($result);
		
		//關閉資料連接
		mysql_close($link);
	}
?>
<HTML>
	<HEAD>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
		<TITLE>交易完成</TITLE>
	</HEAD>
	<BODY BGCOLOR="#FFFFFF">      
		<TABLE BORDER="0" ALIGN="center" WIDTH="800">
		<TR HEIGHT="25">
				<TD COLSPAN="4" ALIGN="Center" BGCOLOR="#CCCC00">交易資料</TD>
		</TR>
		<TR BGCOLOR="#ACACFF" HEIGHT="30" ALIGN="center">
			<TD>影片編號</TD>
			<TD>片名</TD>
			<TD>媒體形式</TD>
			<TD>租金</TD>
			<TD>租期</TD>
			<TD>預期費</TD>
			<TD>賠償金</TD>
		</TR>
		<?php
				//取得購物車資料
				$video_sn_array=explode(",",$_COOKIE["video_sn_list"]);
				$video_name_array=explode(",",$_COOKIE["video_name_list"]);
				$video_media_array=explode(",",$_COOKIE["video_media_list"]);
				$video_rental_fee_array=explode(",",$_COOKIE["video_rental_fee_list"]);
				$video_rental_period_array=explode(",",$_COOKIE["video_rental_period_list"]);
				$video_extended_fee_array=explode(",",$_COOKIE["video_extended_fee_list"]);
				$video_compensation_array=explode(",",$_COOKIE["video_compensation_list"]);
				
				//顯示購物車內容		
				for ($i = 1; $i < count($video_sn_array); $i++){
					//計算總計
					$total_1 += $video_rental_fee_array[$i];
					
					//顯示各欄位資料
					echo "<TR>";
					echo "<TD ALIGN='center'>" . $video_sn_array[$i] . "</TD>";
					echo "<TD ALIGN='center'>" . $video_name_array[$i] . "</TD>";
					echo "<TD ALIGN='center'>" . $video_media_array[$i] . "</TD>";
					echo "<TD ALIGN='center'>$" . $video_rental_fee_array[$i] . "</TD>";
					echo "<TD ALIGN='center'>". $video_rental_period_array[$i] ."夜</TD>";
					echo "<TD ALIGN='center'>$" . $video_extended_fee_array[$i] . "/天</TD>";
					echo "<TD ALIGN='center'>$" . $video_compensation_array[$i] . "</TD>";
					echo "</TR>";
				}
				echo "<TR ALIGN='right' BGCOLOR='#EDEAB1'>";
				echo "<TD COLSPAN='4'>總金額 = " . $total_1 . "</TD>";
				echo "</TR>";
		?>
		</TABLE>
			<P ALIGN="center"><A HREF="clear_cookie.php">處理另一個訂單</A></P>
	</BODY>
</HTML>