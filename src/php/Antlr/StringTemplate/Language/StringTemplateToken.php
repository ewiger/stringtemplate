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
namespace Antlr\StringTemplate\Language;

use Antlr\Runtime\CommonToken;
use Antlr\Util\ArrayList;

/**
 * String template token
 */
class StringTemplateToken extends CommonToken
{
	/** Track any args for anonymous templates like
	 *  <tokens,rules:{t,r | <t> then <r>}>
	 *  The lexer in action.g returns a single token ANONYMOUS_TEMPLATE
	 *  and so I need to have it parse args in the lexer and make them
	 *  available for when I build the anonymous template.
     *
     * @var ArrayList
	 */
    public $args = null;

    /**
     * Constructor
     *
     * @param int             $type
     * @param string          $text
     * @param array|ArrayList $args
     *
     * @return void
     */
    public function __constructor($type=0, $text='', $args=null)
    {
		parent::__constructor($type, $text);
        if ($args != null) {
            $this->args = (is_array($args)) ? new ArrayList($args) : $args;
        } else {
            $this->args = new ArrayList();
        }
		$this->args = $args;
	}

    /**
     * Get as string
     *
     * @return string
     */
	public function toString()
    {
		return parent::toString() . "; args=" . implode(',', $this->args->asArray());
	}

    /**
     * Magical alias for toString
     *
     * @return String
     */
    public function __toString()
    {
        return $this->toString();
    }
}
