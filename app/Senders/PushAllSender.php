<?php

namespace App\Senders;

class PushAllSender
{
    const PRIORITY = 1;

    private $channelId;

    private $apiKey;

    private $answer;

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
     * @param $title
     * @param $message
     * @param null $url
     * @param integer|null $userId
     * @return bool|mixed|null
     */
    public function push($title, $message, $url = null, $userId = null)
    {
        $array = [
            "type" => "broadcast",
            "id" => $this->channelId,
            "key" => $this->apiKey,
            "text" => $message,
            "title" => $title,
            "priority" => self::PRIORITY,
        ];

        if ($url !== null) {
            $array['url'] = $url;
        }

        if ($userId !== null) {
            $array['type'] = 'unicast';
            $array['uid'] = $userId;
        }

        return $this->send($array);
    }

    private function send(array $arraySend)
    {
        curl_setopt_array(
            $ch = curl_init(),
            array(
                CURLOPT_URL => "https://pushall.ru/api.php",
                CURLOPT_POSTFIELDS => $arraySend,
                CURLOPT_RETURNTRANSFER => true
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);

        return $this->analyseAnswer($result);
    }

    protected function analyseAnswer($result)
    {
        $this->answer = $result = json_decode($result, true) ?? null;

        if ($result === null) {
            return false;
        }

        if (!is_array($result)) {
            return null;
        }

        if (isset($result['error']) && !empty($result['error'])) {
            return false;
        }

        if (isset($result['success']) && $result['success'] == 1) {
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
