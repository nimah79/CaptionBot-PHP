<?php

/*
 * Simple API wrapper for Microsoft CaptionBot
 * By NimaH79
 * NimaH79.ir
*/

function getImageCaption($image_url)
{
    $ch = curl_init('https://captionbot.azurewebsites.net/api/messages');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('Type' => 'CaptionRequest', 'Content' => $image_url)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response);
    return $response;
}

echo getImageCaption('YOUR_IMAGE_URL');
