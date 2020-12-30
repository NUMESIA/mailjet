<?php

namespace Numesia\Mailjet;

class MailjetMessage
{
    /**
     * The email content.
     *
     * @var string
     */
    public $content;

    /**
     * The sender email.
     *
     * @var string|null
     */
    public $sender;

    /**
     * The sender name.
     *
     * @var string|null
     */
    public $name;

    /**
     * The email subject.
     *
     * @var string|null
     */
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the email html content.
     *
     * @param  string  $content
     * @return $this
     */
    public function content(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the sender email.
     *
     * @param  string  $sender
     * @return $this
     */
    public function sender(string $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Set the sender name.
     *
     * @param  string  $name
     * @return $this
     */
    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the email subject.
     *
     * @param  string  $subject
     * @return $this
     */
    public function subject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get array representation of the message.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'sender'  => $this->sender,
            'name'    => $this->name,
            'subject' => $this->subject,
            'content' => $this->content,
        ];
    }
}
