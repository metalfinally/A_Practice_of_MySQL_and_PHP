<?php
	//清除購物車資料
	setcookie("video_sn_list", "");
	setcookie("video_name_list", "");
	setcookie("video_media_list", "");
	setcookie("video_rental_fee_list", "");
	setcookie("video_rental_period_list", "");
	setcookie("video_extended_fee_list", "");
	setcookie("video_compensation_list", "");
	setcookie("id", "");
	setcookie("passed", "");
	
	//導向 主頁 網頁
	header("location:index.htm");	
?>