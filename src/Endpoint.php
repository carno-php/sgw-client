<?php
/**
 * Gateway endpoint
 * User: moyo
 * Date: 27/01/2018
 * Time: 10:33 AM
 */

namespace Carno\Gateway\Client;

use Carno\Gateway\Client\Contracts\Authorizing;
use Carno\Gateway\Client\Contracts\Extensional;
use Carno\Gateway\Client\Traits\GlobalEP;

class Endpoint
{
    use GlobalEP;

    /**
     * @var Invoker
     */
    private $invoker = null;

    /**
     * @var Authorizing
     */
    private $authorizing = null;

    /**
     * @var Extensional[]
     */
    private $extensions = [];

    /**
     * Endpoint constructor.
     * @param string $host
     * @param string $ip
     */
    public function __construct($host, $ip = null)
    {
        $this->invoker = new Invoker($ip ?: gethostbyname($host), $host);
    }

    /**
     * @param Authorizing $auth
     * @return static
     */
    public function setAuthorized(Authorizing $auth)
    {
        $this->authorizing = $auth;
        return $this;
    }

    /**
     * @param Extensional ...$extensions
     * @return static
     */
    public function setExtensions(Extensional ...$extensions)
    {
        $this->extensions = $extensions;
        return $this;
    }

    /**
     * @return Invoker
     */
    public function invoker()
    {
        return $this->invoker;
    }

    /**
     * @return Authorizing
     */
    public function authorizer()
    {
        return $this->authorizing;
    }

    /**
     * @return Extensional[]
     */
    public function extensions()
    {
        return $this->extensions;
    }
}
