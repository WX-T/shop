<?php
$xmlStr = "<xml>\n";
$xmlStr .= "<_grparam>";
$xmlStr .= "<TrackId>WSE1322313113</TrackId>";
$xmlStr .= "<datafrom>ZHONGTONG</datafrom>";
$xmlStr .= "<shipfrom>上海市 浦东新区 张江镇，祖冲之路 2667 22号".$_GET['id']."</shipfrom>";
$xmlStr .= "</_grparam>\n";
$xmlStr .="</xml>\n";

echo $xmlStr;exit;
?>