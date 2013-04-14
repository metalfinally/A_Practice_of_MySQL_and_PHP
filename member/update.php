<?php
	//檢查 cookie 中的 passed 變數是否等於 TRUE
	$passed = $_COOKIE["passed"];
	
	/* 如果 cookie 中的 passed 變數不等於 TRUE，
		 表示尚未登入網站，將使用者導向首頁 index.htm */
	if ($passed != "TRUE")
	{
		header("Location:index.htm");
		exit();
	}
	
	/* 	如果 cookie 中的 passed 變數等於 TRUE，
	 		表示已經登入網站，則取得使用者資料 */
	else
	{
  	//取得 modify.php 網頁的表單資料
		$id = $_COOKIE["id"];
 		$password = $_POST["password"];
 		$ids= $_POST["ids"];
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
				
		//執行 UPDATE 陳述式來更新使用者資料
		$sql = "UPDATE users SET password = '$password', ids='$ids', name = '$name', 
		        sex = '$sex', year = $year, month = $month, day = $day, 
						telephone = '$telephone', cellphone = '$cellphone', 
						address = '$address', email = '$email' WHERE id = $id";
		mysql_query("SET NAMES 'utf8'");
		$result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
		
		//關閉資料連接
		mysql_close($link);
	}		
?>
<HTML>
  <HEAD>
    <TITLE>修改會員資料成功</TITLE>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
  </HEAD>
  <BODY>
    <CENTER>
      <P ALIGN="center">修改成功</P><BR><BR>
      <?= $name ?>，恭喜您已經修改資料成功了。
			<P><A HREF="main.php">回會員專屬網頁</A></P>
    </CENTER>        
  </BODY>
</HTML>