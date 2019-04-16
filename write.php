<?php
	file_put_contents('temp.txt', '{"data":'.file_get_contents('php://input').',"date":"'.date('c').'"}'."\n", FILE_APPEND);
