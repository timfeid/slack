<?php

namespace TimFeid\Slack;

use InvalidArgumentException;
use ArrayAccess;
use JsonSerializable;

class Attachment implements ArrayAccess, JsonSerializable
{
    /**
     * The fallback text to use for clients that don't support attachments.
     *
     * @var string
     */
    protected $fallback;

    /**
     * Optional text that should appear within the attachment.
     *
     * @var string
     */
    protected $text;

    /**
     * Optional image that should appear within the attachment.
     *
     * @var string
     */
    protected $imageUrl;

    /**
     * Optional thumbnail that should appear within the attachment.
     *
     * @var string
     */
    protected $thumbUrl;

    /**
     * Optional text that should appear above the formatted data.
     *
     * @var string
     */
    protected $pretext;

    /**
     * Optional title for the attachment.
     *
     * @var string
     */
    protected $title;

    /**
     * Optional title link for the attachment.
     *
     * @var string
     */
    protected $titleLink;

    /**
     * Optional author name for the attachment.
     *
     * @var string
     */
    protected $authorName;

    /**
     * Optional author link for the attachment.
     *
     * @var string
     */
    protected $authorLink;

    /**
     * Optional author icon for the attachment.
     *
     * @var string
     */
    protected $authorIcon;

    /**
     * The color to use for the attachment.
     *
     * @var string
     */
    protected $color;

    /**
     * The text to use for the attachment footer.
     *
     * @var string
     */
    protected $footer;

    /**
     * The icon to use for the attachment footer.
     *
     * @var string
     */
    protected $footerIcon;

    /**
     * The timestamp to use for the attachment.
     *
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * The fields of the attachment.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * The fields of the attachment that Slack should interpret
     * with its Markdown-like language.
     *
     * @var array
     */
    protected $markdownFields = [];

    /**
     * A collection of actions (buttons) to include in the attachment.
     * A maximum of 5 actions may be provided.
     *
     * @var array
     */
    protected $actions = [];

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    public function __set($key, $value)
    {
        $this[$key] = $value;
    }

    public function offsetExists($offset)
    {
        return property_exists($this, $offset) && !is_object($this->$offset);
    }

    public function offsetGet($offset)
    {
        $offset = Str::camel($offset);

        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        if (is_object($this->$offset)) {
            throw new InvalidArgumentException("Unable to set offset '{$offset}'");
        }

        if ($offset === 'icon') {
            return $this->setIcon($value);
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
                $array[Str::snake($key)] = $this[$key];
            }
        }

        return array_filter($array);
    }

    public function toJson(int $options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
