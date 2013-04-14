<?php
	//取得表單資料
	$account = $_POST["account"]; 
	$email = $_POST["email"];
	$show_method = $_POST["show_method"]; 


	//建立資料連接
	$link = mysql_connect("localhost", "3116", "3116");
	if (!$link) die("建立資料連接失敗");
			
	//開啟資料表
	$db_selected = mysql_select_db("3116", $link);
	if (!$db_selected) die("開啟資料庫失敗");
	
	//檢查查詢的帳號是否存在
	$sql = "SELECT name, password FROM users WHERE 
	        account = '$account' AND email = '$email'";
  	mysql_query("SET NAMES 'utf8'");	        
	$result = mysql_query($sql, $link);
	if (!$result) die("執行 SQL 命令失敗");

	//如果帳號不存在
	if (mysql_num_rows($result) == 0)
	{
		//顯示訊息告知使用者，查詢的帳號並不存在
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('您所查詢的資料不存在，請檢查是否輸入錯誤');";
		echo "history.back();";
		echo "</SCRIPT>";
	}
	
	//如果帳號存在
	else
	{
		$name = mysql_result($result, 0, "name");
		$password = mysql_result($result, 0, "password");
		
		if ($show_method == "網頁顯示")
		{
			//顯示訊息告知使用者帳號密碼
			echo "$name 您好，您的帳號資料如下：<BR><BR>";
			echo "　　帳號：$account<BR>";
			echo "　　密碼：$password<BR><BR>";
			echo "<A HREF='index.htm'>按此登入本站</A>";
		}
		else
		{
			$message = $name . "您好，您的帳號為 " . $account . "，密碼為 ";
			$message .= $password . "，請牢記，別再忘記了哦！";			
			$message = iconv("UTF-8", "Big5", $message);
			$test=mail($email, iconv("UTF-8", "Big5", "帳號通知"), $message);	
			if($test) {
    			echo '<strong>Successful!</strong>';
			} else {
    			echo '<strong>Failure!</strong>';
			}
			echo "<BR>";
			//顯示訊息告知帳號密碼已寄至其電子郵件了
			echo "$name 您好，您的帳號資料已經寄至 $email<BR><BR>";
			echo "<A HREF='index.htm'>按此登入本站</A>";				
		}
	}

  //釋放 $result 佔用的記憶體
	mysql_free_result($result);
		
	//關閉資料連接	
	mysql_close($link);
?>