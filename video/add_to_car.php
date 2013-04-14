<?php
	//檢查 cookie 中的 passed 變數是否等於 TRUE
	$passed = $_COOKIE["passed"];
	
	/*如果 cookie 中的 passed 變數不等於 TRUE
		表示尚未登入網站，將使用者導向首頁 index.htm*/
	if ($passed != "TRUE")
	{
		header("location:index.htm");
		exit();
	}
	
	//取得表單資料
	$video_sn = $_POST["video_sn"];
	
	//建立資料連接
	$link = mysql_connect("localhost", "3116", "3116");
	if (!$link) die("建立資料連接失敗");
			
	//開啟資料表
	$db_selected = mysql_select_db("3116", $link);
	if (!$db_selected) die("開啟資料庫失敗");
	
	//檢查影片編號是否正確
	$sql = "SELECT * FROM video Where sn = '$video_sn'";
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query($sql, $link);
	if (!$result) die("執行 SQL 命令失敗");
	
	//假如輸入的影片編號沒在資料庫內
	if (mysql_num_rows($result) == 0){
		
		//釋放 $result 佔用的記憶體
		mysql_free_result($result);
		
		//關閉資料連接
		mysql_close($link);
		
		//顯示訊息要求使用者輸入正確的帳號密碼
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('資料庫查不到輸入的影片編號，請重新輸入');";
		echo "history.back();";
		echo "</SCRIPT>";
	}
	
	//如果購物車內沒有任何項目，直接加入產品資料
	if(empty($_COOKIE["video_sn_list"])){
		
		setcookie("video_sn_list",mysql_result($result, 0, "sn"));
		setcookie("video_name_list",mysql_result($result, 0, "tw_name"));
		setcookie("video_media_list",mysql_result($result, 0, "media"));
		setcookie("video_rental_fee_list",mysql_result($result, 0, "rental_fee"));
		setcookie("video_rental_period_list",mysql_result($result, 0, "rental_period"));
		setcookie("video_extended_fee_list",mysql_result($result, 0, "extended_fee"));
		setcookie("video_compensation_list",mysql_result($result, 0, "compensation"));
		
		//將網站重新導向到shopping_car.php
		header("Location: shopping_car.php");
	}
	
	//取得購物車資料
	$video_sn_array=explode(",",$_COOKIE["video_sn_list"]);
	$video_name_array=explode(",",$_COOKIE["video_name_list"]);
	$video_media_array=explode(",",$_COOKIE["video_media_list"]);
	$video_rental_fee_array=explode(",",$_COOKIE["video_rental_fee_list"]);
	$video_rental_period_array=explode(",",$_COOKIE["video_rental_period_list"]);
	$video_extended_fee_array=explode(",",$_COOKIE["video_extended_fee_list"]);
	$video_compensation_array=explode(",",$_COOKIE["video_compensation_list"]);
	
	//判斷選擇的物品是否在購物車內
	if(in_array($video_sn,$video_sn_array)){
		//如果選擇的產品已經在購物車內，則導回購物車頁面
		//釋放 $result 佔用的記憶體	
		mysql_free_result($result);
		
		//關閉資料連接
		mysql_close($link);
		
		//將網站重新導向購物車
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('物品已存在購物車裡');";
		echo "history.back();";
		echo "</SCRIPT>";
	}
		
		//取得所需的資料
		$video_sn_array[] = mysql_result($result, 0, "sn");
		$video_name_array[] = mysql_result($result, 0, "tw_name");
		$video_media_array[] = mysql_result($result, 0, "media");
		$video_rental_fee_array[] = mysql_result($result, 0, "rental_fee");
		$video_rental_period_array[] = mysql_result($result, 0, "rental_period");
		$video_extended_fee_array[] = mysql_result($result, 0, "extended_fee");
		$video_compensation_array[] = mysql_result($result, 0, "compensation");
		
		//儲存購物車資料
		setcookie("video_sn_list",implode(",",$video_sn_array));
		setcookie("video_name_list",implode(",",$video_name_array));
		setcookie("video_media_list",implode(",",$video_media_array));
		setcookie("video_rental_fee_list",implode(",",$video_rental_fee_array));
		setcookie("video_rental_period_list",implode(",",$video_rental_period_array));
		setcookie("video_extended_fee_list",implode(",",$video_extended_fee_array));
		setcookie("video_compensation_list",implode(",",$video_compensation_array));
	
	
	//釋放 $result 佔用的記憶體	
	mysql_free_result($result);
	
	//關閉資料連接
	mysql_close($link);
	
	//將網站重新導向到shopping_car.php
	header("Location: shopping_car.php");
?>