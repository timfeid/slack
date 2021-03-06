<?php

namespace TimFeid\Slack;

class Message extends Payloadable
{
    /**
     * @var TimFeid\Slack\Client The slack client
     */
    protected $client;

    /**
     * @var GuzzleHttp\Psr7\Response The latest response
     */
    protected $response;

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
     * @var bool Find and link channel names and usernames
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
     * @var bool Pass true to enable unfurling of primarily text-based content
     */
    protected $unfurlLinks;

    /**
     * @var bool Pass false to disable unfurling of media content
     */
    protected $unfurlMedia;

    /**
     * @var string URL or Emoji string to use as the icon
     */
    protected $icon;

    /**
     * @var string URL to use as the icon
     */
    protected $iconUrl;

    /**
     * @var string Emoji string to use as the icon
     */
    protected $iconEmoji;

    /**
     * @var float Provide another message's ts value to make this message a reply
     */
    protected $threadTs;

    /**
     * @var bool Used in conjunction with thread_ts and indicates whether reply
     *           should be made visible to everyone in the channel or conversation
     */
    protected $replyBroadcast;

    protected $allowMarkdown = true;

    public function __construct(Client $client, $defaults = [])
    {
        $this->client = $client;

        parent::__construct($defaults);
    }

    /**
     * Set the channel to send to.
     *
     * @param string $channel The channel to send to
     *
     * @return TimFeid\Slack\Message
     */
    public function to($channel)
    {
        return $this->setChannel($channel);
    }

    /**
     * Set the channel to send to.
     *
     * @param string $channel The channel to send to
     *
     * @return TimFeid\Slack\Message
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get the channel.
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set the user to send from.
     *
     * @param string $username The username to send as
     *
     * @return TimFeid\Slack\Message
     */
    public function from($username)
    {
        return $this->setUsername($username);
    }

    /**
     * Set the username to send from.
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
     * Get the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the text to send.
     *
     * @param string $text The text to send
     *
     * @return TimFeid\Slack\Message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set the text to send.
     *
     * @param string $text The text to send
     *
     * @return TimFeid\Slack\Message
     */
    public function withText($text)
    {
        return $this->setText($text);
    }

    /**
     * Set the text to send.
     *
     * @param string $text The text to send
     *
     * @return TimFeid\Slack\Message
     */
    public function write($text)
    {
        return $this->setText($text);
    }

    /**
     * Get the text to send.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Send the message to Slack.
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

        $this->response = $this->client->sendMessage($this);

        return $this;
    }

    /**
     * Send message with this icon.
     *
     * @param string Icon url or emoji
     *
     * return TimFeid\Slack\Message
     */
    public function withIcon($icon)
    {
        return $this->setIcon($icon);
    }

    /**
     * Send message with this icon.
     *
     * @param string Icon url or emoji
     *
     * return TimFeid\Slack\Message
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        $type = mb_substr($icon, 0, 1) === ':' && mb_substr($icon, -1) === ':'
            ? 'iconEmoji'
            : 'iconUrl';

        $this->$type = $icon;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function disableMarkdown()
    {
        $this->allowMarkdown = false;

        return $this;
    }

    public function withoutMarkdown()
    {
        return $this->disableMarkdown();
    }

    public function enableMarkdown()
    {
        $this->allowMarkdown = true;

        return $this;
    }

    public function withMarkdown()
    {
        return $this->enableMarkdown();
    }

    public function attach($attachment)
    {
        if ($attachment instanceof Attachment || is_array($attachment)) {
            $this->attachments[] = is_array($attachment) ? new Attachment($attachment) : $attachment;

            return $this;
        }

        throw new InvalidArgumentException('Please supply an array of properties or an instance of '.Attachment::class);
    }

    public function setAttachments($attachments)
    {
        if (!isset($attachments[0])) {
            throw new InvalidArgumentException("Attachments must be an array");
        }

        foreach ($attachments as $attachment) {
            $this->attach($attachment);
        }

        return $this;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function payloadExtras()
    {
        return ['mrkdwn' => $this->allowMarkdown];
    }
}
