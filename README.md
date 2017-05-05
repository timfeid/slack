# Slack via PHP

This package will utilize [Slack](https://slack.com)'s [incoming webhooks](https://my.slack.com/services/new/incoming-webhook).

## Requirements

* PHP 7+
* PHP mbstring extension

## Basic Usage

### Create a client
```php
// Quick istantiation
$client = new TimFeid\Slack\Client('https://hooks.slack.com...');

// Instantiate with default params
$pamas = [
    'username' => 'Tim Feid',
    'channel' => '#general',
    'unfurl_media' => true,
];

$client = new TimFeid\Slack\Client('https://hooks.slack.com...', $params);
```

### Customizing a message

```php
// Explicitly create a default message
$message = $client->createMessage();

// Set parameters on the message
$message->text = 'This is the text';
$message->icon = ':slack:';

// Or like this
$message['text'] = 'This is the text';

// Or using fluent methods
$message->write('This is the text')->icon(':slack:')->from('username')->to('channel');

// Create a default message from text
$message = $client->write('The text here');

// Create a message with all the parameters you wish to send
$params = [
    'username' => 'Tim Feid',
    'channel' => '#general',
    'text' => 'It\'s happening!',
    'icon' => ':poop:',
    'attachments' => [
        [
            'fallback' => 'This is fallback text',
            'text' => 'Some text on the attachment',
            'image_url' => 'http://placehold.it/320x240',
            'fields' => [
                'title' => 'Field title',
                'value' => 'Field value',
                'short' => false,
            ],
        ],
    ],
];
$message = $client->createMessage($params);
```

### Sending a message
#### Send a basic, default message
```php
$client->send('Hello world!');
```

#### Send a message to a different channel
```php
$client->to('#general')->send('Hello world!');
```

#### Send a direct message with a different username
```php
$client->to('@username')->from('Bob')->send('Hello!');
```

#### Fluent sending
```php
// Implicitly
$message = $message->write('This is the text')->to('channel/@username')->from('username')->icon(':slack:');
$message->send();

// Explicitly
$message->to('channel/@username')->from('username')->icon(':slack:')->send('This is the text');
```