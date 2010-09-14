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

use Antlr\Util\Reader;
use Antlr\Util\StringBuffer;
use Antlr\StringTemplate\Language\StringTemplateAST;

/**
 *  Manages a group of named mutually-referential StringTemplate objects.
 *  Currently the templates must all live under a directory so that you
 *  can reference them as foo.st or gutter/header.st.  To refresh a
 *  group of templates, just create a new StringTemplateGroup and start
 *  pulling templates from there.  Or, set the refresh interval.
 *
 *  Use getInstanceOf(template-name) to get a string template
 *  to fill in.
 *
 *  The name of a template is the file name minus ".st" ending if present
 *  unless you name it as you load it.
 *
 *  You can use the group file format also to define a group of templates
 *  (this works better for code gen than for html page gen).  You must give
 *  a Reader to the ctor for it to load the group; this is general and
 *  distinguishes it from the ctors for the old-style "load template files
 *  from the disk".
 *
 *  StringTemplateGroupLoader concept was added so people can define supergroups
 *  within a group and have it load that group automatically.
 *
 * @category  Antlr
 * @package   Antlr_StringTemplate
 * @author    Terence Parr
 * @author    Yauhen Yakimovich
 * @copyright 2003-2005 Terence Parr, 2010 Yauhen Yakimovich
 * @license   http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link      http://www.stringtemplate.org/
 */
class StringTemplate {
    /**
     * String Template version
     *
     * @var string
     */
    const VERSION = "3.2.1-php"; // May 30, 2010

    /**
     * <@r()>
     *
     * @var int
     */
    const REGION_IMPLICIT = 1;

    /**
     * <@r>...<@end>
     *
     * @var int
     */
    const REGION_EMBEDDED = 2;

    /**
     * @t.r() ::= "..." defined manually by coder
     *
     * @var int
     */
    const REGION_EXPLICIT = 3;

    /**
     * Anonymous string template name
     *
     * @var string
     */
    const ANONYMOUS_ST_NAME = "anonymous";

    /**
     * Track probable issues like setting attribute that is not referenced.
     *
     * @var boolean
     */
    public static $lintMode = false;

    /**
     * Referenced attributes
     *
     * @var array
     */
    protected $referencedAttributes = null;

    /**
     * What's the name of this template?
     *
     * @var string
     */
    protected $name = self::ANONYMOUS_ST_NAME;

    /**
     * Template counter
     *
     * @var int
     */
    private static $templateCounter=0;

    /**
     * Get template counter and increment it
     *
     * @return int
     */
    private static function getNextTemplateCounter()
    {
        return $this->templateCounter++;
    }

    /**
     * Reset the template ID counter to 0; public so that testing routine
     * can access but not really of interest to the user.
     *
     * @return StringTemplate
     */
    public static function resetTemplateCounter()
    {
        $this->templateCounter = 0;

        return $this;
    }

    /**
     * Template ID
     *
     * @var int
     */
    protected $templateID;

    /**
     * Enclosing instance if I'm embedded within another template.
     * IF-subtemplates are considered embedded as well.
     *
     * @var StringTemplate
     */
    protected $enclosingInstance = null;

    /**
     * If this template is an embedded template such as when you apply
     * a template to an attribute, then the arguments passed to this
     * template represent the argument context--a set of values
     * computed by walking the argument assignment list.  For example,
     * <name:bold(item=name, foo="x")> would result in an
     * argument context of {[item=name], [foo="x"]} for this
     * template.  This template would be the bold() template and
     * the enclosingInstance would point at the template that held
     * that <name:bold(...)> template call.  When you want to get
     * an attribute value, you first check the attributes for the
     * 'self' template then the arg context then the enclosingInstance
     * like resolving variables in pascal-like language with nested
     * procedures.
     *
     * With multi-valued attributes such as <faqList:briefFAQDisplay()>
     * attribute "i" is set to 1..n.
     *
     * @var array
     */
    protected $argumentContext = null;

    /**
     * If this template is embedded in another template, the arguments
     * must be evaluated just before each application when applying
     * template to a list of values.  The "it" attribute must change
     * with each application so that $names:bold(item=it)$ works.  If
     * you evaluate once before starting the application loop then it
     * has a single fixed value.  Eval.g saves the AST rather than evaluating
     * before invoking applyListOfAlternatingTemplates().  Each iteration
     * of a template application to a multi-valued attribute, these args
     * are re-evaluated with an initial context of {[it=...], [i=...]}.
     *
     * @var StringTemplateAST
     */
    protected $argumentsAST = null;

    /**
     * When templates are defined in a group file format, the attribute
     * list is provided including information about attribute cardinality
     * such as present, optional, ...  When this information is available,
     * rawSetAttribute should do a quick existence check as should the
     * invocation of other templates.  So if you ref bold(item="foo") but
     * item is not defined in bold(), then an exception should be thrown.
     * When actually rendering the template, the cardinality is checked.
     * This is a Map<String,FormalArgument>.
     *
     * @var array
     */
    protected $formalArguments = FormalArgument::UNKNOWN;

    /**
     * How many formal arguments to this template have default values
     * specified?
     *
     * @var int
     */
    protected $numberOfDefaultArgumentValues = 0;

    /**
     * Normally, formal parameters hide any attributes inherited from the
     * enclosing template with the same name.  This is normally what you
     * want, but makes it hard to invoke another template passing in all
     * the data.  Use notation now: <otherTemplate(...)> to say "pass in
     * all data".  Works great.  Can also say <otherTemplate(foo="xxx",...)>
     *
     * @var boolean
     */
    protected $passThroughAttributes = false;

    /**
     * What group originally defined the prototype for this template?
     * This affects the set of templates I can refer to.  super.t() must
     * always refer to the super of the original group.
     *
     * group base;
     * t ::= "base";
     *
     * group sub;
     * t ::= "super.t()2"
     *
     * group subsub;
     * t ::= "super.t()3"
     *
     * @var StringTemplateGroup
     */
    protected $nativeGroup;

    /**
     * This template was created as part of what group?  Even if this
     * template was created from a prototype in a supergroup, its group
     * will be the subgroup.  That's the way polymorphism works.
     *
     * @var StringTemplateGroup
     */
    protected $group;


    /**
     * If this template is defined within a group file, what line number? 
     * 
     * @var int
     */
    protected $groupFileLine;

    /**
     * Where to report errors 
     * 
     * @var StringTemplateErrorListener
     */
     private $listener = null;

