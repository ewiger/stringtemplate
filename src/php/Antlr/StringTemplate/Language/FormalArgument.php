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

use Antlr\StringTemplate\StringTemplate;

/** Represents the name of a formal argument
 *  defined in a template:
 *
 *  group test;
 *  test(a,b) : "$a$ $b$"
 *  t() : "blort"
 *
 *  Each template has a set of these formal arguments or uses
 *  a placeholder object: UNKNOWN (indicating that no arguments
 *  were specified such as when a template is loaded from a file.st).
 *
 *  Note: originally, I tracked cardinality as well as the name of an
 *  attribute.  I'm leaving the code here as I suspect something may come
 *  of it later.  Currently, though, cardinality is not used.
 *
 * @category  Antlr
 * @package   Antlr_StringTemplate
 * @author    Terence Parr
 * @author    Yauhen Yakimovich
 * @copyright 2003-2005 Terence Parr, 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.stringtemplate.org/
 */
class FormalArgument {
    // the following represent bit positions emulating a cardinality bitset.
    const OPTIONAL = 1;     // a?
    const REQUIRED = 2;     // a
    const ZERO_OR_MORE = 4; // a*
    const ONE_OR_MORE = 8;  // a+

    static public $suffixes = array(
        null,
        "?",
        "",
        null,
        "*",
        null,
        null,
        null,
        "+"
    );

    /** When template arguments are not available such as when the user
     *  uses "new StringTemplate(...)", then the list of formal arguments
     *  must be distinguished from the case where a template can specify
     *  args and there just aren't any such as the t() template above.
     */
    //static public $UNKNOWN = array();
    const UNKNOWN = 16;

    /**
     * @var string
     */
    public $name;
    //protected int cardinality = REQUIRED;

	/** If they specified name="value", store the template here
     * @var StringTemplate
     */
	public $defaultValueST;

	public function FormalArgument($name, $defaultValueST = null) {
		$this->name = $name;
        if ($defaultValueST) {
            $this->defaultValueST = $defaultValueST;
        }
	}

    public static function getCardinalityName($cardinality) {
        switch (cardinality) {
            case self::OPTIONAL : return "optional";
            case self::REQUIRED : return "exactly one";
            case self::ZERO_OR_MORE : return "zero-or-more";
            case self::ONE_OR_MORE : return "one-or-more";
            default : return "unknown";
        }
    }

	public function equals($object) {
		if ( $object==null || !($object instanceof FormalArgument) ) {
			return false;
		}		
		if ( !$this->name->equals($object->name) ) {
			return false;
		}
		// only check if there is a default value; that's all
		if ( ($this->defaultValueST!=null && $object->defaultValueST==null) ||
			 ($this->defaultValueST==null && $object->defaultValueST!=null) ) {
			return false;
		}
		return true;
	}

    public function toString() {
		if ( $this->defaultValueST!=null ) {
			return $this->name . "=" . $this->defaultValueST;
		}
        return $this->name;
    }
}
