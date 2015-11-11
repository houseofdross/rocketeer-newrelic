<?php
namespace Rocketeer\Plugins\Newrelic;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use \Mockery as m;


class RocketeerNewrelicDeploymentServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testNotifyUsesCorrectApiKey()
    {
        $expectedPayload = [
            'form_params' => [
                'application_id' => 'testApplicationId'
            ]
        ];

        $expectedHeaders = [
            'x-api-key' => 'testApiKey'
        ];

        $expectedRequest = new Request('POST', RocketeerNewrelicDeploymentService::API_URL, $expectedHeaders);

        $client = m::mock('\GuzzleHttp\Client');
        $client
            ->shouldReceive('send')
            ->withArgs([m::mustBe($expectedRequest), $expectedPayload])
            ->andReturn(new Response('201'));

        $service = new RocketeerNewrelicDeploymentService('testApiKey', $client);
        $service->notify('testApplicationId');
    }

    public function testNotifyUsesPayloadArguments()
    {
        $expectedPayload = [
            'form_params' => [
                'application_id' => 'testApplicationId',
                'user' => 'testUser',
                'description' => 'testDescription',
                'revision' => 'testRevision'
            ]
        ];

        $client = m::mock('\GuzzleHttp\Client');
        $client
            ->shouldReceive('send')
            ->withArgs([m::any(), $expectedPayload])
            ->andReturn(new Response('201'));

        $service = new RocketeerNewrelicDeploymentService('testApiKey', $client);
        $service->notify('testApplicationId', 'testUser', 'testDescription', 'testRevision');
    }

    public function tearDown()
    {
        m::close();
    }
}
