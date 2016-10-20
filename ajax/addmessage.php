<?php
$data = json_decode(file_get_contents('php://input'), true);
$time=time();
$data1 = $data['name'];
$data1.= $data['value'];
$data2 = $data['value'];
$data2.=$data['name'];
$link = mysqli_connect('localhost','root','','chat');
mysqli_set_charset($link,'utf8');

		mysqli_query($link,"INSERT INTO $data1 (nick,message,time) VALUES ('".mysqli_real_escape_string($link,$data['value'])."','".mysqli_real_escape_string($link,$data['message'])."', NOW()) ");

		mysqli_query($link,"INSERT INTO $data2 (nick,message,time) VALUES ('".mysqli_real_escape_string($link,$data['value'])."','".mysqli_real_escape_string($link,$data['message'])."', NOW()) ");

