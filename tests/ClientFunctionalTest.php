<?php

use TimFeid\Slack\Client;
use TimFeid\Slack\Message;

class ClientFunctionalTest extends TestCase
{
    public function testMessage()
    {
        $data = [
            'username' => $this->faker->firstName,
            'channel' => "@{$this->faker->firstName}",
            'text' => $this->faker->paragraph(1),
        ];

        $client = new Client($this->faker->url);

        $message = $client->to($data['channel'])->from($data['username'])->withText($data['text']);
        $this->assertInstanceOf(Message::class, $message);

        $payload = $client->getPayload($message);
        $this->assertEquals($data, $payload);
    }
}