    /**
     * The original, immutable pattern/language (not really used again after
     * initial "compilation", setup/parsing).
     *
     * @var string
     */
    protected $pattern;

    /**
     * Map an attribute name to its value(s).  These values are set by outside
     *  code via st.setAttribute(name, value).  StringTemplate is like self in
     *  that a template is both the "class def" and "instance".  When you
     *  create a StringTemplate or setTemplate, the text is broken up into chunks
     *  (i.e., compiled down into a series of chunks that can be evaluated later).
     *  You can have multiple
     *
     * @var StringTemplateAttributes
     */
    protected $attributes;

    /**
     * A Map<Class,Object> that allows people to register a renderer for
     *  a particular kind of object to be displayed in this template.  This
     *  overrides any renderer set for this template's group.
     *
     *  Most of the time this map is not used because the StringTemplateGroup
     *  has the general renderer map for all templates in that group.
     *  Sometimes though you want to override the group's renderers.
     *
     * @var array
     */
    protected $attributeRenderers;

    /**
     * A list of alternating string and ASTExpr references.
     *  This is compiled to when the template is loaded/defined and walked to
     *  write out a template instance.
     *
     * @var array
     */
    protected $chunks;

    /**
     * If someone refs <@r()> in template t, an implicit
     *
     *   @t.r() ::= ""
     *
     *  is defined, but you can overwrite this def by defining your
     *  own.  We need to prevent more than one manual def though.  Between
     *  this var and isEmbeddedRegion we can determine these cases.
     *
     * @var int
     */
    protected $regionDefType;

    /** Does this template come from a <@region>...<@end> embedded in
     *  another template?
     *
     * @var boolean
     */
    protected $isRegion;

    /**
     * Set of implicit and embedded regions for this template
     *
     * @var array
     */
    protected $regions;


    /**
     * Default group
     *
     * @var StringTemplateGroup
     */
    public static $defaultGroup;

    /**
     * Constructor
     *
     * @param string              $template
     * @param string              $lexerClassName
     * @param StringTemplateGroup $group
     * @param array               $attributes
     */
    public function __construct($template = '',
                          $lexerClassName = '',
                          StringTemplateGroup $group = null,
                          StringTemplateAttributes $attributes = null)
    {
        if ($group != null) {
            $this->setGroup($group);
        } else {
            if ($group != null) {
                $this->setGroup(new StringTemplateGroup("defaultGroup", $lexerClassName));
            } else {
                $this->group = self::$defaultGroup; // make sure has a group even if default
            }
        }
        $this->setTemplate($template);
        $this->attributes = (is_null($attributes)) ? new StringTemplateAttributes() : $attributes;

        $this->templateID = self::getNextTemplateCounter();
    }

    /**
     * Make the 'to' template look exactly like the 'from' template
     *  except for the attributes.  This is like creating an instance
     *  of a class in that the executable code is the same (the template
     *  chunks), but the instance data is blank (the attributes).  Do
     *  not copy the enclosingInstance pointer since you will want this
     *  template to eval in a context different from the examplar.
     *
     * @param StringTemplate $from
     * @param StringTemplate $to
     *
     * @return void
     */
    protected function dup(StringTemplate $from, StringTemplate $to) {
        $to->attributeRenderers = $from->attributeRenderers;
        $to->pattern = $from->pattern;
        $to->chunks = $from->chunks;
        $to->formalArguments = $from->formalArguments;
        $to->numberOfDefaultArgumentValues = $from->numberOfDefaultArgumentValues;
        $to->name = $from->name;
        $to->group = $from->group;
        $to->nativeGroup = $from->nativeGroup;
        $to->listener = $from->listener;
        $to->regions = $from->regions;
        $to->isRegion = $from->isRegion;
        $to->regionDefType = $from->regionDefType;
    }

    /**
     * Make an instance of this template; it contains an exact copy of
     *  everything (except the attributes and enclosing instance pointer).
     *  So the new template refers to the previously compiled chunks of this
     *  template but does not have any attribute values.
     *
     * @return StringTemplate
     */
    public function getInstanceOf() {
        $stringTemplate = null;
        if ( $this->nativeGroup!=null ) {
            // create a template using the native group for this template
            // but it's "group" is set to $this->group by dup after creation so
            // polymorphism still works.
            $stringTemplate = $this->nativeGroup->createStringTemplate();
        } else {
            $stringTemplate = $this->group->createStringTemplate();
        }
        $this->dup($this, $stringTemplate);
        
        return $stringTemplate;
    }

    /***
     *
     * @return StringTemplate
     */
    public function getEnclosingInstance() {
        return $this->enclosingInstance;
    }

    /**
     * 
     * @return StringTemplate
     */
    public function getOutermostEnclosingInstance()
    {
        if ( $this->enclosingInstance!=null ) {
            return $this->enclosingInstance->getOutermostEnclosingInstance();
        }
        
        return $this;
    }

    /**
     * Set enclosing template
     *
     * @param StringTemplate $enclosingInstance
     *
     * @return StringTemplate
     */
    public function setEnclosingInstance(StringTemplate $enclosingInstance)
    {
        if ( $this == $enclosingInstance ) {
            throw new Exception("cannot embed template ". $this->getName() . " in itself");
        }
        // set the parent for this template
        $this->enclosingInstance = $enclosingInstance;

        return $this;
    }

    /**
     * Get arguments context
     *
     * @return array
     */
    public function getArgumentContext()
    {
        return $this->argumentContext;
    }

    /**
     * Set argument context
     * 
     * @param array $argumentContext
     *
     * @return StringTemplate
     */
    public function setArgumentContext($argumentContext) {
        $this->argumentContext = $argumentContext;

        return $this;
    }

    /**
     * Get argument AST
     * 
     * @return StringTemplateAST
     */
    public function getArgumentsAST()
    {
        return $this->argumentsAST;
    }

    public function setArgumentsAST(StringTemplateAST $argumentsAST)
    {
        $this->argumentsAST = $argumentsAST;
    }

    public function  getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOutermostName() {
        if (  $this-> enclosingInstance!=null ) {
            return $this->enclosingInstance->getOutermostName();
        }
        
        return $this->getName();
    }

    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return StringTemplateGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup(StringTemplateGroup $group)
    {
        $this->group = $group;
    }

    /**
     * @return StringTemplateGroup
     */
    public function NativeGroup()
    {
        return $this->nativeGroup;
    }

    public function setNativeGroup(StringTemplateGroup $nativeGroup)
    {
        $this->nativeGroup = $nativeGroup;
    }

