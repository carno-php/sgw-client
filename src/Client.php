<?php
/**
 * Gateway client base
 * User: moyo
 * Date: 27/01/2018
 * Time: 10:44 AM
 */

namespace Carno\Gateway\Client;

use Carno\Gateway\Client\Exception\EndpointException;
use Google\Protobuf\Internal\Message;

abstract class Client
{
    /**
     * @var Endpoint
     */
    private $endpoint = null;

    /**
     * @var Context
     */
    private $context = null;

    /**
     * Client constructor.
     * @param Endpoint $endpoint
     */
    final public function __construct(Endpoint $endpoint = null)
    {
        if (is_null($endpoint = $endpoint ?: Endpoint::assigned())) {
            throw new EndpointException('Missing endpoint');
        }

        $this->endpoint = $endpoint;
    }

    /**
     * @return Context
     */
    final public function ctx()
    {
        return $this->context ?: $this->context = new Context;
    }

    /**
     * @param $server
     * @param $service
     * @param $method
     * @param Message $request
     * @param Message $response
     * @return Message
     */
    final protected function request($server, $service, $method, Message $request, Message $response)
    {
        $json = $this->endpoint
            ->invoker()
            ->perform(
                sprintf('%s/%s/%s', $server, $service, $method),
                $request->serializeToJsonString(),
                $this->headers()
            )
        ;

        $response->mergeFromJsonString($json);

        return $response;
    }

    /**
     * @return array
     */
    final private function headers()
    {
        $headers = is_null($auth = $this->endpoint->authorizer()) ? [] : $auth->viaHeaders();

        foreach ($this->endpoint->extensions() as $extension) {
            $headers = $extension->parseHeaders($this->ctx(), $headers);
        }

        return $headers;
    }
}
