<?php

namespace Numesia\Mailjet;

use Illuminate\Container\Container;

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
     * The view to be rendered.
     *
     * @var array|string
     */
    public $view;

    /**
     * The view data for the message.
     *
     * @var array
     */
    public $viewData = [];

    /**
     * The email subject.
     *
     * @var string|null
     */
    public $subject;

    /**
     * The raw attachments for the message.
     *
     * @var array
     */
    public $rawAttachments;

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
     * Set the view for the mail message.
     *
     * @param  array|string  $view
     * @param  array  $data
     * @return $this
     */
    public function view($view, array $data = [])
    {
        $this->view     = $view;
        $this->viewData = $data;

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
     * Attach in-memory data as an attachment.
     *
     * @param  string  $data
     * @param  string  $name
     * @param  array  $options
     * @return $this
     */
    public function attachData($data, $name, array $options = [])
    {
        $this->rawAttachments = collect($this->rawAttachments)
                ->push([
                    'Content-type' => data_get($options, "mime"),
                    'Filename' => $name,
                    'content' => $data
                ])
                ->unique(function ($file) {
                    return $file['Filename'].$file['content'];
                })->all();

        return $this;
    }

    /**
     * Get array representation of the message.
     *
     * @return array
     */
    public function toArray(): array
    {
        if ($this->view) {
            $content = Container::getInstance()->make('mailer')->render(
                $this->view, $this->viewData
            );
        } else {
            $content = $this->content;
        }

        return [
            'sender'      => $this->sender,
            'name'        => $this->name,
            'subject'     => $this->subject,
            'content'     => $content,
            'attachments' => $this->rawAttachments,
        ];
    }
}
