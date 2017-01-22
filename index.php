<?php

  require_once __DIR__ . '/vendor/autoload.php';
  require_once __DIR__ . '/searchImage/config.php';
  require_once __DIR__ . '/searchImage/searchImage.php';
  require_once __DIR__ . '/searchImage/phpFlickr.php';

  $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelToken);
  $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
  $app = new searchImage();
  $flickr = new phpFlickr($accountKey,$accountSecret);

  $signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
  try {
    $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
  } catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
    error_log("parseEventRequest failed. InvalidSignatureException => ".var_export($e, true));
  } catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
    error_log("parseEventRequest failed. UnknownEventTypeException => ".var_export($e, true));
  } catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
    error_log("parseEventRequest failed. UnknownMessageTypeException => ".var_export($e, true));
  } catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
    error_log("parseEventRequest failed. InvalidEventRequestException => ".var_export($e, true));
  }

  foreach ($events as $event) {
    if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
      error_log('Non message event has come');
      continue;
    }
    if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
      error_log('Non text message has come');
      continue;
    }


    //分岐1 枚数指定のあった場合
    if(preg_match('/^検索\s(\S+)\s([1-5])$/',$event->getText(),$word)){
      $bot->replyText($event->getReplyToken(),"$word[1]$word[2]");
      $res = $app->search_all($word[1],$word[2]);
      if($res[0]){
        foreach($res as $photo){
          $imageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($photo[1],$photo[0]);
          $execution = $bot->replyMessage($event->getReplyToken(),$imageMessageBuilder);
        }
      }else{
          $bot->replyText($event->getReplyToken(),"画像が見つからなかったよ…　ごめんなさい…");
      }
    }

    //分岐2 枚数指定のなかった場合
    else if(preg_match('/^検索\s(.+)$/',$event->getText(),$word)){
      $res = $app->search($word[1]);
      if($res[0] && $res[1]){
        $imageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($res[1],$res[0]);
        $execution = $bot->replyMessage($event->getReplyToken(),$imageMessageBuilder);
      }else{
        $bot->replyText($event->getReplyToken(),"画像が見つからなかったよ…　ごめんなさい…");
      }
    }
    
  }

 ?>