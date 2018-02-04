<?php

require_once('./line_class.php');

$channelAccessToken = 'k/+WdpkSoZof/xgLClTWtxKAI/MqqJEwyB3Rjydp5jbAUMSVR/PELhxjbsJI9dwSbVLRX/f1gzhhDJ14cIIqBkD9XTrPhF8ecmdUqfw8p884zghRxnMVvZvbDP0ItLB11LLep1Ye/wmwT/uJXVNo1QdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = 'c41d451e0f42f191c338b27603879566';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Jangan spam stciker ??.'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$usernm = str_replace(" ", "%20", $profil->displayName);
$url = 'http://karyakreatif.com/tebakkata2/?pesan='.$pesan.'&gr='.$groupId.'&u='.$userId.'&un='.$usernm;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $pesan.$profil->displayName;
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Mohon Gunakan Bahasa Indonesia Yang Benar :D.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.'  Maaf Bots Sedang Di Perbaiki'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
