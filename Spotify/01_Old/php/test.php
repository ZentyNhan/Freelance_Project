<?php
$command = escapeshellcmd('/usr/local/bin/python3.9 Selenium_Test_Args.py free280223@kikyushop.com Hoang123 https://www.spotify.com/tr-tr/family/join/invite/CzX87ZyAX178xbc/ Binbirdirek');
$output = shell_exec($command);
echo $output;
?>