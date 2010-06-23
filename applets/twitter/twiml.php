<?php
$name = AppletInstance::getValue('name');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://api.twitter.com/1/users/show.json?screen_name=' . $name);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$tweet = json_decode(curl_exec($ch));
curl_close($ch);

$response = new Response();

if(AppletInstance::getFlowType() == 'voice'){
	$response->addSay($tweet->status->text);
	$next = AppletInstance::getDropZoneUrl('next');
	if(!empty($next))
		$response->addRedirect($next);
}
else
	$response->addSms($tweet->status->text);

$response->Respond();