    /**
     * Return the outermost template's group file line number
     *
     * @return int
     */
    public function getGroupFileLine() {
        if ( $this->enclosingInstance!=null ) {
            return $this->enclosingInstance->getGroupFileLine();
        }

        return $this->groupFileLine;
    }

    public function setGroupFileLine($groupFileLine) {
        $this->groupFileLine = $groupFileLine;
    }

    public function setTemplate(String $template) {
        $this->pattern = $template;
        $this->breakTemplateIntoChunks();
    }

    /**
     * @return string
     */
    public function getTemplate() {
        return $this->pattern;
    }

    public function setErrorListener(StringTemplateErrorListener $listener) {
        $this->listener = $listener;
    }

    /**
     * @return StringTemplateErrorListener
     */
    public function getErrorListener() {
        if ( $this->listener==null ) {
            return $this->group->getErrorListener();
        }
        return $this->listener;
    }

    public function reset() {
        $this->attributes = new StringTemplateAttributes(); // just throw out table and make new one
    }

    public function setPredefinedAttributes() {
        if ( !$this->inLintMode() ) {
            return; // only do this method so far in lint mode
        }
    }

    public function removeAttribute($name) {
        if ( $this->attributes!=null ) {
            unset($this->attributes[$name]);
        }
    }

    /** Set an attribute for this template.  If you set the same
     *  attribute more than once, you get a multi-valued attribute.
     *  If you send in a StringTemplate object as a value, it's
     *  enclosing instance (where it will inherit values from) is
     *  set to 'this'.  This would be the normal case, though you
     *  can set it back to null after this call if you want.
     *  If you send in a List plus other values to the same
     *  attribute, they all get flattened into one List of values.
     *  This will be a new list object so that incoming objects are
     *  not altered.
     *  If you send in an array, it is converted to an ArrayIterator.
     *
     * @param string $name
     * @param object $value
     *
     * @return void
     */
    public function setAttribute($name, $value) {
        if ( $value==null || $name==null ) {
            return;
        }
        if ( strpos('.', $name) >= 0 ) {
            throw new Exception("cannot have '.' in attribute names");
        }
        if ( $this->attributes==null ) {
            $this->attributes = new StringTemplateAttributes();
        }

        if ( $value instanceof StringTemplate ) {
            $value->setEnclosingInstance($this);
        } else {
            // convert value if array
            $value = ASTExpr::convertArrayToList($value);
        }

        // convert plain collections
        // get exactly in this scope (no enclosing)
        $o = $this->attributes[$name];
        if ( $o==null ) { // new attribute
            $this->rawSetAttribute($this->attributes, $name, $value);
            return;
        }
        // it will be a multi-value attribute
        //System.out.println("exists: "+name+"="+o);
        /* @var StringTemplateAttributes $v */
        $v = null;
        if ( $o instanceof StringTemplateAttributes) { // already a list made by ST
            $v = $o;
        } else if ( is_array($o) ) { // existing attribute is non-ST List
            // must copy to an ST-managed list before adding new attribute
            $v = StringTemplateAttributes($o);
            $this->rawSetAttribute($this->attributes, $name, $v); // replace attribute w/list
        }
        else {
            // non-list second attribute, must convert existing to ArrayList
            $v = new StringTemplateAttributes(); // make list to hold multiple values
            // make it point to list now
            $this->rawSetAttribute($this->attributes, $name, $v); // replace attribute w/list
            $v[] = $o;  // add previous single-valued attribute
        }
        if ( is_array($value) ) {
            // flatten incoming list into existing
            if ( $v != $value ) { // avoid weird cyclic add
                //TODO: array_merge
                //v.addAll((List)value);
            }
        }
        else {
            $v[] = $value;
        }
    }

    /** Create an aggregate from the list of properties in aggrSpec and fill
     *  with values from values array.  This is not publically visible because
     *  it conflicts semantically with setAttribute("foo",new Object[] {...});
     */

    /** Split "aggrName.{propName1,propName2}" into list [propName1,propName2]
     *  and the aggrName. Space is allowed around ','.
     */
    /*protected String parseAggregateAttributeSpec(String aggrSpec, List properties) {
        int dot = aggrSpec.indexOf('.');
        if ( dot<=0 ) {
            throw new IllegalArgumentException("invalid aggregate attribute format: "+
                    aggrSpec);
        }
        String aggrName = aggrSpec.substring(0, dot);
        String propString = aggrSpec.substring(dot+1, aggrSpec.length());
        boolean error = true;
        StringTokenizer tokenizer = new StringTokenizer(propString, "{,}", true);
        match:
        if ( tokenizer.hasMoreTokens() ) {
            String token = tokenizer.nextToken(); // advance to {
            token = token.trim();
            if ( token.equals("{") ) {
                token = tokenizer.nextToken();    // advance to first prop name
                token = token.trim();
                properties.add(token);
                token = tokenizer.nextToken();    // advance to a comma
                token = token.trim();
                while ( token.equals(",") ) {
                    token = tokenizer.nextToken();    // advance to a prop name
                    token = token.trim();
                    properties.add(token);
                    token = tokenizer.nextToken();    // advance to a "," or "}"
                    token = token.trim();
                }
                if ( token.equals("}") ) {
                    error = false;
                }
            }
        }
        if ( error ) {
            throw new IllegalArgumentException("invalid aggregate attribute format: "+
                    aggrSpec);
        }
        return aggrName;
    }*/

    /** Map a value to a named attribute.  Throw NoSuchElementException if
     *  the named attribute is not formally defined in self's specific template
     *  and a formal argument list exists.
     */
    /*protected function rawSetAttribute($attributes,
                                   $name,
                                   $value)
    {
        if ( formalArguments!=FormalArgument.UNKNOWN &&
            getFormalArgument(name)==null )
        {
            // a normal call to setAttribute with unknown attribute
            throw new NoSuchElementException("no such attribute: "+name+
                                             " in template context "+
                                             getEnclosingInstanceStackString());
        }
        if ( value == null ) {
            return;
        }
        attributes.put(name, value);
    }*/

    /** Argument evaluation such as foo(x=y), x must
     *  be checked against foo's argument list not this's (which is
      *  the enclosing context).  So far, only eval.g uses arg self as
     *  something other than "this".
     */
    public function rawSetArgumentAttribute(StringTemplate $embedded,
                                        $attributes,
                                        $name,
                                        $value)
    {
        if ( $embedded->formalArguments!=FormalArgument::$UNKNOWN &&
             $embedded->getFormalArgument($name)==null )
        {
            throw new Exception("template " . $embedded->getName() .
                                             " has no such attribute: " . $name .
                                             " in template context " .
                                             $this->getEnclosingInstanceStackString());
        }
        if ( $value == null ) {
            return;
        }
        $this->attributes[$name] = $value;
    }

