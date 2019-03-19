<?php
/**
 * Context ops
 * User: moyo
 * Date: 2018/7/4
 * Time: 11:02 AM
 */

namespace Carno\Gateway\Client;

use ArrayObject;

class Context extends ArrayObject
{
    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->has($key) ? $this->offsetGet($key) : null;
    }

    /**
     * @param string $key
     * @param mixed $val
     * @return static
     */
    public function set($key, $val)
    {
        $this->offsetSet($key, $val);
        return $this;
    }
}
