<?php

use TimFeid\Slack\Client;
use TimFeid\Slack\Message;

class ClientFunctionalTest extends TestCase
{
    public function testMessage()
    {
        $data = [
            'username' => $this->faker->firstName,
            // 'channel' => "@{$this->faker->firstName}",
            'channel' => '@timfeid',
            'text' => $this->faker->sentence,
            'icon' => ":{$this->faker->word}:",
            'unfurl_links' => true,
            'attachments' => [
                [
                    'fallback' => $this->faker->sentence,
                    'color' => $this->faker->hexColor,
                    'fields' => [
                        [
                            'title' => $this->faker->sentence,
                            'value' => $this->faker->sentence,
                        ],
                    ],
                ]
            ],
        ];

        $expectedPayload = $data;
        $expectedPayload['icon_emoji'] = $data['icon'];

        $client = new Client($this->faker->url);

        $message = $client->createMessage($data);
        $this->assertInstanceOf(Message::class, $message);

        $payload = $client->getMessageArray($message);
        $this->assertEquals($expectedPayload, $payload);
    }
}
