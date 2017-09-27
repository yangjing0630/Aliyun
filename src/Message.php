<?php

namespace JiSight\Message;
require_once 'php_sdk/mns-autoloader.php';

use AliyunMNS\Client;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Requests\PublishMessageRequest;
use Faker\Provider\Uuid;

class Message
{

    public function send($endPoint, $accessId, $accessKey, $topicName, $signName, $templateCode, $mobile)
    {

        $client = new Client($endPoint, $accessId, $accessKey);

        $topic = $client->getTopicRef($topicName);

        $batchSmsAttributes = new BatchSmsAttributes($signName, $templateCode);

        $code = Uuid::randomNumber(6, true);

        $batchSmsAttributes->addReceiver($mobile, array("code" => "{$code}"));

        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));

        $messageBody = "smsmessage";

        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        try {
            $result = $topic->publishMessage($request);
            return [
                'status_code' => 200,
                'status_msg' => 'ok',
                'data' => ['code' => $code]
            ];
        } catch
        (MnsException $e) {
            return [
                'status_code' => $e->getCode(),
                'status_msg' => $e->getMessage(),
            ];
        }

    }


}