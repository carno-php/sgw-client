<?php
/**
 * Exception with trace ops
 * User: moyo
 * Date: 27/01/2018
 * Time: 12:11 PM
 */

namespace Carno\Gateway\Client\Exception;

trait TraceIdOps
{
    /**
     * @var string
     */
    private $traceId = null;

    /**
     * @param $traceId
     * @return static
     */
    public function setTraceId($traceId)
    {
        $this->traceId = $traceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTraceId()
    {
        return $this->traceId;
    }
}
