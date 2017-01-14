<?php

    use LINE\LINEBot;
    use LINE\LINEBot\HTTPClient\CurlHTTPClient;
    use LINE\LINEBot\Constant\HTTPHeader;
    use LINE\LINEBot\Exception\InvalidSignatureException;
    use LINE\LINEBot\Exception\UnknownEventTypeException;
    use LINE\LINEBot\Exception\UnknownMessageTypeException;
    use LINE\LINEBot\Exception\InvalidEventRequestException;

    //SDKの読み込み
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once 'config.php';
    require_once 'searchImage.php';

    //認証
    $bot = new LINEBot(CurlHTTPClient($channelToken),[
        'channelSecret'=>$channelSecret
    ]);
    $app = new searchImage();

    //jsonファイルからイベントの所得及びエラー処理
    $signature = $_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE];
    try {
    $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
    } catch(InvalidSignatureException $e) {
        error_log("parseEventRequest failed. InvalidSignatureException => ".var_export($e, true));
    } catch(UnknownEventTypeException $e) {
        error_log("parseEventRequest failed. UnknownEventTypeException => ".var_export($e, true));
    } catch(UnknownMessageTypeException $e) {
        error_log("parseEventRequest failed. UnknownMessageTypeException => ".var_export($e, true));
    } catch(InvalidEventRequestException $e) {
        error_log("parseEventRequest failed. InvalidEventRequestException => ".var_export($e, true));
    }
    
    foreach($events as $event){
        if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
            error_log('Non message event has come');
            continue;
        }
        if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
            error_log('Non text message has come');
            continue;
        }
        //アプリケーション実行
        $app->search($event->getText());
        //アプリケーションから帰ってきたものを送りつける
        $bot->replyText($event->getReplyToken(),$app);
    }
?>