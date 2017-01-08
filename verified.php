<?php
$access_token = '+0SrTLoZWRp4Fq/dSztfyX+yWwmRLIpIgLTMG0xE/M5hsTqT97/GsXkAXfQW2G8uodEgfbiSuvR4AOnO4CXN3IINjOE7hmGiKA+YIapyxjnjHipS02l0VOjgegMk4j8k52X8BnMcupok7bX4KLK1YgdB04t89/1O/w1cDnyilFU=';


$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>
