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
            'icon' => ":{$this->faker->word}:",
            'attachments' => [
                [
                    'fallback' => $this->faker->paragraph(1),
                    'color' => 'red',
                    'fields' => [
                        [
                            'title' => 'TEST',
                            'value' => 'OmG',
                        ],
                    ],
                ]
            ],
        ];

        $expectedPayload = $data;
        $expectedPayload['icon_emoji'] = $data['icon'];
        unset($expectedPayload['icon']);

        $client = new Client($this->faker->url);
        $message = $client->createMessage($data);
        $this->assertInstanceOf(Message::class, $message);

        $payload = $client->getMessageArray($message);
        $this->assertEquals($expectedPayload, $payload);
    }
}
