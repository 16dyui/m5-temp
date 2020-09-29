<?php
    $file = file('temp.txt');
    for($i=0;60 < count($file);$i++) {
        unset($file[$i]);
    }
    $file[] = '{"data":'.file_get_contents('php://input').',"time":"'.time().'"}'."\n";
	file_put_contents('temp.txt',$file);
