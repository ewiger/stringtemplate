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
 * StringReader implements Reader interface and works with strings
 *
 * @category  Antlr
 * @package   Antlr_Util
 * @author    Yauhen Yakimovich
 * @copyright 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.antlr.org/
 */
class StringReader implements Reader
{
    protected $separator = PHP_EOL;

    protected $position = 0;

    protected $data = array();

    /**
     * Constructor
     *
     * @param string|array $data      data string or array of strings
     * @param string|array $separator separator string, 'end of line' by default
     * @return void
     */
    public function __construct($data, $separator=null)
    {
        $this->position = 0;
        if ($separator != null) {
            $this->separator = $separator;
        }
        if (is_array($data)) {
            $this->data = $data;
        } else {
            $this->data = explode($this->separator, $data);
        }
    }

    /**
     * Reset sequence position
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Returns current element
     *
     * @return string current element
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * Returns key
     *
     * @return int position
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Next advances the sequence position
     *
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Valid
     *
     * @return boolean true if valid
     */
    public function valid()
    {
        return isset($this->data[$this->position]);
    }
}
