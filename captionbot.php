<?php

/*
Simple API wrapper for Microsoft CaptionBot
By NimaH79
http://nimatv.ir
*/

function curl_get_contents($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function getCookie($http_response_header)
{
    foreach ($http_response_header as $header) {
        if (substr($header, 0, 10) === 'Set-Cookie') {
            if (preg_match('/Set-Cookie: (([^=]+)=[^;]+)/i', $header, $matches)) {
                return $matches[1];
            }
        }
    }
}

function sendToCaptionBot($data, $cookie)
{
    $ch = curl_init('https://www.captionbot.ai/api/message');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function getImageCaption($url)
{
    $content = file_get_contents('https://www.captionbot.ai/api/init', false, stream_context_create(['http' => ['header' => "Content-Type: application/json\r\ncharset: utf-8\r\n"]]));
    $cookie = getCookie($http_response_header);
    $conversationId = json_decode($content);
    $data = ['userMessage' => $url, 'conversationId' => $conversationId, 'waterMark' => ''];
    sendToCaptionBot($data, $cookie);

    return json_decode(json_decode(curl_get_contents('https://www.captionbot.ai/api/message?'.http_build_query($data)), true), true)['BotMessages'][1];
}

echo getImageCaption('YOUR_IMAGE_URL');
