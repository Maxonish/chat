<?php
$data = json_decode(file_get_contents('php://input'), true);
$time =time();
$link = mysqli_connect('localhost','root','','chat');
mysqli_set_charset($link,'utf8');
mysqli_query($link,"UPDATE `users` SET `time`='".$time."' WHERE `Nickname`='".$data['name']."'") or exit(mysqli_error($link));
