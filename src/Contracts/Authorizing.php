<?php
/**
 * Authorizing api
 * User: moyo
 * Date: 27/01/2018
 * Time: 10:47 AM
 */

namespace Carno\Gateway\Client\Contracts;

interface Authorizing
{
    /**
     * @return array
     */
    public function viaHeaders();
}
