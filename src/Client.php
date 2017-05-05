<?php

namespace TimFeid\Slack;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    protected $defaultParamters = [];
    protected $endpoint;
    protected $guzzleClient;

    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
        $this->guzzleClient = new GuzzleClient();
    }

    public function setDefaultParameters($parameters)
    {
        $this->defaultParamters = $parameters;
    }

    public function createMessage()
    {
        $args = func_get_args();
        $parameters = $args[0] ?? $this->defaultParamters;

        return new Message($this, $parameters);
    }

    public function getMessageArray(Message $message)
    {
        return $message->toArray();
    }

    public function getMessagePayload(Message $message)
    {
        return $message->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function sendMessage(Message $message)
    {
        $payload = $this->getMessagePayload($message);

        return $this->guzzleClient->post($this->endpoint, ['body' => $payload]);
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->createMessage(), $method], $parameters);
    }
}
