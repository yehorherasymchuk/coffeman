<?php

namespace App\Services\Http;

use App\Services\Http\Exception\InvalidParamsDataException;
use App\Services\Http\Exception\NotAuthorizedException;
use App\Services\Http\Exception\NotFoundException;
use App\Services\Http\Exception\PermissionDeniedException;
use App\Services\Http\Exception\ServerErrorException;
use \GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

abstract class HttpClient
{

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @return GuzzleClient
     */
    protected function makeClient()
    {
        if (!$this->client) {
            $this->client = new GuzzleClient(
                [
                    'base_uri' => $this->getServiceHost(),
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'http_errors' => false,
                ]
            );
        }

        return $this->client;
    }

    /**
     * @param $uri
     * @param $attempts
     * @param array $params
     * @return mixed|null
     * @throws PermissionDeniedException
     */
    protected function getWithAttempts($uri, $attempts, $params = [])
    {
        $i = 0;
        $response = null;
        while ($i < $attempts) {
            $response = $this->get($uri, $params);
            if (!empty($response)) {
                break;
            }

            $i++;
        }

        return $response;
    }

    /**
     * @note pass 'cache' in params to cache response
     *
     * @param $uri
     * @param array $params
     * @return mixed|null
     * @throws PermissionDeniedException
     */
    protected function get($uri, $params = [])
    {
        $client = $this->makeClient();
        /** @var ResponseInterface $response */
        $response = $client->get($uri, $params);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 404) {
            return null;
        }
        if ($statusCode == 403) {
            throw new PermissionDeniedException('Forbidden');
        }
        $responseBody = json_decode((string)$response->getBody(), true);


        return $responseBody;
    }

    /**
     * @param ResponseInterface $response
     * @throws InvalidParamsDataException
     * @throws NotAuthorizedException
     * @throws NotFoundException
     * @throws PermissionDeniedException
     * @throws ServerErrorException
     */
    protected function parseResponseStatus(ResponseInterface $response)
    {
        if ($response->getStatusCode() < 400) {
            return;
        }
        if ($response->getStatusCode() == 400 || $response->getStatusCode() == 422) {
            throw new InvalidParamsDataException(json_decode($response->getBody(), true));
        }
        if ($response->getStatusCode() == 401) {
            throw new NotAuthorizedException('Unauthorized');
        }
        if ($response->getStatusCode() == 403) {
            throw new PermissionDeniedException('Forbidden');
        }
        if ($response->getStatusCode() == 404) {
            throw new NotFoundException('Not Found');
        }
        if ($response->getStatusCode() > 400 && $response->getStatusCode() < 500) {
            throw new InvalidParamsDataException(json_decode($response->getBody(), true));
        }
        throw new ServerErrorException(json_decode($response->getBody(), true));
    }

    /**
     * @param $uri
     * @param null $body
     * @param array $params
     * @return mixed
     * @throws InvalidParamsDataException
     * @throws NotAuthorizedException
     * @throws NotFoundException
     * @throws PermissionDeniedException
     * @throws ServerErrorException
     */
    protected function post($uri, $body = null, $params = [])
    {
        $client = $this->makeClient();
        if (!is_null($body)) {
            if (!empty($params['multipart'])) {
                $params['multipart'] = $body;
            } elseif (!empty($params['json'])) {
                $params['json'] = $body;
            } else {
                $params['form_params'] = $body;
            }
//            $params['body'] = $body;
        }

        try {
            /** @var ResponseInterface $response */
            $response = $client->post($uri, $params);
        } catch (ClientException $e) {
            $this->parseResponseStatus($e->getResponse());
        }
        $responseBody = (string) $response->getBody();
        return json_decode($responseBody, true);
    }

    protected function patch($uri, $body = null, $params = [])
    {
        $client = $this->makeClient();

        if (!is_null($body)) {
            $params['body'] = $body;
        }

        /** @var ResponseInterface $response */
        $response = $client->patch($uri, $params);

        $responseBody = (string)$response->getBody();
        return json_decode($responseBody, true);
    }

    /**
     * @param $uri
     * @param null $body
     * @param array $params
     * @return mixed
     * @throws InvalidParamsDataException
     * @throws NotAuthorizedException
     * @throws NotFoundException
     * @throws PermissionDeniedException
     * @throws ServerErrorException
     */
    protected function put($uri, $body = null, $params = [])
    {
        $client = $this->makeClient();

        if (!is_null($body)) {
            if (!empty($params['multipart'])) {
                $params['multipart'] = $body;
            } else {
                $params['form_params'] = $body;
            }
//            $params['body'] = $body;
        }
        try {
            /** @var ResponseInterface $response */
            $response = $client->put($uri, $params);
        } catch (ClientException $e) {
            $this->parseResponseStatus($e->getResponse());
        }
        $responseBody = (string) $response->getBody();
        return json_decode($responseBody, true);
    }

    protected function delete($uri, $params = [])
    {
        $client = $this->makeClient();

        /** @var ResponseInterface $response */
        $response = $client->delete($uri, $params);

        $responseBody = (string)$response->getBody(true);
        return json_decode($responseBody, true);
    }

    abstract protected function getServiceHost();
}
