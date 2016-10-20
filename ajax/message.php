<?php
$data = json_decode(file_get_contents('php://input'), true);
$data1 = $data['name'];
$data1.= $data['value'];
$data2 = $data['value'];
$data2.=$data['name'];
$link = mysqli_connect('localhost','root','','chat');
mysqli_set_charset($link,'utf8');
if ($res = mysqli_query($link,"SELECT * FROM $data1 ORDER BY `id` ASC")){
    $messages=array();
    for($i=0;$i<mysqli_num_rows($res); $i++){
    $row =  mysqli_fetch_assoc($res);
    $messages[$i]=$row;
    }
    if(mysqli_num_rows($res)){
        if ($data['num']<mysqli_num_rows($res)) {
            echo json_encode($messages);
        }else{
            echo 'dont';
        }
    }else {
        echo 'empty';
    }
    
} elseif ($res = mysqli_query($link,"SELECT * FROM $data2 ORDER BY `id` ASC")){
    $messages=array();
    for($i=0;$i<mysqli_num_rows($res); $i++){
    $row =  mysqli_fetch_assoc($res);
    $messages[$i]=$row;
    }
    if ($data['num']<mysqli_num_rows($res)) {
        echo json_encode($messages);
    }else {
        echo 'dont';
    }
} else {
$res1 = mysqli_query($link,"CREATE TABLE IF NOT EXISTS  $data1 (id INT AUTO_INCREMENT, nick VARCHAR(255), message TEXT, time TIME, PRIMARY KEY (id))") or exit(mysqli_error($link));
echo 'false';
}

