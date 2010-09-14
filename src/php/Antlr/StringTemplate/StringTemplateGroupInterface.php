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

namespace Antlr\StringTemplate;

/**
 * A group interface is like a group without the template implementations;
 * there are just template names/argument-lists like this:
 *
 *  interface foo;
 *  class(name,fields);
 *  method(name,args,body);
 *
 * @category  Antlr
 * @package   Antlr_StringTemplate
 * @author    Terence Parr
 * @author    Yauhen Yakimovich
 * @copyright 2003-2005 Terence Parr, 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.stringtemplate.org/
 */
class StringTemplateGroupInterface
{

    /**
     * What is the group name
     *
     * @var string $name
     */
    protected $name;
    /**
     * Maps template name to TemplateDefinition object
     *
     * @var array $templates
     */
    protected $templates = array();
    /**
     * Are we derived from another group?  Templates not found in this group
     *  will be searched for in the superGroup recursively.
     *
     * @var StringTemplateGroupInterface $superInterface
     */
    protected $superInterface = null;
    /**
     * Where to report errors.  All string templates in this group
     *  use this error handler by default.
     *
     * @var StringTemplateErrorListener $listener
     */
    protected $listener = null;

    /**
     * Constructor
     *
     * @param Reader $reader
     * @param StringTemplateErrorListener $errors
     * @param StringTemplateGroupInterface $superInterface
     *
     */
    public function __construct($reader, StringTemplateErrorListener $errors = null, StringTemplateGroupInterface $superInterface = null)
    {
        $this->listener = is_null($errors) ? new DefaultErrorListener() : $errors;
        if (!is_null($superInterface)) {
            $this->setSuperInterface($superInterface);
        }
        $this->parseInterface($reader);
    }

    /**
     * Get super interface
     *
     * @return StringTemplateGroupInterface
     */
    public function getSuperInterface()
    {
        return $this->superInterface;
    }

    /**
     * Set super interface
     */
    public function setSuperInterface(StringTemplateGroupInterface $superInterface)
    {
        $this->superInterface->$superInterface;
    }

    /**
     * Parse reader
     *
     * @param $reader
     * @return void
     */
    protected function parseInterface($reader)
    {
        try {
            $lexer = new Language\InterfaceLexer($reader);
            $parser = new Language\InterfaceParser($lexer);
            $parser->groupInterface($this);
        } catch (Exception $exception) {
            $name = "<unknown>";
            if ($this->getName() != null) {
                $name = $this->getName();
            }
            $this->error(
                "problem parsing group " + $this->name + ": " + $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * Define template
     *
     * @param  string  $name       template name
     * @param  array   $formalArgs formal arguments
     * @param  boolean $optional   true if template is optional
     * @return void
     */
    public function defineTemplate($name, $formalArgs, $optional)
    {
        $templateDefinition = new TemplateDefinition($name, $formalArgs, $optional);
        $this->templates[$name] = $templateDefinition;
    }

    /** Return a list of all template names missing from group that are defined
     *  in this interface.  Return null if all is well.
     *
     * @param StringTemplateGroup $group
     * @return array|null
     */
    public function getMissingTemplates(StringTemplateGroup $group)
    {
        $missing = array();
        foreach ($this->templates as $name => $templateDefinition) {
            if (!$templateDefinition->optional && !$group->isDefined($name)) {
                $missing[] = $name;
            }
        }
        if (count($missing)) {
            return null;
        }

        return $missing;
    }

    /** Return a list of all template sigs that are present in the group, but
     *  that have wrong formal argument lists.  Return null if all is well.
     *
     * @param StringTemplateGroup $group
     * @return array|null
     */
    public function getMismatchedTemplates(StringTemplateGroup $group)
    {
        $mismatched = array();
        foreach ($this->templates as $name => $templateDefinition) {
            if ($group->isDefined($name)) {
                $definedStringTemplate = $group->getTemplateDefinition($name);
                $formalArgs = $definedStringTemplate . getFormalArguments();
                $acknowledgement = false;
                if (($templateDefinition->formalArgs != null && $formalArgs == null)
                    || ($definedStringTemplate->formalArgs == null && $formalArgs != null)
                    || count($definedStringTemplate->formalArgs) != count($formalArgs)) {
                    $acknowledgement = true;
                }
                if (!$acknowledgement) {
                    foreach ($formalArgs as $argumentName => $argument) {
                        if ($definedStringTemplate->formalArgs[$argumentName] == null) {
                            $acknowledgement = true;
                            break;
                        }
                    }
                }
                if ($acknowledgement) {
                    $mismatched[] = $this->getTemplateSignature($templateDefinition);
                }
            }
        }
        if (!count($mismatched)) {
            return null;
        }

        return $mismatched;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function error($message, Exception $exception = null)
    {
        if ($this->listener) {
            $this->listener->error($message, $exception);
        } else {
            echo "StringTemplate: " . $message;
            if ($exception != null) {
                $exception->getTraceAsString();
            }
        }
    }

    /**
     * To string casting method
     *
     * @return string
     */
    public function __toString()
    {
        $result = "interface " . $this->getName() . ";\n";
        foreach ($this->templates as $name => $templateDefinition) {
            $result = $this->getTemplateSignature($templateDefinition) . ";\n";
        }
        return $result;
    }

    /**
     * Get template signature
     *
     * @param TemplateDefinition templateDefinition
     * @return string
     */
    protected function getTemplateSignature(TemplateDefinition $templateDefinition)
    {
        $result = '';
        if ($templateDefinition->optional) {
            $result .= "optional ";
        }
        $result .= $templateDefinition->name;
        if ($templateDefinition->formalArgs != null) {
            $arguments = '';
            $arguments .= '(';
            $i = 1;
            foreach ($templateDefinition->formalArgs as $argumentName => $argument) {
                if ($i > 1) {
                    $arguments .= ", ";
                }
                $arguments .= $argumentName;
                $i++;
            }
            $arguments .= ')';
            $result .= $arguments;
        } else {
            $result .= '()';
        }
        return $result;
    }

}
