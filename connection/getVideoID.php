<?php

require_once('EmbedYoutubeLiveStreaming.php');

$channelId = "UCNR67yGLoczq9dl1iJ9rU1Q";
$api_key = "AIzaSyB-LoOLQ58Q1YzzdWJnr8uCHCcrVmIjZGs";

$YouTubeLive = new EmbedYoutubeLiveStreaming($channelId,$api_key);

if(!$YouTubeLive->isLive)
{
	echo "There is no live streaming right now! Response is (Decoded to object):<br><br>";
	echo "<pre><code>";
	var_dump($YouTubeLive->objectResponse);
	// print_r($YouTubeLive->arrayResponse);
	echo "</code></pre>";
}
else
{
	echo <<<EOT
There is a live streaming currently! You can see below!<br>
<br>
Title is: {$YouTubeLive->live_video_title}<br>
<br>
Description is: {$YouTubeLive->live_video_description}<br>
<br>
Video ID is: {$YouTubeLive->live_video_id}<br><br>
Thumbs are: {$YouTubeLive->live_video_thumb_default}, {$YouTubeLive->live_video_thumb_medium}, {$YouTubeLive->live_video_thumb_high} <br><br>
Published at: {$YouTubeLive->live_video_published_at}<br><br>
Channel Title: {$YouTubeLive->channel_title}<br><br>

EOT;

	// $YouTubeLive->setEmbedSizeByWidth(200);
	// $YouTubeLive->setEmbedSizeByHeight(200);
	// $YouTubeLive->embed_autoplay = false;

	echo $YouTubeLive->embedCode();
}
?>
