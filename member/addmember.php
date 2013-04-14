<?php
	//取得表單資料
  	$account = $_POST["account"];
  	$password = $_POST["password"];
  	$ids = $_POST["ids"]; 
  	$name = $_POST["name"]; 
	$sex = $_POST["sex"];
  	$year = $_POST["year"]; 
  	$month = $_POST["month"]; 
  	$day = $_POST["day"];
  	$telephone = $_POST["telephone"]; 
  	$cellphone = $_POST["cellphone"]; 	
  	$address = $_POST["address"];
  	$email = $_POST["email"]; 

	//建立資料連接
	$link = mysql_connect("localhost", "3116", "3116");
	if (!$link) die("建立資料連接失敗");
			
	//開啟資料表
	$db_selected = mysql_select_db("3116", $link);
	if (!$db_selected) die("開啟資料庫失敗");
			
	//檢查帳號是否有人申請
	$sql = "SELECT * FROM users Where account = '$account'";
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query($sql, $link);
	if (!$result) die("執行 SQL 命令失敗");

	//如果帳號已經有人使用
	if (mysql_num_rows($result) != 0)
	{
	  	//釋放 $result 佔用的記憶體
		mysql_free_result($result);
		
		//顯示訊息要求使用者更換帳號名稱
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('您所指定的帳號已經有人使用，請使用其它帳號');";
		echo "history.back();";
		echo "</SCRIPT>";
	}
	
	//如果帳號沒人使用
	else
	{
		
	  	//釋放 $result 佔用的記憶體	
		mysql_free_result($result);
		
		//執行 SQL 命令，新增此帳號
		$sql = "INSERT INTO users ( account, password, ids, name, sex, 
		        year, month, day, telephone, cellphone, address,
					  email) VALUES ( '$account', '$password', '$ids', 
						'$name', '$sex', '$year', '$month', '$day', '$telephone', 
						'$cellphone', '$address', '$email')";

		$result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
	}
	
	//關閉資料連接	
	mysql_close($link);
?>
<HTML>
	<HEAD>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
		<TITLE>新增帳號成功</TITLE>
	</HEAD>
	<BODY BGCOLOR="#FFFFFF">      
		<P ALIGN="center">恭喜您已經註冊成功了，您的資料如下：（請勿按重新整理鈕）<BR>
			帳號：<FONT COLOR="#FF0000"><?= $account ?></FONT><BR>
			密碼：<FONT COLOR="#FF0000"><?= $password ?></FONT><BR>       
			請記下您的帳號及密碼，然後<A HREF="index.htm">登入網站</A>。</P>
	</BODY>
</HTML>