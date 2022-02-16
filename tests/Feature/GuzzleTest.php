<?php

namespace Tests\Feature;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use Tests\TestCase;

class GuzzleTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @doesNotPerformAssertions
     * @return void
     * @throws GuzzleException
     */
    public function guzzle_mock_test()
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], 'Hello, World'),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $response = $client->request('GET', '/');
        echo 'Status Code: '.$response->getStatusCode().' / ';
        echo 'Body: '.$response->getBody().' / ';

        $mock->reset();
        $mock->append(new Response(201));
        echo $client->request('GET', '/')->getStatusCode();
    }
}
