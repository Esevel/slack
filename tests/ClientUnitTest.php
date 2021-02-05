<?php
namespace Slack\Tests;

use Maknz\Slack\Client;

class ClientUnitTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \RuntimeException
     */
    public function testInstantiationWithNoDefaults()
    {
        $client = new Client('http://fake.endpoint');

        $this->assertInstanceOf('Maknz\Slack\Client', $client);

        $this->assertSame('http://fake.endpoint', $client->getEndpoint());
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\AssertionFailedError
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \RuntimeException
     */
    public function testInstantiationWithDefaults()
    {
        $defaults = [
            'channel' => '#random',
            'username' => 'Archer',
            'icon' => ':ghost:',
            'response_type' => 'ephemeral',
            'link_names' => true,
            'unfurl_links' => true,
            'unfurl_media' => false,
            'allow_markdown' => false,
            'markdown_in_attachments' => ['text'],
        ];

        $client = new Client('http://fake.endpoint', $defaults);

        $this->assertSame($defaults['channel'], $client->getDefaultChannel());

        $this->assertSame($defaults['username'], $client->getDefaultUsername());

        $this->assertSame($defaults['icon'], $client->getDefaultIcon());

        $this->assertTrue($client->getLinkNames());

        $this->assertTrue($client->getUnfurlLinks());

        $this->assertFalse($client->getUnfurlMedia());

        $this->assertSame($defaults['allow_markdown'], $client->getAllowMarkdown());

        $this->assertSame($defaults['markdown_in_attachments'], $client->getMarkdownInAttachments());
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \RuntimeException
     */
    public function testCreateMessage()
    {
        $defaults = [
            'channel' => '#random',
            'username' => 'Archer',
            'icon' => ':ghost:',
        ];

        $client = new Client('http://fake.endpoint', $defaults);

        $message = $client->createMessage();

        $this->assertInstanceOf('Maknz\Slack\Message', $message);

        $this->assertSame($client->getDefaultChannel(), $message->getChannel());

        $this->assertSame($client->getDefaultUsername(), $message->getUsername());

        $this->assertSame($client->getDefaultIcon(), $message->getIcon());
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \RuntimeException
     */
    public function testWildcardCallToMessage()
    {
        $client = (new Client('http://fake.endpoint'))->to('@regan');

        $this->assertInstanceOf(Client::class, $client);

        $this->assertSame('@regan', $client->getChannel());
    }
}
