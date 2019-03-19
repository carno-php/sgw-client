<?php
/**
 * Authorized by open api
 * User: moyo
 * Date: 27/01/2018
 * Time: 11:06 AM
 */

namespace Carno\Gateway\Client\Authorized;

use Carno\Gateway\Client\Contracts\Authorizing;

class OpenAPI implements Authorizing
{
    /**
     * @var string
     */
    private $appId = null;

    /**
     * @var string
     */
    private $appSign = null;

    /**
     * OpenAPI constructor.
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSign = md5(sprintf('%s:%s', $appId, $appSecret));
    }

    /**
     * @return array
     */
    public function viaHeaders()
    {
        return [
            'X-App-Id' => $this->appId,
            'X-App-Sign' => $this->appSign,
        ];
    }
}
