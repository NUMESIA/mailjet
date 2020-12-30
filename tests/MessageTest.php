<?php

namespace Numesia\Mailjet\Test;

use Illuminate\Support\Arr;
use Numesia\Mailjet\MailjetMessage;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /** @var \Numesia\Mailjet\MailjetMessage */
    protected $message;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->message = new MailjetMessage;
    }

    /** @test */
    public function it_accepts_a_content_when_constructing_a_message()
    {
        $message = new MailjetMessage('A message');

        $this->assertEquals('A message', Arr::get($message->toArray(), 'message'));
    }

    /** @test */
    public function it_can_set_the_content()
    {
        $this->message->content('Hello world');

        $this->assertEquals('Hello world', Arr::get($this->message->toArray(), 'message'));
    }

    /** @test */
    public function it_can_set_the_sender()
    {
        $this->message->sender('email@example.com');

        $this->assertEquals('email@example.com', Arr::get($this->message->toArray(), 'sender'));
    }

    /** @test */
    public function it_can_set_the_sender_name()
    {
        $this->message->name('MyCompagny');

        $this->assertEquals('MyCompagny', Arr::get($this->message->toArray(), 'name'));
    }

    /** @test */
    public function it_can_set_the_subject()
    {
        $this->message->name('MySubject');

        $this->assertEquals('MySubject', Arr::get($this->message->toArray(), 'name'));
    }
}
