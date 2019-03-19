<?php
/**
 * Global endpoint assigned
 * User: moyo
 * Date: 09/02/2018
 * Time: 12:37 PM
 */

namespace Carno\Gateway\Client\Traits;

use Carno\Gateway\Client\Endpoint;

trait GlobalEP
{
    /**
     * @var Endpoint
     */
    private static $endpoint = null;

    /**
     * @return Endpoint
     */
    public static function assigned()
    {
        return self::$endpoint;
    }

    /**
     * @param Endpoint $endpoint
     */
    public static function assigning(Endpoint $endpoint)
    {
        self::$endpoint = $endpoint;
    }
}
