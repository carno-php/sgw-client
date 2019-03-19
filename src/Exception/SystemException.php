<?php
/**
 * System exception
 * User: moyo
 * Date: 27/01/2018
 * Time: 12:08 PM
 */

namespace Carno\Gateway\Client\Exception;

use RuntimeException;

class SystemException extends RuntimeException
{
    use TraceIdOps;
}
