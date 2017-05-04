<?php

use TimFeid\Slack\Client;
use TimFeid\Slack\Message;

class MessageUnitTest extends TestCase
{
    public function testText()
    {
        $message = $this->createMessage();
        $text = $this->faker->paragraph(1);

        $this->assertInstanceOf(Message::class, $message->withText($text));
        $this->assertEquals($text, $message->getText());
        $this->assertEquals($message['text'], $message->getText());
    }

    public function testTo()
    {
        $message = $this->createMessage();
        $channel = $this->faker->firstName;

        $this->assertInstanceOf(Message::class, $message->to($channel));
        $this->assertEquals($channel, $message->getChannel());
        $this->assertEquals($message['channel'], $message->getChannel());
    }

    public function testSetChannel()
    {
        $message = $this->createMessage();
        $channel = $this->faker->firstName;

        $this->assertInstanceOf(Message::class, $message->setChannel($channel));
        $this->assertEquals($channel, $message->getChannel());
        $this->assertEquals($message['channel'], $message->getChannel());
    }

    public function testFrom()
    {
        $message = $this->createMessage();
        $username = $this->faker->firstName;

        $this->assertInstanceOf(Message::class, $message->from($username));
        $this->assertEquals($username, $message->getUsername());
        $this->assertEquals($message['username'], $message->getUsername());
    }

    public function testSetUsername()
    {
        $message = $this->createMessage();
        $username = $this->faker->firstName;

        $this->assertInstanceOf(Message::class, $message->setUsername($username));
        $this->assertEquals($username, $message->getUsername());
        $this->assertEquals($message['username'], $message->getUsername());
    }

    protected function createMessage()
    {
        return new Message(Mockery::mock(Client::class));
    }
}
