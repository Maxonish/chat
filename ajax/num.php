<?php
$data = json_decode(file_get_contents('php://input'), true);
$data1 = $data['name'];
$data1.= $data['value'];
$data2 = $data['value'];
$data2.=$data['name'];
$link = mysqli_connect('localhost','root','','chat');
mysqli_set_charset($link,'utf8');
if ($res = mysqli_query($link,"SELECT * FROM $data1 ORDER BY `id` ASC")){
    $num=  mysqli_num_rows($res);
    echo $num;
} elseif ($res = mysqli_query($link,"SELECT * FROM $data2 ORDER BY `id` ASC")){
    $num=  mysqli_num_rows($res);
    echo $num;
}else {
    echo 'false';
}

