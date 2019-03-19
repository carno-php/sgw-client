<?php
/**
 * Plugined API
 * User: moyo
 * Date: 2018/7/4
 * Time: 10:59 AM
 */

namespace Carno\Gateway\Client\Contracts;

use Carno\Gateway\Client\Context;

interface Extensional
{
    /**
     * @param Context $ctx
     * @param array $current
     * @return array
     */
    public function parseHeaders(Context $ctx, array $current);
}
