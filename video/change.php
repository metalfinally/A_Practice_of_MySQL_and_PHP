<?php
	//取得表單資料
	$video_sn = $_GET["video_sn"];
	
	//取得購物車資料
	$video_sn_array=explode(",",$_COOKIE["video_sn_list"]);
	$video_name_array=explode(",",$_COOKIE["video_name_list"]);
	$video_media_array=explode(",",$_COOKIE["video_media_list"]);
	$video_rental_fee_array=explode(",",$_COOKIE["video_rental_fee_list"]);
	$video_rental_period_array=explode(",",$_COOKIE["video_rental_period_list"]);
	$video_extended_fee_array=explode(",",$_COOKIE["video_extended_fee_list"]);
	$video_compensation_array=explode(",",$_COOKIE["video_compensation_list"]);
	
	$key = array_search($video_sn, $video_sn_array);
	
	//將該產品從購物車中刪除
	unset($video_sn_array[$key]);
	unset($video_name_array[$key]);
	unset($video_media_array[$key]);
	unset($video_rental_fee_array[$key]);
	unset($video_rental_period_array[$key]);
	unset($video_extended_fee_array[$key]);
	unset($video_compensation_array[$key]);
	
	//儲存購物車資料
	setcookie("video_sn_list",implode(",",$video_sn_array));
	setcookie("video_name_list",implode(",",$video_name_array));
	setcookie("video_media_list",implode(",",$video_media_array));
	setcookie("video_rental_fee_list",implode(",",$video_rental_fee_array));
	setcookie("video_rental_period_list",implode(",",$video_rental_period_array));
	setcookie("video_extended_fee_list",implode(",",$video_extended_fee_array));
	setcookie("video_compensation_list",implode(",",$video_compensation_array));
	
	//導向 shopping_car.php 網頁
	header("location:shopping_car.php");
?>