    public function getAttribute($name) {
        $value = $this->get($this, $name);
        if ( $value == null ) {
            $this->checkNullAttributeAgainstFormalArguments($this, $name);
        }
        return $value;
    }

    /**
     * Walk the chunks, asking them to write themselves out according
     *  to attribute values of '$this->attributes'.  This is like evaluating or
     *  interpreting the StringTemplate as a program using the
     *  attributes.  The chunks will be identical (point at same list)
     *  for all instances of this template.
     *
     * @return int
     * @throws Exception
     */
    public function write(StringTemplateWriter $out)
    {
        if ( $this->group->debugTemplateOutput ) {
            $this->group->emitTemplateStartDebugString($this, $out);
        }
        $n = 0;
        $missing = true;
        $this->setPredefinedAttributes();
        $this->setDefaultArgumentValues();
        for ($i=0; $this->chunks!=null && $i<count($this->chunks); $i++) {
            /* @var Expr $a */
            $a = $this->chunks[$i];
            $chunkN = $a->write($this, $out);
            // expr-on-first-line-with-no-output NEWLINE => NEWLINE
            if ( $chunkN <= 0 && $i==0 && ($i+1) < count($this->chunks) &&
                 $this->chunks[$i+1] instanceof NewlineRef )
            {
                //System.out.println("found pure first-line-blank \\n pattern");
                $i++; // skip next NEWLINE;
                continue;
            }
            // NEWLINE expr-with-no-output NEWLINE => NEWLINE
            // Indented $...$ have the indent stored with the ASTExpr
            // so the indent does not come out as a StringRef
            if ( $chunkN<=0 &&
                ($i-1)>=0 && $this->chunks[$i-1] instanceof NewlineRef &&
                ($i+1) < count($this->chunks) && ($this->chunks[$i+1] instanceof NewlineRef) )
            {
                //System.out.println("found pure \\n blank \\n pattern");
                $i++; // make it skip over the next chunk, the NEWLINE
            }
            if ( $chunkN!=ASTExpr::$MISSING ) {
                $n += $chunkN;
                $missing = false;
            }
        }
        if ( $this->group->debugTemplateOutput ) {
            $this->group->emitTemplateStopDebugString($this, $out);
        }
        if ( $this->lintMode ) $this->checkForTrouble();
        if ( $missing && $this->chunks!=null && count($this->chunks)>0 ) return ASTExpr::$MISSING;
        return $n;
    }

    /** Resolve an attribute reference.  It can be in four possible places:
     *
     *  1. the attribute list for the current template
     *  2. if self is an embedded template, somebody invoked us possibly
     *     with arguments--check the argument context
     *  3. if self is an embedded template, the attribute list for the enclosing
     *     instance (recursively up the enclosing instance chain)
     *  4. if nothing is found in the enclosing instance chain, then it might
     *     be a map defined in the group or the its supergroup etc...
     *
     *  Attribute references are checked for validity.  If an attribute has
     *  a value, its validity was checked before template rendering.
     *  If the attribute has no value, then we must check to ensure it is a
     *  valid reference.  Somebody could reference any random value like $xyz$;
     *  formal arg checks before rendering cannot detect this--only the ref
     *  can initiate a validity check.  So, if no value, walk up the enclosed
     *  template tree again, this time checking formal parameters not
     *  attributes Map.  The formal definition must exist even if no value.
     *
     *  To avoid infinite recursion in toString(), we have another condition
     *  to check regarding attribute values.  If your template has a formal
     *  argument, foo, then foo will hide any value available from "above"
     *  in order to prevent infinite recursion.
     *
     *  This method is not static so people can override functionality.
     *
     * @return object
     */
    public function get(StringTemplate $self, $attribute) {
        /*
        System.out.println("### get("+self.getEnclosingInstanceStackString()+", "+attribute+")");
        System.out.println("attributes="+(self.attributes!=null?self.attributes.keySet().toString():"none"));
        */
        if ( $self==null ) {
            return null;
        }

        if ( $this->lintMode ) {
            $self->trackAttributeReference($attribute);
        }

        // is it here?
        $o = null;
        if ( $self->attributes!=null ) {
            $o = $self->attributes->get($attribute);
        }

        // nope, check argument context in case embedded
        if ( $o==null ) {
            /* @var $argContext array */
            $argContext = $self->getArgumentContext();
            if ( $argContext!=null ) {
                $o = $argContext[$attribute];
            }
        }

        if ( $o==null &&
             !$self->passThroughAttributes &&
             $self->getFormalArgument($attribute)!=null )
        {
            // if you've defined attribute as formal arg for this
            // template and it has no value, do not look up the
            // enclosing dynamic scopes.  This avoids potential infinite
            // recursion.
            return null;
        }

        // not locally defined, check enclosingInstance if embedded
        if ( $o==null && $self->enclosingInstance!=null ) {
            /*
            System.out.println("looking for "+getName()+"."+attribute+" in super="+
                    enclosingInstance.getName());
             */
            $valueFromEnclosing = $this->get($self->enclosingInstance, $attribute);
            /*
            if ( valueFromEnclosing==null ) {
                checkNullAttributeAgainstFormalArguments(self, attribute);
            }
            */
            $o = $valueFromEnclosing;
        }

        // not found and no enclosing instance to look at
        else if ( $o==null && $self->enclosingInstance==null ) {
            // It might be a map in the group or supergroup...
            $o = $self->group->getMap($attribute);
        }

        return $o;
    }

    /** Walk a template, breaking it into a list of
     *  chunks: Strings and actions/expressions.
     */
    protected function breakTemplateIntoChunks() {
        //System.out.println("parsing template: "+pattern);
        if ( $this->pattern==null ) {
            return;
        }
        try {
            // instead of creating a specific template lexer, use
            // an instance of the class specified by the user.
            // The default is DefaultTemplateLexer.
            // The only constraint is that you use an ANTLR lexer
            // so I can use the special ChunkToken.
            $lexerClassName = $group->getTemplateLexerClassName();
            /* @var CharScanner chunkStream */
            $chunkStream = $lexerClassName( $this, new StringReader($this->pattern));
            chunkStream.setTokenObjectClass("Antlr\Stringtemplate\Language\ChunkToken");
            /* @var TemplateParser $chunkifier */
            $chunkifier = new TemplateParser($chunkStream);

            $chunkifier->template($this);
            //System.out.println("chunks="+chunks);
        } catch (Exception $exception) {
            $ame = "<unknown>";
            $outerName = $this->getOutermostName();
            if ( $this->getName()!=null ) {
                $name = $this->getName();
            }
            if ( $outerName!=null && $name != $outerName) {
                $name = $name." nested in ".$outerName;
            }
            $this->error("problem parsing template '".name."'", $exception);
        }
    }

