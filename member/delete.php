<?php
	//檢查 cookie 中的 passed 變數是否等於 TRUE
	$passed = $_COOKIE["passed"];
	
	/*	如果 cookie 中的 passed 變數不等於 TRUE，
			表示尚未登入網站，將使用者導向首頁 index.htm */
	if ($passed != "TRUE")
	{
		header("Location:index.htm");
		exit();
	}
	
	/*	如果 cookie 中的 passed 變數等於 TRUE，
			表示已經登入網站，將使用者的帳號刪除 */	
	else
	{
		$id = $_COOKIE["id"];
		
		//建立資料連接
		$link = mysql_connect("localhost", "3116", "3116");
		if (!$link) die("建立資料連接失敗");
				
		//開啟資料表
		$db_selected = mysql_select_db("3116", $link);
		if (!$db_selected) die("開啟資料庫失敗");
				
		//刪除帳號
		$sql = "DELETE FROM users Where id = $id";
		mysql_query("SET NAMES 'utf8'");
		$result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
		
		//關閉資料連接
		mysql_close($link);
	}
?>
<HTML>
  <HEAD>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
		<TITLE>刪除會員資料成功</TITLE>
	</HEAD>
  <BODY BGCOLOR="#FFFFFF">
    <P ALIGN="center">會員資料刪除成功</P>
    <P ALIGN="center">
			您的資料已從本站中刪除，若要再次使用本站台服務，請重新申請，謝謝。
		</P>
    <P ALIGN="center"><A HREF="index.htm">回首頁</A></P>
  </BODY>
</HTML>