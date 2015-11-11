<?php
namespace Rocketeer\Plugins\Newrelic;

use GuzzleHttp\ClientInterface as ClientInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;

class RocketeerNewrelicDeploymentService
{

    const API_URL = 'https://api.newrelic.com/deployments.xml';

    /** @var string */
    private $apiKey = null;

    /** @var ClientInterface */
    private $httpClient = null;

    /**
     * @param string        $apiKey  Your API key for newrelic
     * @param ClientInterface  $client  HTTP client
     */
    public function __construct($apiKey, ClientInterface $client=null)
    {
        if ($client == null) {
            $client = new GuzzleClient();
        }

        $this->httpClient = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * Notify NewRelic that a deployment has taken place
     *
     * @param string $application_id The Newrelic Application ID
     * @param null|string $user The Username that has triggered this deployment
     * @param null|string $description A quick description of the deplopyment
     * @param null|string $revision A revision id or sha that represents the deployment
     * @return bool
     * @throws \Exception
     */
    public function notify($application_id, $user = null, $description = null, $revision = null)
    {
        $payload = [
            'application_id' => $application_id
        ];

        if ($revision !== null) {
            $payload['revision'] = $revision;
        }

        if ($user !== null) {
            $payload['user'] = $user;
        }

        if ($description !== null) {
            $payload['description'] = $description;
        }

        $headers = [
            'x-api-key' => $this->apiKey
        ];

        $request = new Request('POST', self::API_URL, $headers);
        $response = $this->httpClient->send($request, ['form_params' => $payload]);

        if ($response->getStatusCode() != '201') {
            throw new \Exception("Received status code of ".$response->getStatusCode()." with message: ".$response->getReasonPhrase());
        }

        return true;
    }
}