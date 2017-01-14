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
    $res = $app->search($event->getText());
    $bot->replyText($event->getReplyToken(),$res[0]);
  }






            $option = [
                'text'=>'集合写真',
                'per_page'=>1,
                'extra'=>'url_q'
            ];
            $res = $flickr->photos_search($option);
            $json = json_encode($res);  

            echo $json;
 ?>