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

use Antlr\StringTemplate\StringTemplateGroup;
use Antlr\StringTemplate\StringTemplateGroupInterface;
use Antlr\Util\FileReader;
use Antlr\Util\StringReader;

/**
 * StringTemplate unit tests
 *
 * @category  Antlr
 * @package   Antlr_StringTemplate
 * @author    Terence Parr
 * @author    Yauhen Yakimovich
 * @copyright 2003-2005 Terence Parr, 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.stringtemplate.org/
 */
class TestStringTemplate extends \PHPUnit_Framework_TestCase
{
    const NEWLINE = PHP_EOL;

    const TEMP_DIR = '/tmp';

    /**
     * Test interface file format
     *
     * @throws Exception
     * @return void
     */
    public function testInterfaceFileFormat()
    {
        $groupInterface =
            "interface test;" . self::NEWLINE .
            "t();" . self::NEWLINE .
            "bold(item);" . self::NEWLINE .
            "optional duh(a,b,c);" . self::NEWLINE;
        $reader = new StringReader($groupInterface);
        $stringTemplateGroupInterface = new StringTemplateGroupInterface($reader);

        $expecting =
            "interface test;\n" .
            "t();\n" .
            "bold(item);\n" .
            "optional duh(a, b, c);\n";
        $this->assertEquals($expecting, $stringTemplateGroupInterface . toString());
    }

    /**
     * Test no group loader case
     *
     * @throws Exception
     * @return void
     */
    public function testNoGroupLoader()
    {
        // this also tests the group loader
        /* @var StringTemplateErrorListener $errors */
        $errors = new ErrorBuffer();
        $tmpdir = self::TEMP_DIR;

        $templates =
            "group testG implements blort;" . self::NEWLINE .
            "t() ::= <<foo>>" . self::NEWLINE .
            "bold(item) ::= <<foo>>" . self::NEWLINE .
            "duh(a,b,c) ::= <<foo>>" . self::NEWLINE;

        self::writeFile($tmpdir, "testG.stg", $templates);

        $reader = new FileReader($tmpdir . "/testG.stg");
        StringTemplateGroup::groupFactory($reader, $errors);

        $expecting = "no group loader registered";
        $this->assertEquals($expecting, $errors . toString());
    }

    /**
     * Write content to a file
     *
     * @param string $directory path
     * @param string $fileName  filename
     * @param string $content   data
     */
    public static function writeFile($directory, $fileName, $content)
    {
        \file_put_contents($directory . \DIRECTORY_SEPARATOR . $fileName, $content);
    }

}
