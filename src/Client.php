<?php

namespace TimFeid\Slack;

class Client
{
    protected $defaultParamters = [];

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

    public function getPayload(Message $message)
    {
        return $message->toArray();
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->createMessage(), $method], $parameters);
    }
}
