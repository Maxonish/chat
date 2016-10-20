<?php
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['nick'])&& isset($data['password'])){
    $link = mysqli_connect('localhost','root','','chat');
	mysqli_set_charset($link,'utf8');
    $res = mysqli_query($link,"SELECT * from `users` WHERE `Nickname`='".mysqli_real_escape_string($link,$data['nick'])."' AND `Password`='".md5($data['password'])."' LIMIT 1 ") or exit(mysqli_error($link));
    if (mysqli_num_rows($res)){
    $res = mysqli_query($link,"SELECT Nickname FROM `users` WHERE `Nickname` != '".mysqli_real_escape_string($link,$data['nick'])."'") or exit(mysqli_error($link));
    $users=array();
    for($i=0;$i<mysqli_num_rows($res); $i++){
    $row =  mysqli_fetch_assoc($res);
    $users[$i]=$row;
    }
    echo json_encode($users);
    }else {
        echo 'false';
}
} 

