<?php
$datas = $_GET["http://api.."];
$status = $datas["status"];
$count = 0;
foreach ($datas["data"] as $data) {
    echo (json_decode($data));
    $count++;
}
