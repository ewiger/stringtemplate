<?php
/*
 * [The "BSD licence"]
 * Copyright 2010 Yauhen Yakimovich
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
 * IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 * NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Antlr
 * @package   Antlr_Util
 * @author    Yauhen Yakimovich
 * @copyright 2003-2005 Terence Parr, 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.stringtemplate.org/
 */

namespace Antlr\Util;

/**
 * Object oriented abstraction of array
 *
 * @category  Antlr
 * @package   Antlr_Util
 * @author    Yauhen Yakimovich
 * @copyright 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.antlr.org/
 */
class ArrayList implements \ArrayAccess, \Iterator, \Countable
{
    /**
     * Inner container
     *
     * @var array
     */
    private $container = array();

    /**
     * Constructor
     *
     * @param array $data optional initial data
     *
     * @return void
     */
    public function __construct(array $data = null) 
    {
        if ($data != null && is_array($data)) {
            $this->container = $data;
        }
    }

    /**
     * Set at offset
     *
     * @param int    $offset
     * @param <mixed $value
     *
     * @return void
     * @throws Exception
     */
    public function offsetSet($offset, $value) {
         if ($value instanceof ArrayList){
            if ($offset == "") {
                $this->container[] = $value;
            }else {
                $this->container[$offset] = $value;
            }
        } else {
            throw new Exception("Value have to be a instance of the Model ColorModel");
        }
    }

    /**
     * Check if element at offset exists
     *
     * @param int $offset
     *
     * @return boolean true if so
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Unset by offset
     *
     * @param int $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Get by offset
     *
     * @param int $offset
     *
     * @return null|mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Reset cursor
     *
     * @return void
     */
    public function rewind()
    {
        reset($this->container);
    }

    /**
     * Obtain current value
     *
     * @return mixed value
     */
    public function current()
    {
        return current($this->container);
    }

    /**
     * Obtain current key
     *
     * @return mixed key
     */
    public function key()
    {
        return key($this->container);
    }

    /**
     * Obtain next element
     *
     * @return mixed
     */
    public function next()
    {
        return next($this->container);
    }

    /**
     * Is valid?
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->current() !== false;
    }

    /**
     * Obtain count
     *
     * @return int count of elements
     */
    public function count()
    {
     return count($this->container);
    }

    /**
     * Obtain a copy as array
     *
     * @return array
     */
    public function asArray()
    {
        return clone($this->container);
    }

    /**
     * Obtain keys
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->container);
    }
}
