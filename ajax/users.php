<?php
$time=time();
$data = json_decode(file_get_contents('php://input'), true);
  $link = mysqli_connect('localhost','root','','chat');
  mysqli_set_charset($link,'utf8');
  mysqli_query($link,"UPDATE `users` SET `time`='".$time."' WHERE `Nickname`='".$data['nick']."'") or exit(mysqli_error($link));
  $res = mysqli_query($link,"SELECT Nickname,time FROM `users` WHERE `Nickname` != '".htmlspecialchars($data['nick'])."'") or exit(mysqli_error($link));
    $users=array();
    for($i=0;$i<mysqli_num_rows($res); $i++){
    $row =  mysqli_fetch_assoc($res);
    $status = $time - $row['time'];
    if ($status<60){
        $row['status']='online';
    } else {
        $row['status']='offline';
    }
    $users[$i]=$row;
    }
    echo json_encode($users);