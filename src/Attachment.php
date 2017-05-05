<?php

namespace TimFeid\Slack;

use InvalidArgumentException;

class Attachment extends Payloadable
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

    public function attachField($field)
    {
        if ($field instanceof AttachmentField || is_array($field)) {
            $this->fields[] = is_array($field) ? new AttachmentField($field) : $field;

            return $this;
        }

        throw new InvalidArgumentException('Please supply an array of properties or an instance of '.AttachmentField::class);
    }

    public function setFields($fields)
    {
        if (!isset($fields[0])) {
            throw new InvalidArgumentException("Fields must be an array");
        }

        foreach ($fields as $field) {
            $this->attachField($field);
        }

        return $this;
    }
}
