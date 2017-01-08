<?php
$access_token = '+0SrTLoZWRp4Fq/dSztfyX+yWwmRLIpIgLTMG0xE/M5hsTqT97/GsXkAXfQW2G8uodEgfbiSuvR4AOnO4CXN3IINjOE7hmGiKA+YIapyxjnjHipS02l0VOjgegMk4j8k52X8BnMcupok7bX4KLK1YgdB04t89/1O/w1cDnyilFU=';
$secret = 'd84110d1394770c0075d31101d92d588';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);

$response = $bot->replyText('<reply token>', 'hello!');

?>
