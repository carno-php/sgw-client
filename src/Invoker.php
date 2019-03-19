<?php
/**
 * HTTP Invoker
 * User: moyo
 * Date: 27/01/2018
 * Time: 10:50 AM
 */

namespace Carno\Gateway\Client;

use Carno\Gateway\Client\Exception\AccessException;
use Carno\Gateway\Client\Exception\GatewayException;
use Carno\Gateway\Client\Exception\LogicException;
use Carno\Gateway\Client\Exception\NetworkException;
use Carno\Gateway\Client\Exception\SystemException;

class Invoker
{
    /**
     * @var string
     */
    private $scheme = 'http';

    /**
     * @var array
     */
    private $headers = [
        'Content-type' => 'application/json',
    ];

    /**
     * @var string
     */
    private $ip = null;

    /**
     * @var string
     */
    private $host = null;

    /**
     * Invoker constructor.
     * @param string $ip
     * @param string $host
     */
    public function __construct($ip, $host = null)
    {
        $this->ip = $ip;
        $this->host = $host ?: $ip;
    }

    /**
     * @param string $uri
     * @param string $json
     * @param array $headers
     * @return string
     */
    public function perform($uri, $json, array $headers)
    {
        $ch = curl_init(sprintf('%s://%s/%s', $this->scheme, $this->ip, $uri));

        $traceId = $errCode = $errMessage = null;

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => $this->header(array_merge(
                $headers,
                $this->headers,
                ['Host' => $this->host]
            )),
            CURLOPT_HEADERFUNCTION => function ($ch, $line) use (&$traceId, &$errCode, &$errMessage) {
                if ($spx = strpos($line, ':')) {
                    $name = substr($line, 0, $spx);
                    $value = trim(substr($line, $spx + 1));
                    switch ($name) {
                        case 'X-B3-Traceid':
                            $traceId = $value;
                            break;
                        case 'X-Err-Code':
                            $errCode = $value;
                            break;
                        case 'X-Err-Message':
                            $errMessage = $value;
                            break;
                    }
                }
                return strlen($line);
            }
        ]);

        $body = curl_exec($ch);

        if ($body === false) {
            $chEMessage = curl_error($ch);
            $chECode = curl_errno($ch);
        }

        $hCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if (isset($chEMessage) && isset($chECode)) {
            throw new NetworkException($chEMessage, $chECode);
        } else {
            switch ($hCode) {
                case 200:
                    if ($errCode || $errMessage) {
                        throw (new LogicException($errMessage ?: '', $errCode ?: 0))->setTraceId($traceId);
                    }
                    break;
                case 403:
                case 404:
                    throw new AccessException('', $hCode);
                case 500:
                    throw (new SystemException($errMessage ?: '', $errCode ?: 0))->setTraceId($traceId);
                default:
                    throw new GatewayException($body, $hCode);
            }
        }

        return $body;
    }

    /**
     * @param $headers
     * @return array
     */
    private function header($headers)
    {
        $hls = [];
        array_walk($headers, function ($v, $k) use (&$hls) {
            $hls[] = sprintf('%s: %s', $k, $v);
        });
        return $hls;
    }
}
