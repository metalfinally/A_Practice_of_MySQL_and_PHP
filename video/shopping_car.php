<?php
	//檢查 cookie 中的 passed 變數是否等於 TRUE
	$passed = $_COOKIE["passed"];
	
	/*如果 cookie 中的 passed 變數不等於 TRUE
		表示尚未登入網站，將使用者導向首頁 index.htm*/
	if ($passed != "TRUE")
	{
		header("Location:index.htm");
	}
?>
<HTML>
  <HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>影片出租系統-主頁</TITLE>
  </HEAD>
  <BODY BGCOLOR="LightYellow">
    	<P ALIGN="center">影片出租清單</P>
		<TABLE BORDER="0" ALIGN="center" WIDTH="800">
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
			//如果購物車是空的，則顯示 "目前購物車內沒有任何商品及數量" 的訊息
			if (empty($_COOKIE["video_sn_list"])){
				echo "<TR ALIGN='center'>";
				echo "<TD COLSPAN='6'>目前購物車內沒有任何商品及數量！</TD>";	
				echo "</TR>";	
			}else{
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
					$total += $video_rental_fee_array[$i];
					
					//顯示各欄位資料
					echo "<FORM METHOD='post' ACTION='change.php?video_sn=".$video_sn_array[$i]."'>";
					echo "<TR BGCOLOR='#EDEAB1'>";
					echo "<TD ALIGN='center'>" . $video_sn_array[$i] . "</TD>";
					echo "<TD ALIGN='center'>" . $video_name_array[$i] . "</TD>";
					echo "<TD ALIGN='center'>" . $video_media_array[$i] . "</TD>";
					echo "<TD ALIGN='center'>$" . $video_rental_fee_array[$i] . "</TD>";
					echo "<TD ALIGN='center'>".$video_rental_period_array[$i]."夜</TD>";
					echo "<TD ALIGN='center'>$" . $video_extended_fee_array[$i] . "/天</TD>";
					echo "<TD ALIGN='center'>$" . $video_compensation_array[$i] . "</TD>";
					echo "<TD ALIGN='center'><INPUT TYPE='submit' VALUE='刪除'></TD>";
					echo "</TR>";
					echo "</FORM>";
					
				}
				
				echo "<TR ALIGN='right' BGCOLOR='#EDEAB1'>";
				echo "<TD COLSPAN='6'>總金額 = " . $total . "</TD>";
				echo "</TR>";
		}
		echo "<TR>";
		echo "<FORM METHOD='post' ACTION='add_to_car.php'>";
		echo "<TD ALIGN='right'><INPUT TYPE='text' NAME='video_sn' SIZE='10'></TD>";
		echo "<TD ALIGN='left'><INPUT TYPE='submit' VALUE='增加'></TD>";
		echo "</FORM>";
		
		echo "<TD COLSPAN='6'>" . "<INPUT TYPE='button' VALUE='退回所有商品'
							onClick=\"javascript:window.open('delete_order.php','_self')\">";
		echo "</TD>";	
		echo "</TR>";
		
		echo "<TR ALIGN='center'>";
		echo "<FORM METHOD='post' ACTION='order.php'>";
		echo "<TD ALIGN='center'><INPUT TYPE='submit' VALUE='進入交易步驟'></TD>";
		echo "</FORM>";
		echo "</TR>";
		?>
		</TABLE>
  </BODY>
</HTML>