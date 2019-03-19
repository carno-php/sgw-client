<?php
/**
 * Authorized by token
 * User: moyo
 * Date: 27/01/2018
 * Time: 10:45 AM
 */

namespace Carno\Gateway\Client\Authorized;

use Carno\Gateway\Client\Contracts\Authorizing;

class Token implements Authorizing
{
    /**
     * @var string
     */
    private $token = null;

    /**
     * Token constructor.
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function viaHeaders()
    {
        return ['X-Token' => $this->token];
    }
}
