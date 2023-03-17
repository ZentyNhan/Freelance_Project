<?php 
print "hello Selenium\n";
$command = escapeshellcmd('python3.9 Selenium_Test.py');
$output = shell_exec($command);
print $output; 
?>