<?php

namespace TimFeid\Slack;

class AttachmentField extends Payloadable
{
    /**
     * @var string Shown as a bold heading above the value text.
     */
    protected $title;

    /**
     * @var string The text value of the field.
     */
    protected $value;

    /**
     * @var bool Optional flag indicating whether the value is short
     *           enough to be displayed side-by-side with other values.
     */
    protected $short;
}
