<?php
//require_once 'vendor/autoload.php';

$access_token = '+0SrTLoZWRp4Fq/dSztfyX+yWwmRLIpIgLTMG0xE/M5hsTqT97/GsXkAXfQW2G8uodEgfbiSuvR4AOnO4CXN3IINjOE7hmGiKA+YIapyxjnjHipS02l0VOjgegMk4j8k52X8BnMcupok7bX4KLK1YgdB04t89/1O/w1cDnyilFU=';
$secret = 'd84110d1394770c0075d31101d92d588';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];


      //if (strpos($text, "หา") !== false) {
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_URL, 'https://th.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles='.$text);
        $result1 = curl_exec($ch1);
        curl_close($ch1);

        $obj = json_decode($result1, true);
        foreach($obj['query']['pages'] as $key => $val){
          $result_text = $val['extract'];
        }

        if(empty($result_text)){//ถ้าไม่พบให้หาจาก en
          $ch1 = curl_init();
          curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch1, CURLOPT_URL, 'https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles='.$text);
          $result1 = curl_exec($ch1);
          curl_close($ch1);

          $obj = json_decode($result1, true);
          foreach($obj['query']['pages'] as $key => $val){
            $result_text = $val['extract'];
          }
        }
        if(empty($result_text)){//หาจาก en ไม่พบก็บอกว่า ไม่พบข้อมูล ตอบกลับไป
          $result_text = 'ไม่พบข้อมูล';
        }
        $response_format_text = ['contentType'=>1,"toType"=>1,"text"=>$result_text];

      //}

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				//'messages' => [$messages],
        'messages' => $response_format_text;
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
?>
