<?php

namespace App\Senders\Push;

/**
 * Class PushAllSender
 * @package App\Senders
 */
class PushAllSender implements PusherInterface
{
    /** @var int  */
    public const PRIORITY = 1;

    /** @var string  */
    public const API_URL = 'https://pushall.ru/api.php';

    /** @var int */
    private $channelId;

    /** @var string */
    private $apiKey;

    /** @var mixed */
    private $answer;

    /**
     * PushAllSender constructor.
     */
    public function __construct()
    {
        $this->channelId = env('PUSHALL_CHANNEL_ID');
        $this->apiKey = env('PUSHALL_API_KEY');
    }

    /**
     * Входная точка:
     *
     *  Формируем массив для отправки на PushAll
     *  Отправляем в this->send()
     *
     * @param Push $push
     * @return bool|mixed|null
     */
    public function push(Push $push)
    {
        $array = [
            'type' => 'broadcast',
            'id' => $this->channelId,
            'key' => $this->apiKey,
            'text' => $push->message,
            'title' => $push->title,
            'priority' => static::PRIORITY,
        ];

        if ($push->url !== null) {
            $array['url'] = $push->url;
        }

        if ($push->user !== null && ($id = $push->user->push_all_id)) {
            $array['type'] = 'unicast';
            $array['uid'] = $id;
        }

        return $this->send($array);
    }

    /**
     * @inheritDoc
     */
    public function pushOrFail(Push $push)
    {
        $msg = $this->push($push);
        if ($msg !== false) {
            return $msg;
        }

        if (($answer = $this->getAnswer()) && !empty($answer['error'])) {
            throw new PushException($answer['error']);
        }

        throw new PushUndefinedException();
    }

    /**
     * @param array $data
     * @return bool
     */
    private function send(array $data)
    {
        curl_setopt_array(
            $ch = curl_init(),
            [
                CURLOPT_URL => static::API_URL,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_RETURNTRANSFER => true
            ]
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return $this->analyseAnswer($result);
    }

    /**
     * @param $result
     * @return bool
     */
    protected function analyseAnswer($result): bool
    {
        $this->answer = $result = json_decode($result, true) ?? null;

        if (is_array($result) && !empty($result['success']) && $result['success'] === 1) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
