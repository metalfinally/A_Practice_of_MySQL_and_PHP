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
		
		$row = mysql_fetch_assoc($result);
?>
<HTML>
  <HEAD>
    <TITLE>修改會員資料</TITLE>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
  	<SCRIPT LANGUAGE="JAVASCRIPT">
    	function check_data()
			{
				if (document.myForm.password.value.length == 0)
				{
					alert("「使用者密碼」一定要填寫哦...");
					return false;
				}
				if (document.myForm.password.value.length > 10)
				{
					alert("「使用者密碼」不可以超過 10 個字元哦...");
					return false;
				}
				if (document.myForm.re_password.value.length == 0)
				{
					alert("「密碼確認」欄位忘了填哦...");
					return false;
				}
				if (document.myForm.password.value != document.myForm.re_password.value)
				{
					alert("「密碼確認」欄位與「使用者密碼」欄位一定要相同...");
					return false;
				}
				if (document.myForm.ids.value.length == 0)
				{
					alert("您一定要留下身分證字號哦！");
					return false;
				}
				if (document.myForm.ids.value.length != 10)
				{
					alert("身分證字號一定要10位哦！");
					return false;
				}
				if (document.myForm.name.value.length == 0)
				{
					alert("您一定要留下真實姓名哦！");
					return false;
				}	
				if (document.myForm.year.value.length == 0)
				{
					alert("您忘了填「出生年」欄位了...");
					return false;
				}
				if (document.myForm.month.value.length == 0)
				{
					alert("您忘了填「出生月」欄位了...");
					return false;
				}	
				if (document.myForm.month.value > 12 | document.myForm.month.value < 1)
				{
					alert("「出生月」應該介於 1-12 之間哦！");
					return false;
				}
				if (document.myForm.day.value.length == 0)
				{
					alert("您忘了填「出生日」欄位了...");
					return false;
				}
				if (document.myForm.month.value == 2 & document.myForm.day.value > 29)
				{
					alert("二月只有 28 天，最多 29 天");
					return false;
				}	
				if (document.myForm.month.value == 4 | document.myForm.month.value == 6
				  | document.myForm.month.value == 9 | document.myForm.month.value == 11)
				{
				  if (document.myForm.day.value > 30)
					{
						alert("4 月、6 月、9 月、11 月只有 30 天哦！");
						return false;					
					}
				}	
				else
				{
				  if (document.myForm.day.value > 31)
					{
						alert("1 月、3 月、5 月、7 月、8 月、10 月、12 月只有 31 天哦！");
						return false;					
					}				
				}
				if (document.myForm.day.value > 31 | document.myForm.day.value < 1)
				{
					alert("出生日應該在 1-31 之間");
					return false;
				}
				if (document.myForm.email.value.length == 0)
				{
					alert("您忘了填「E-mail」欄位了...");
					return false;
				}
				myForm.submit();
			}
  	</SCRIPT>
  </HEAD>
  <BODY>
		<P ALIGN="center">使用者資料修改</P>
		<FORM NAME="myForm" METHOD="post" ACTION="update.php" >
			<TABLE BORDER="2" ALIGN="center" BORDERCOLOR="#6666FF">
				<TR> 
					<TD COLSPAN="2" BGCOLOR="#6666FF" ALIGN="center"> 
						<FONT COLOR="#FFFFFF">請填入下列資料 (標示「*」欄位請務必填寫)</FONT>
					</TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">*使用者帳號：</TD>
					<TD><?= $row{"account"} ?></TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">*使用者密碼：</TD>
					<TD> 
						<INPUT TYPE="password" NAME="password" SIZE="15" VALUE="<?= $row{"password"} ?>">
						(請使用英文或數字鍵，勿使用特殊字元)
					</TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">*密碼確認：</TD>
					<TD >
						<INPUT TYPE="password" NAME="re_password" SIZE="15" VALUE="<?= $row{"password"} ?>">
						(再輸入一次密碼，並記下您的使用者名稱與密碼)
					</TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">*身分證字號：</TD>
					<TD><INPUT TYPE="text" NAME="ids" SIZE="10" VALUE="<?= $row{"ids"} ?>">
						(第一個英文請小寫)
					</TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">*姓名：</TD>
					<TD><INPUT TYPE="text" NAME="name" SIZE="8" VALUE="<?= $row{"name"} ?>"></TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">*性別：</TD>
					<TD> 
						<INPUT TYPE="radio" NAME="sex" VALUE="男" CHECKED>男 
						<INPUT TYPE="radio" NAME="sex" VALUE="女">女
					</TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">*生日：</TD>
					<TD>民國 
						<INPUT TYPE="text" NAME="year" SIZE="2" VALUE="<?= $row{"year"} ?>">年 
						<INPUT TYPE="text" NAME="month" SIZE="2" VALUE="<?= $row{"month"} ?>">月 
						<INPUT TYPE="text" NAME="day" SIZE="2" VALUE="<?= $row{"day"} ?>">日
					</TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">電話：</TD>
					<TD> 
						<INPUT TYPE="text" NAME="telephone" SIZE="20" VALUE="<?= $row{"telephone"} ?>">
						(依照 (02) 2311-3836 格式 or (04) 657-4587)
					</TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">行動電話：</TD>
					<TD> 
						<INPUT TYPE="text" NAME="cellphone" SIZE="20" VALUE="<?= $row{"cellphone"} ?>">
						(依照 (0922) 302-228 格式)
					</TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">地址：</TD>
					<TD><INPUT TYPE="text" NAME="address" SIZE="45" VALUE="<?= $row{"address"} ?>"></TD>
				</TR>
				<TR BGCOLOR="#99FF99"> 
					<TD ALIGN="right">E-mail 帳號：</TD>
					<TD><INPUT TYPE="text" NAME="email" SIZE="30" VALUE="<?= $row{"email"} ?>"></TD>
				</TR>
				
				<TR BGCOLOR="#99FF99"> 
					<TD COLSPAN="2" ALIGN="CENTER"> 
						<INPUT TYPE="button" VALUE="修改資料" onClick="check_data()">
						<INPUT TYPE="reset" VALUE="重新填寫">
					</TD>
				</TR>
			</TABLE>
		</FORM>
  </BODY>
</HTML>
<?php
		//釋放資源及關閉資料連接
		mysql_free_result($result);
		mysql_close($link);
	}
?>