    /**
     *
     * @param string $action
     * 
     * @return ASTExpr
     */
    public function parseAction($action) {
        //System.out.println("parse action "+action);
        $lexer = new ActionLexer(new StringReader((string)$action));
        $parser = new ActionParser($lexer, $this);
        $parser->setASTNodeClass("Antlr\StringTemplate\Language\StringTemplateAST");
        $lexer->setTokenObjectClass("Antlr\StringTemplate\Language\StringTemplateToken");
        $a = null;
        try {
            /* @var array $options */
            $options = $parser->action();
            /* @var AST $tree */
            $tree = $parser->getAST();
            if ( $tree!=null ) {
                if ( $tree->getType() == ActionParser::$CONDITIONAL ) {
                    $a = new ConditionalExpr($this, $tree);
                }
                else {
                    $a = new ASTExpr($this, $tree, $options);
                }
            }
        } catch (RecognitionException $re) {
            $this->error("Can't parse chunk: ".$action, $re);
        } catch (TokenStreamException $tse) {
            $this->error("Can't parse chunk: ".$action, $tse);
        }
        
        return $a;
    }

    /**
     * @return int
     */
    public function getTemplateID() {
        return $this->templateID;
    }

    /**
     *
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * Get a list of the strings and subtemplates and attribute
     * refs in a template.
     *
     * @return array
     */
    public function getChunks() {
        return $this->chunks;
    }

    public function addChunk(Expr $e) {
        if ( $this->chunks==null ) {
            $this->chunks = array();
        }
        $this->chunks[] = $e;
    }

    public function setAttributes($attributes) {
        $this->attributes = new StringTemplateAttributes($attributes);
        // $this->attributes = new StringTemplateAttributes($attributes);
    }

    // F o r m a l  A r g  S t u f f

    /**
     * @return array
     */
    public function getFormalArguments() {
        return $this->formalArguments;
    }

    public function setFormalArguments($args) {
        $this->formalArguments = $args;
    }

    /** Set any default argument values that were not set by the
     *  invoking template or by setAttribute directly.  Note
     *  that the default values may be templates.  Their evaluation
     *  context is the template itself and, hence, can see attributes
     *  within the template, any arguments, and any values inherited
     *  by the template.
     *
     *  Default values are stored in the argument context rather than
     *  the template attributes table just for consistency's sake.
     */
    public function setDefaultArgumentValues() {
        //System.out.println("setDefaultArgumentValues; "+name+": argctx="+argumentContext+", n="+numberOfDefaultArgumentValues);
        if ( $this->numberOfDefaultArgumentValues==0 ) {
            return;
        }
        if ( $this->argumentContext==null ) {
            $this->argumentContext = array();
        }
        if ( $this->formalArguments != FormalArgument::$UNKNOWN ) {
            //System.out.println("formal args="+formalArguments.keySet());
            $argNames = array_keys($this->formalArguments);
            foreach ($argNames as $argName) {
                // use the default value then
                $arg = $this->formalArguments[$argName];
                if ( $arg->defaultValueST != null ) {
                    //System.out.println("default value="+arg.defaultValueST.chunks);
                    //System.out.println(getEnclosingInstanceStackString()+": get "+argName+" argctx="+argumentContext);
                    $existingValue = $this->getAttribute($argName);
                    //System.out.println("existing value="+existingValue);
                    if ( $existingValue==null ) { // value unset?
                        $defaultValue = $arg->defaultValueST;
                        // if no value for attribute, set arg context
                        // to the default value.  We don't need an instance
                        // here because no attributes can be set in
                        // the arg templates by the user.
                        $nchunks = count($arg->defaultValueST->chunks);
                        if ( $nchunks==1 ) {
                            // If default arg is template with single expression
                            // wrapped in parens, x={<(...)>}, then eval to string
                            // rather than setting x to the template for later
                            // eval.
                            $a = $arg->defaultValueST->chunks[0];
                            if ( $a instanceof ASTExpr ) {
                                $e = $a;
                                if ( $e->getAST()->getType() == ActionEvaluator::$VALUE ) {
                                    $defaultValue = $e->evaluateExpression(this, $e->getAST());
                                }
                            }
                        }
                        $this->argumentContext[$argName] = $defaultValue;
                    }
                }
            }
        }
    }

    /** From this template upward in the enclosing template tree,
     *  recursively look for the formal parameter.
     *
     * @return FormalArgument
     */
    public function lookupFormalArgument($name) {
        $arg = $this->getFormalArgument($name);
        if ( $arg==null && $this->enclosingInstance!=null ) {
            $arg = $this->enclosingInstance->lookupFormalArgument($name);
        }
        return $arg;
    }

    /**
     * @return FormalArgument
     */
    public function getFormalArgument($name) {
        return $this->formalArguments[$name];
    }

    public function defineEmptyFormalArgumentList() {
        $this->setFormalArguments(array());
    }

    public function defineFormalArgument($name, StringTemplate $value = null)
    {
        if ( $value!=null ) {
            $this->numberOfDefaultArgumentValues++;
        }
        $a = new FormalArgument($name, $defaultValue);
        if ( $this->formalArguments == FormalArgument::$UNKNOWN ) {
            $this->formalArguments = array();
        }
        $this->defineFormalArgument($name, null);
    }

    public function defineFormalArguments($names)
    {
        if ( $names==null ) {
            return;
        }
        foreach ($names as $name) {
            $this->defineFormalArgument($name);
        }
    }

    /** Normally if you call template y from x, y cannot see any attributes
     *  of x that are defined as formal parameters of y.  Setting this
     *  passThroughAttributes to true, will override that and allow a
     *  template to see through the formal arg list to inherited values.
     *
     * @param boolean $passThroughAttributes
     */
    public function setPassThroughAttributes($passThroughAttributes) {
        $this->passThroughAttributes = $passThroughAttributes;
    }

    /** Specify a complete map of what object classes should map to which
     *  renderer objects.
     */
    public function setAttributeRenderers($renderers) {
        $this->attributeRenderers = $renderers;
    }

