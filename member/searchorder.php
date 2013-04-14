<?php
	//檢查 cookie 中的 passed 變數是否等於 TRUE
	$passed = $_COOKIE{"passed"};
	
	//如果 cookie 中的 passed 變數不等於 TRUE
	//表示尚未登入網站，將使用者導向首頁 index.htm
	if ($passed != "TRUE")
	{
		header("Location:index.htm");
		exit();
	}
	
	//如果 cookie 中的 passed 變數等於 TRUE
	//表示已經登入網站，取得使用者資料	
	else
	{
		$id = $_COOKIE{"id"};
		
		//建立資料連接
		$link = mysql_connect("localhost", "3116", "3116");
		if (!$link) die("建立資料連接失敗");
				
		//開啟資料表
		$db_selected = mysql_select_db("3116", $link);
		if (!$db_selected) die("開啟資料庫失敗");
				
		//執行 SELECT 陳述式取得記錄取得使用者資料
		$sql = "SELECT * FROM users Where id = $id";
		mysql_query("SET NAMES 'utf8'");
		$result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
	/*
	//建立資料連接
	$link = mysql_connect("localhost", "3116", "3116");
	if (!$link) die("建立資料連接失敗");
	
	//開啟資料表
	$db_selected = mysql_select_db("3116", $link);
	if (!$db_selected) die("開啟資料庫失敗");
	
	//檢查會員編號是否正確
	$sql = "SELECT * FROM users WHERE id = '$user_id'";
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query($sql, $link);
	if (!$result) die("執行 SQL 命令失敗");
	
	//如果會員編號錯誤
	if (mysql_num_rows($result) == 0)
	{
	  //釋放 $result 佔用的記憶體
		mysql_free_result($result);
		
		//關閉資料連接
		mysql_close($link);
		
		//顯示訊息要求使用者輸入正確的帳號密碼
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('客戶資料庫查不到這組編號，請重新輸入');";
		echo "history.back();";
		echo "</SCRIPT>";
	}
	//如果會員編號正確
	else
	{*/
		$sql = "SELECT uo_sn AS '訂單編號', set_time AS '出租時間', total_price AS '小計', amount AS '出租片數' FROM upper_order WHERE id = '$id'";
		mysql_query("SET NAMES 'utf8'");
	    $result = mysql_query($sql, $link);
		if (!$result) die("執行 SQL 命令失敗");
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
			    echo "<TD>".mysql_result($result , $j, $k)."</TD>";
			   }
		  	echo "</TR>";
	   	   }
		echo "</TABLE>";
		mysql_free_result($result);
		mysql_close($link);
	}
?>
	<BODY>
    <P ALIGN="center">詳細訂購紀錄查詢</P>
    <P ALIGN="center">請輸入您要查詢之訂單編號，然後按 [查詢] 鈕。</P>
    <FORM METHOD="post" ACTION="searchDorder.php" >
      <TABLE ALIGN="center">
        <TR><TD>訂單編號：</TD>
           <TD><INPUT TYPE="text" NAME="uo_sn" SIZE="10"></TD>
        </TR>
        <TR><TD COLSPAN="2" ALIGN="center"> 
               <INPUT TYPE="submit" VALUE="查詢">　
               <INPUT TYPE="reset" VALUE="重填">
            </TD>
        </TR>
      </TABLE>
    </FORM>
  </BODY>