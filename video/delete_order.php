<?php
	//清除購物車資料
	setcookie("video_sn_list", "");
	setcookie("video_name_list", "");
	setcookie("video_media_list", "");
	setcookie("video_rental_fee_list", "");
	setcookie("video_rental_period_list", "");
	setcookie("video_extended_fee_list", "");
	setcookie("video_compensation_list", "");
	
	//導向 shopping_car.php 網頁
	header("location:shopping_car.php");	
?>