    /** Register a renderer for all objects of a particular type.  This
     *  overrides any renderer set in the group for this class type.
     */
    public function registerRenderer($attributeClassName, AttributeRenderer $renderer) {
        if ( $this->attributeRenderers==null ) {
            $this->attributeRenderers = array();
        }
        $this->attributeRenderers[$attributeClassName] = $renderer;
    }

    /** What renderer is registered for this attributeClassType for
     *  this template.  If not found, the template's group is queried.
     *
     * @return AttributeRender
     */
    public function getAttributeRenderer($attributeClassName) {
        $renderer = null;
        if ( $this->attributeRenderers!=null ) {
            $renderer = $this->attributeRenderers[$attributeClassName];
        }
        if ( $renderer!=null ) {
            // found it!
            return $renderer;
        }

        // we have no renderer overrides for the template or none for class arg
        // check parent template if we are embedded
        if ( $this->enclosingInstance!=null ) {
            return $this->enclosingInstance->getAttributeRenderer($attributeClassName);
        }
        // else check group
        return $this->group->getAttributeRenderer($attributeClassName);
    }

    // U T I L I T Y  R O U T I N E S

    public function warning($msg) {
        if ( $this->getErrorListener()!=null ) {
            $this->getErrorListener()->warning($msg);
        }
        else {
            echo "StringTemplate: warning: " . $msg;
        }
    }

    public function error($msg, $e) {
        if ( $this->getErrorListener()!=null ) {
            $this->getErrorListener()->error($msg,$e);
        }
        else {
            if ( $e!=null ) {
                echo "StringTemplate: error: ". $msg .": " . (string) $e;
                //e.printStackTrace(System.err);
            }
            else {
                echo "StringTemplate: error: ".$msg;
            }
        }
    }

    /** Make StringTemplate check your work as it evaluates templates.
     *  Problems are sent to error listener.   Currently warns when
     *  you set attributes that are not used.
     */
    public static function setLintMode($lint)
    {
        self::$lintMode = $lint;
    }

    public static function inLintMode()
    {
        return self::$lintMode;
    }

    /** Indicates that 'name' has been referenced in this template. */
    protected function trackAttributeReference($name)
    {
        if ( $this->referencedAttributes==null ) {
            $this->referencedAttributes = array();
        }
        $referencedAttributes[] = name;
    }

