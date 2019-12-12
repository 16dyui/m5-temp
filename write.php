<?php
	file_put_contents('temp.txt', '{"data":'.file_get_contents('php://input').',"time":"'.time().'"}'."\n", FILE_APPEND);
