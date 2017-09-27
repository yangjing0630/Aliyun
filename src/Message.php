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

    protected $endPoint;

    protected $accessId;

    protected $accessKey;

    protected $topicName;

    public function __construct($endPoint, $accessId, $accessKey, $topicName)
    {
        $this->endPoint = $endPoint;
        $this->accessId = $accessId;
        $this->accessKey = $accessKey;
        $this->topicName = $topicName;
    }

    public function send($signName, $templateCode, $mobile)
    {
        $client = new Client($this->endPoint, $this->accessId, $this->accessKey);

        $topic = $client->getTopicRef($this->topicName);

        $batchSmsAttributes = new BatchSmsAttributes($signName, $templateCode);

        $code = Uuid::randomNumber(6, true);

        $batchSmsAttributes->addReceiver($mobile, array("code" => $code));

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

        } catch (MnsException $e) {
            return [
                'status_code' => $e->getCode(),
                'status_msg' => $e->getMessage(),
            ];
        }

    }


}