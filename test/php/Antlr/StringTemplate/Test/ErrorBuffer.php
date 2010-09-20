<?php
/*
 * [The "BSD licence"]
 * Copyright (c) 2003-2005 Terence Parr, 2010 Yauhen Yakimovich
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
 * @package   Antlr_StringTemplate
 * @author    Terence Parr
 * @author    Yauhen Yakimovich
 * @copyright 2003-2005 Terence Parr, 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.stringtemplate.org/
 */

namespace Antlr\StringTemplate\Test;

use Antlr\StringTemplate\StringTemplateErrorListener;
use Antlr\Util\StringBuffer;
use Exception;

/**
 * Object oriented abstraction of a string buffer as a collection of
 * string-castable items
 *
 * @category  Antlr
 * @package   Antlr_StringTemplate
 * @author    Yauhen Yakimovich
 * @copyright 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.antlr.org/
 */
class ErrorBuffer implements StringTemplateErrorListener {

    /**
     * Inner buffer
     *
     * @var StringBuffer
     */
    private $errorOutput = null;

    /**
     * Consume error
     *
     * @param string    $text
     * @param Exception $exception
     *
     * @return void
     */
    public function error($text, Exception $exception = null) {
        if (!is_null($this->errorOutput)) {
            $this->errorOutput->append("\n");
        } else {
            $this->errorOutput = new StringBuffer(500);
        }
        $this->errorOutput->append($text);
        if ($exception != null) {
            $this->errorOutput->append($exception->getMessage());
        }
    }

    /**
     * Consume warning
     *
     * @param string $text
     *
     * @return void
     */
    public function warning($text) {
        $this->errorOutput->append($text);
    }

    /**
     * Return string representation
     *
     * @return string
     */
    public function toString() {
        return $this->errorOutput->toString();
    }

    /**
     * Magical alias for toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
?>
