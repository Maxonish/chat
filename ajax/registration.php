<?php
$data = json_decode(file_get_contents('php://input'), true);
$time=time();
if (isset($data['nick'])&& isset($data['password'])){
    $link = mysqli_connect('localhost','root','','chat');
mysqli_set_charset($link,'utf8');
    $res = mysqli_query($link,"SELECT Nickname FROM `users` WHERE `Nickname` = '".htmlspecialchars($data['nick'])."'") or exit(mysqli_error($link));
    if (mysqli_num_rows($res)){
        echo 'false';
    } else {
    mysqli_query($link,"INSERT INTO users (Nickname, Password,time ) VALUES ('".mysqli_real_escape_string($link,$data['nick'])."','".md5($data['password'])."',".$time." ) ") or exit(mysqli_error($link));
    echo 'true';
}
}