    /**
     * Look up the enclosing instance chain (and include this) to see
     * if st is a template already in the enclosing instance chain.
     *
     * @param StringTemplate $st
     *
     * @return boolean
     */
    public static function isRecursiveEnclosingInstance($st)
    {
        if ( $st==null ) {
            return false;
        }
        $p = $st->enclosingInstance;
        if ( $p==$st ) {
            return true; // self-recursive
        }
        // now look for indirect recursion
        while ( $p!=null ) {
            if ( $p==$st ) {
                return true;
            }
            $p = $p->enclosingInstance;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getEnclosingInstanceStackTrace()
    {
        $buf = new StringBuffer();
        $seen = array();
        $p = $this;
        while ( $p!=null ) {
            if ( in_array($p, $seen) ) {
                $buf->append($p->getTemplateDeclaratorString());
                $buf->append(" (start of recursive cycle)");
                $buf->append("\n");
                $buf->append("...");
                break;
            }
            $seen[] = $p;
            $buf->append($p->getTemplateDeclaratorString());
            if ( $p->attributes!=null ) {
                $buf->append(", attributes=[");
                $i = 0;
                foreach ($p->attributes as $attrName => $o) {
                    if ( $i>0 ) {
                        $buf->append(", ");
                    }
                    $i++;
                    $buf->append($attrName);
                    if ( $o instanceof StringTemplate ) {
                        $st = $o;
                        $buf->append("=");
                        $buf->append("<");
                        $buf->append($st->getName());
                        $buf->append("()@");
                        $buf->append((string)$st->getTemplateID());
                        $buf->append(">");
                    }
                    else if ( $o instanceof ArrayList ) {
                        $buf->append("=List[..");
                        $list = $o;
                        $n=0;
                        for ($j = 0; $j < count($list); $j++) {
                            $listValue = $list[$j];
                            if ( $listValue instanceof StringTemplate ) {
                                if ( $n>0 ) {
                                    $buf->append(", ");
                                }
                                $n++;
                                /* @var StringTemplate $st */
                                $st = $listValue;
                                $buf->append("<");
                                $buf->append($st->getName());
                                $buf->append("()@");
                                $buf->append((string)($st->getTemplateID()));
                                $buf->append(">");
                            }
                        }
                        $buf->append("..]");
                    }
                }
                $buf->append("]");
            }
            if ( $p->referencedAttributes!=null ) {
                $buf->append(", references=");
                $buf->append($p->referencedAttributes);
            }
            $buf->append(">\n");
            $p = $p->enclosingInstance;
        }
        /*
                if ( enclosingInstance!=null ) {
                buf.append(enclosingInstance.getEnclosingInstanceStackTrace());
                }
                */
        return $buf->toString();
    }

    /**
     * @return string
     */
    public function getTemplateDeclaratorString() {
        $buf = new StringBuffer();
        $buf->append("<");
        $buf->append($this->getName());
        $buf->append("(");
        $buf->append(array_keys($this->formalArguments));
        $buf->append(")@");
        $buf->append((string)$this->getTemplateID());
        $buf->append(">");
        return $buf.toString();
    }

    /**
     * @param $showAttributes
     *
     * @return string
     */
    protected function getTemplateHeaderString($showAttributes) {
        if ( $showAttributes ) {
            $buf = new StringBuffer();
            $buf->append($this->getName());
            if ( $this->attributes!=null ) {
                $buf->append(array_keys($this->attributes));
            }
            return $buf->toString();
        }
        return $this->getName();
    }

    /** Find "missing attribute" and "cardinality mismatch" errors.
     *  Excecuted before a template writes its chunks out.
     *  When you find a problem, throw an IllegalArgumentException.
     *  We must check the attributes as well as the incoming arguments
     *  in argumentContext.
    protected void checkAttributesAgainstFormalArguments() {
        Set args = formalArguments.keySet();
        /*
        if ( (attributes==null||attributes.size()==0) &&
             (argumentContext==null||argumentContext.size()==0) &&
             formalArguments.size()!=0 )
        {
            throw new IllegalArgumentException("missing argument(s): "+args+" in template "+getName());
        }
        Iterator iter = args.iterator();
        while ( iter.hasNext() ) {
            String argName = (String)iter.next();
            FormalArgument arg = getFormalArgument(argName);
            int expectedCardinality = arg.getCardinality();
            Object value = getAttribute(argName);
            int actualCardinality = getActualArgumentCardinality(value);
            // if intersection of expected and actual is empty, mismatch
            if ( (expectedCardinality&actualCardinality)==0 ) {
                throw new IllegalArgumentException("cardinality mismatch: "+
                        argName+"; expected "+
                        FormalArgument.getCardinalityName(expectedCardinality)+
                        " found cardinality="+getObjectLength(value));
            }
        }
    }
*/

    /** A reference to an attribute with no value, must be compared against
     *  the formal parameter to see if it exists; if it exists all is well,
     *  but if not, throw an exception.
     *
     *  Don't do the check if no formal parameters exist for this template;
     *  ask enclosing.
     *
     * @param StringTemplate $self
     * @param string         $attribute
     *
     * @return void
     */
    protected function checkNullAttributeAgainstFormalArguments(
            StringTemplate $self,
            $attribute)
    {
        if ( $self->getFormalArguments()==FormalArgument::$UNKNOWN ) {
            // bypass unknown arg lists
            if ( $self->enclosingInstance!=null ) {
                checkNullAttributeAgainstFormalArguments(
                        $self->enclosingInstance,
                        $attribute);
            }
            return;
        }
        $formalArg = $self->lookupFormalArgument($attribute);
        if ( $formalArg == null ) {
            throw new Exception("no such attribute: "+$attribute+
                                             " in template context "+$this->getEnclosingInstanceStackString());
        }
    }

    /** Executed after evaluating a template.  For now, checks for setting
     *  of attributes not reference.
     */
    protected function checkForTrouble()
    {
        // we have table of set values and list of values referenced
        // compare, looking for SET BUT NOT REFERENCED ATTRIBUTES
        if ( $this->attributes==null ) {
            return;
        }
        $names = $this->attributes->getKeys();
        // if in names and not in referenced attributes, trouble
        foreach ($names as $name) {
            if ( $this->referencedAttributes!=null &&
                !in_array($name, $this->referencedAttributes) )
            {
                $this->warning($this->getName().": set but not used: ".$this->name);
            }
        }
        // can do the reverse, but will have lots of false warnings :(
    }

    /**
     * If an instance of x is enclosed in a y which is in a z, return
     * a String of these instance names in order from topmost to lowest;
     * here that would be "[z y x]".
     *
     * @return string
     */
    public function getEnclosingInstanceStackString()
    {
        $names = array();
        $p = $this;
        while ( $p!=null ) {
            $name = $p->getName();
            $names[] =  $name . (($p->passThroughAttributes)?"(...)":"");
            $p = $p->enclosingInstance;
        }
        return implode('',$names);
    }

    public function isRegion() {
        return $this->isRegion;
    }

    public function setIsRegion(boolean $isRegion) {
        $this->isRegion = $isRegion;
    }

    public function addRegionName($name) {
        if ( $this->regions==null ) {
            $this->regions = array();
        }
        $this->regions[] = $name;
    }

    /** Does this template ref or embed region name? */
    public function containsRegionName($name) {
        if ( $this->regions==null ) {
            return false;
        }
        return in_array($name, $this->regions);
    }

    public function getRegionDefType() {
        return $this->regionDefType;
    }

    public function setRegionDefType($regionDefType)
    {
        $this->regionDefType = $regionDefType;
    }

    public function toDebugString()
    {
        $buf = new StringBuffer();
        $buf->append("template-"+getTemplateDeclaratorString()+":");
        $buf->append("chunks=");
        if ( $this->chunks!=null ) {
            $buf->append(implode(',',$this->chunks));
        }
        $buf->append("attributes=[");
        if ( attributes!=null ) {
            $attrNames = $this->attributes->getKeys();
            $n=0;
            foreach ($attrNames as $name) {
                if ( $n>0 ) {
                    $buf->append(',');
                }
                $buf->append(name+"=");
                $value = $this->attributes[$name];
                if ( $value instanceof StringTemplate ) {
                    $buf->append($value->toDebugString());
                }
                else {
                    $buf->append($value);
                }
                $n++;
            }
            $buf->append("]");
        }
        return $buf->toString();
    }

    /** Don't print values, just report the nested structure with attribute names.
     *  Follow (nest) attributes that are templates only.
     */
    public function toStructureString($indent=0) {
        $buf = new StringBuffer();
        for ($i=1; $i<=$indent; $i++) { // indent
            $buf->append("  ");
        }
        $buf->append($this->getName());
        $buf->append($this->attributes->getKeys());
        $buf->append(":\n");
        if ( $this->attributes!=null ) {
            $attrNames = $this->attributes->getKeys();
            foreach ($attrNames as $name) {
                $value = $this->attributes[$name];
                if ( $value instanceof StringTemplate ) { // descend
                    $buf->append($value->toStructureString($indent+1));
                }
                else {
                    if ($value instanceof ArrayList || is_array($value)) {
                        foreach ($value as $o) {
                            if ( $o instanceof StringTemplate ) { // descend
                                $buf->append($o->toStructureString(indent+1));
                            }
                        }
                    }
                }
            }
        }
        return $buf->toString();
    }

    /*
    public String getDOTForDependencyGraph(boolean showAttributes) {
        StringBuffer buf = new StringBuffer();
        buf.append("digraph prof {\n");
        HashMap edges = new HashMap();
        $this->getDependencyGraph(edges, showAttributes);
        Set sourceNodes = edges.keySet();
        // for each source template
        for (Iterator it = sourceNodes.iterator(); it.hasNext();) {
            String src = (String) it.next();
            Set targetNodes = (Set)edges.get(src);
            // for each target template
            for (Iterator it2 = targetNodes.iterator(); it2.hasNext();) {
                String trg = (String) it2.next();
                buf.append('"');
                buf.append(src);
                buf.append('"');
                buf.append("->");
                buf.append('"');
                buf.append(trg);
                buf.append("\"\n");
            }
        }
        buf.append("}");
        return buf.toString();
    }
*/

    /** Generate a DOT file for displaying the template enclosure graph; e.g.,
        digraph prof {
          "t1" -> "t2"
          "t1" -> "t3"
          "t4" -> "t5"
        }
     *
     * @return StringTemplate
     */
    public function getDOTForDependencyGraph($showAttributes) {
        /*String structure =
            "digraph StringTemplateDependencyGraph {\n" +
            "node [shape=$shape$, $if(width)$width=$width$,$endif$" +
            "      $if(height)$height=$height$,$endif$ fontsize=$fontsize$];\n" +
            "$edges:{e|\"$e.src$\" -> \"$e.trg$\"\n}$" +
            "}\n";
        StringTemplate graphST = new StringTemplate(structure);
        HashMap edges = new HashMap();
        $this->getDependencyGraph(edges, showAttributes);
        Set sourceNodes = edges.keySet();
        // for each source template
        for (Iterator it = sourceNodes.iterator(); it.hasNext();) {
            String src = (String) it.next();
            Set targetNodes = (Set)edges.get(src);
            // for each target template
            for (Iterator it2 = targetNodes.iterator(); it2.hasNext();) {
                String trg = (String) it2.next();
                graphST.setAttribute("edges.{src,trg}", src, trg);
            }
        }
        graphST.setAttribute("shape", "none");
        graphST.setAttribute("fontsize", "11");
        graphST.setAttribute("height", "0"); // make height
        return graphST;*/
    }

    /** Get a list of n->m edges where template n contains template m.
     *  The map you pass in is filled with edges: key->value.  Useful
     *  for having DOT print out an enclosing template graph.  It
     *  finds all direct template invocations too like <foo()> but not
     *  indirect ones like <(name)()>.
     *
     *  Ack, I just realized that this is done statically and hence
     *  cannot see runtime arg values on statically included templates.
     *  Hmm...someday figure out to do this dynamically as if we were
     *  evaluating the templates.  There will be extra nodes in the tree
     *  because we are static like method and method[...] with args.
     */
    public function getDependencyGraph($edges, $showAttributes) {
        /*String srcNode = $this->getTemplateHeaderString(showAttributes);
        if ( attributes!=null ) {
            Set attrNames = attributes.keySet();
            for (Iterator iter = attrNames.iterator(); iter.hasNext();) {
                String name = (String) iter.next();
                Object value = attributes.get(name);
                if ( value instanceof StringTemplate ) {
                    String targetNode =
                        ((StringTemplate)value).getTemplateHeaderString(showAttributes);
                    putToMultiValuedMap(edges,srcNode,targetNode);
                    ((StringTemplate)value).getDependencyGraph(edges,showAttributes); // descend
                }
                else {
                    if ( value instanceof List ) {
                        List alist = (List)value;
                        for (int i = 0; i < alist.size(); i++) {
                            Object o = (Object) alist.get(i);
                            if ( o instanceof StringTemplate ) {
                                String targetNode =
                                    ((StringTemplate)o).getTemplateHeaderString(showAttributes);
                                putToMultiValuedMap(edges,srcNode,targetNode);
                                ((StringTemplate)o).getDependencyGraph(edges,showAttributes); // descend
                            }
                        }
                    }
                    else if ( value instanceof Map ) {
                        Map m = (Map)value;
                        Collection mvalues = m.values();
                        for (Iterator iterator = mvalues.iterator(); iterator.hasNext();) {
                            Object o = (Object) iterator.next();
                            if ( o instanceof StringTemplate ) {
                                String targetNode =
                                    ((StringTemplate)o).getTemplateHeaderString(showAttributes);
                                putToMultiValuedMap(edges,srcNode,targetNode);
                                ((StringTemplate)o).getDependencyGraph(edges,showAttributes); // descend
                            }
                        }
                    }
                }
            }
        }
        // look in chunks too for template refs
        for (int i = 0; chunks!=null && i < chunks.size(); i++) {
            Expr expr = (Expr) chunks.get(i);
            if ( expr instanceof ASTExpr ) {
                ASTExpr e = (ASTExpr)expr;
                AST tree = e.getAST();
                AST includeAST =
                    new CommonAST(new CommonToken(ActionEvaluator.INCLUDE,"include"));
                ASTEnumeration it = tree.findAllPartial(includeAST);
                while (it.hasMoreNodes()) {
                    AST t = (AST) it.nextNode();
                    String templateInclude = t.getFirstChild().getText();
                    System.out.println("found include "+templateInclude);
                    putToMultiValuedMap(edges,srcNode,templateInclude);
                    StringTemplateGroup group = getGroup();
                    if ( group!=null ) {
                        StringTemplate st = group.getInstanceOf(templateInclude);
                        // descend into the reference template
                        st.getDependencyGraph(edges, showAttributes);
                    }
                }
            }
        }*/
    }

    /** Manage a hash table like it has multiple unique values.  Map<Object,Set>. */
    protected function putToMultiValuedMap($map, $key, $value) {
        $bag = $map[$key];
        if ( $bag==null ) {
            $bag = array();
            $map[$key] = $bag;
        }
        $bag[] = $value;
    }

    public function printDebugString()
    {
        echo "template-".getName().":\n";
        echo "chunks=";
        echo $this->chunks->toString() . "\n";
        if ( $this->attributes==null ) {
            return;
        }
        echo "attributes=[";
        $attrNames = $this->attributes->getKeys();
        $n=0;
        foreach ($attrNames as $name) {
            if ( $n > 0 ) {
                echo ',';
            }
            $value = $this->attributes[$name];
            if ( $value instanceof StringTemplate ) {
                echo $name . "=";
                $value->printDebugString();
            }
            else {
                if (is_array($value)) {
                    foreach ($value as $i => $o) {
                        echo $name . "[" . $i ."] is " . get_class($o) . "=";
                        if ( $o instanceof StringTemplate ) {
                            $o.printDebugString();
                        }
                        else {
                            echo $o;
                        }
                    }
                }
                else {
                    echo $name . "=";
                    echo $value . "\n";
                }
            }
            $n++;
        }
        echo "]\n";
    }

    /**
     * @return string
     */
    public function toString($lineWidth=false) {
        if ($lineWidth!==true) {
            $lineWidth = StringTemplateWriter::NO_WRAP;
        }
        $out = new StringWriter();
        // Write the output to a StringWriter
        $wr = $this->group->getStringTemplateWriter($out);
        $wr->setLineWidth($lineWidth);
        try {
            $this->write($wr);
        } catch (Exception $exception) {
            $this->error("Got IOException writing to writer ".$exception);
        }
        // reset so next toString() does not wrap; normally this is a new writer
        // each time, but just in case they override the group to reuse the
        // writer.
        $this->wr->setLineWidth(StringTemplateWriter::NO_WRAP);
        return $out->toString();
    }

}

// Set statc variables
StringTemplate::$defaultGroup =  new StringTemplateGroup("defaultGroup", ".");