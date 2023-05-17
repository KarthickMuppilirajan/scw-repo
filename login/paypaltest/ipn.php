<?php
$myfile = fopen("paypal.txt", "a") or die("Unable to open file!");
$data=$_REQUEST;

fwrite($myfile, '\n /n -----------------------------------------------------------------------------------------------------------------------------------------------');
foreach ($data as $key=>$val)
{
	fwrite($myfile, '\n /n'.$key.' - '.$val);
}
fclose($myfile);


