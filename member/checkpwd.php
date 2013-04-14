<?php
	//取得表單資料
  $account = $_POST["account"]; 	
  $password = $_POST["password"];

	//建立資料連接
	$link = mysql_connect("localhost", "3116", "3116");
	if (!$link) die("建立資料連接失敗");
			
	//開啟資料表
	$db_selected = mysql_select_db("3116", $link);
	if (!$db_selected) die("開啟資料庫失敗");
			
	//檢查帳號密碼是否正確
	$sql = "SELECT * FROM users Where account = '$account' AND password = '$password'";
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query($sql, $link);
	if (!$result) die("執行 SQL 命令失敗");

	//如果帳號密碼錯誤
	if (mysql_num_rows($result) == 0)
	{
	  //釋放 $result 佔用的記憶體
		mysql_free_result($result);
	
		//關閉資料連接	
		mysql_close($link);		
		
		//顯示訊息要求使用者輸入正確的帳號密碼
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('帳號密碼錯誤，請查明後再登入');";
		echo "history.back();";
		echo "</SCRIPT>";
	}
	
	//如果帳號密碼正確
	else
	{
		//取得 id 欄位
		$id = mysql_result($result, 0, "id");
	
	  	//釋放 $result 佔用的記憶體	
		mysql_free_result($result);
		
		//關閉資料連接	
		mysql_close($link);				

		//將使用者資料加入 cookies
		setcookie("id", $id);
		setcookie("passed", "TRUE");
		
		//將網站重新導向到main.php		
		header("Location: main.php");
		
	}
?>