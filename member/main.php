<?php
	//檢查 cookie 中的 passed 變數是否等於 TRUE
	$passed = $_COOKIE["passed"];
	
	/*	如果 cookie 中的 passed 變數不等於 TRUE
			表示尚未登入網站，將使用者導向首頁 index.htm	*/
	if ($passed != "TRUE")
	{
		header("location:index.htm");
		exit();
	}
?>
<HTML>
  <HEAD>
    <TITLE>會員管理</TITLE>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
  </HEAD>
  <BODY>
    <P ALIGN="center">會員管理</P>
    <P ALIGN="center">
			<A HREF="modify.php">修改會員資料</A>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<A HREF="searchorder.php">查詢會員訂單資料</A>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<A HREF="logout.php">登出網站</A>
		</P>
  </BODY>
</HTML>