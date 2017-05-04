<?php

namespace TimFeid\Slack;

use InvalidArgumentException;
use ArrayAccess;
use JsonSerializable;

class Message implements ArrayAccess, JsonSerializable
{
    /**
     * @var TimFeid\Slack\Client The slack client
     */
    protected $client;
    /**
     * @var string Channel, private group, or IM channel to send message to
     */
    protected $channel;

    /**
     * @var string Text of the message to send
     */
    protected $text;

    /**
     * @var string Change how messages are treated
     */
    protected $parse;

    /**
     * @var boolean Find and link channel names and usernames
     */
    protected $linkNames;

    /**
     * @var array Array of TimFeid\Slack\Attachment objects
     */
    protected $attachments = [];

    /**
     * @var string Set your bot's user name
     */
    protected $username;

    /**
     * @var boolean Pass true to enable unfurling of primarily text-based content
     */
    protected $unfurlLinks;

    /**
     * @var boolean Pass false to disable unfurling of media content
     */
    protected $unfurlMedia;

    /**
     * @var string URL or Emoji string to use as the icon
     */
    protected $icon;

    /**
     * @var float Provide another message's ts value to make this message a reply
     */
    protected $threadTs;

    /**
     * @var boolean Used in conjunction with thread_ts and indicates whether reply
     * should be made visible to everyone in the channel or conversation
     */
    protected $replyBroadcast;

    public function __construct(Client $client, $defaults = [])
    {
        $this->client = $client;

        foreach ($defaults as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Set the channel to send to
     *
     * @param string $channel  The channel to send to
     *
     * @return TimFeid\Slack\Message
     */
    public function to($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Set the channel to send to
     *
     * @param string $channel  The channel to send to
     *
     * @return TimFeid\Slack\Message
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get the channel
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set the user to send from
     *
     * @param string $username The username to send as
     *
     * @return TimFeid\Slack\Message
     */
    public function from($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set the username to send from
     *
     * @param string $username The username to send as
     *
     * @return TimFeid\Slack\Message
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the text to send
     *
     * @param string $text The text to send
     *
     * @return TimFeid\Slack\Message
     */
    public function withText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the text to send
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Send the message to Slack
     *
     * @param string $text The text to send
     *
     * @return Response
     */
    public function send($text = null)
    {
        if ($text) {
            $this->withText($text);
        }

        $this->client->send($this);
    }

    public function __set($key, $value)
    {
        if (!property_exists($this, $key)) {
            throw new InvalidArgumentException("Unable to find key '{$key}'");
        }

        $this->$key = $value;
    }

    public function offsetExists($offset)
    {
        return property_exists($this, $offset) && !is_object($this->$offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        if (is_object($this->$offset)) {
            throw new InvalidArgumentException("Unable to set offset '{$offset}'");
        }

        $this->$offset = $value;
    }

    public function offsetUnset($offset)
    {
        $this->$offset = '';
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $array = [];
        foreach (get_class_vars(static::class) as $key => $default) {
            if (!is_object($this[$key])) {
                $array[$key] = $this[$key];
            }
        }

        return array_filter($array);
    }

    public function toJson($options = [])
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
