<?php
require_once('resize.php');
$images=new imgresize();
$images->resize($argv[1],$argv[2],$argv[3],$argv[4])

?>