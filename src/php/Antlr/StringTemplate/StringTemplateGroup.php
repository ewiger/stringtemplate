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
class StringTemplateGroup
{
	/**
     * What is the group name
     *
     * @var string
     */
	protected  $name;

	/**
     * Maps template name to StringTemplate object
     *
     * @var array
     */
	protected $templates = array();

	/**
     * Maps map names to HashMap objects.  This is the list of maps
	 * defined by the user like typeInitMap ::= ["int":"0"]
     *
     * @var array
	 */
	protected $maps = array();

	/**
     * How to pull apart a template into chunks?
     *
     * @var string
     */
	protected $templateLexerClassName = '';

	/** You can set the lexer once if you know all of your groups use the
	 *  same separator.  If the instance has templateLexerClass set
	 *  then it is used as an override.
	 */
	//protected static Class defaultTemplateLexerClass = DefaultTemplateLexer.class;

	/**
     * Under what directory should I look for templates?  If null,
	 * to look into the CLASSPATH for templates as resources.
     *
     * @var string
	 */
	protected $rootDir = null;

	/**
     * Track all groups by name; maps name to StringTemplateGroup
     *
     * @var array
     */
	protected static $nameToGroupMap = array();

	/**
     * Track all interfaces by name; maps name to StringTemplateGroupInterface
     *
     * @var array
     */
	protected static $nameToInterfaceMap = array();

	/**
     * Are we derived from another group?  Templates not found in this group
	 * will be searched for in the superGroup recursively.
     *
     * @var StringTemplateGroup
	 */
	protected  $superGroup = null;

	/**
     * Keep track of all interfaces implemented by this group.
     *
     * @var array|null
     */
	protected $interfaces = null;

	/**
     * When templates are files on the disk, the refresh interval is used
	 * to know when to reload.  When a Reader is passed to the ctor,
	 * it is a stream full of template definitions.  The former is used
	 * for web development, but the latter is most likely used for source
	 * code generation for translators; a refresh is unlikely.  Anyway,
	 * I decided to track the source of templates in case such info is useful
	 * in other situations than just turning off refresh interval.  I just
	 * found another: don't ever look on the disk for individual templates
	 * if this group is a group file...immediately look into any super group.
	 * If not in the super group, report no such template.
     *
     * @var boolean
	 */
	protected $templatesDefinedInGroupFile = false;

	/**
     * Normally AutoIndentWriter is used to filter output, but user can
	 * specify a new one.
     *
     * @var object
	 */
	protected $userSpecifiedWriter = null;

    /**
     * Debug template output
     *
     * @var boolean
     */
	protected $debugTemplateOutput = false;

	/**
     * The set of templates to ignore when dumping start/stop debug strings
     *
     * @var array
     */
	protected $noDebugStartStopStrings;

	/**
     * A Map<Class,Object> that allows people to register a renderer for
	 * a particular kind of object to be displayed for any template in this
	 * group.  For example, a date should be formatted differently depending
	 * on the locale.  You can set Date.class to an object whose
	 * toString(Object) method properly formats a Date attribute
	 * according to locale.  Or you can have a different renderer object
	 * for each locale.
	 *
	 * These render objects are used way down in the evaluation chain
	 * right before an attribute's toString() method would normally be
	 * called in ASTExpr.write().
	 *
	 * Synchronized at creation time.
     *
     * @var array
	 */
	protected $attributeRenderers;

	/**
     * If a group file indicates it derives from a supergroup, how do we
	 * find it?  Shall we make it so the initial StringTemplateGroup file
	 * can be loaded via this loader?  Right now we pass a Reader to ctor
	 * to distinguish from the other variety.
     *
     * @var StringTemplateGroupLoader
	 */
	private static $groupLoader = null;

	/**
     * Where to report errors.  All string templates in this group
	 * use this error handler by default.
     *
     * @var StringTemplateErrorListener
	 */
	protected $listener = null;

	/**
     * Used to indicate that the template doesn't exist.
	 * We don't have to check disk for it; we know it's not there.
     *
     * @var StringTemplate
	 */
	public static $NOT_FOUND_ST = null;

	/**
     * How long before tossing out all templates in seconds.
     *
     * @var int
     */
	protected $refreshIntervalInSeconds = 0;

    /**
     * @var int
     */
	protected $lastCheckedDisk = 0;

	/**
     * How are the files encoded (ascii, UTF8, ...)?  You might want to read
	 * UTF8 for example on an ascii machine.
     *
     * @var string
	 */
	public $fileCharEncoding = 'utf8';//System.getProperty("file.encoding");

	/**
     * Create a group manager for some templates, all of which are
	 * at or below the indicated directory.
     *
     * @param string $name
     * @param string $rootDir
     * @param object $lexer
     * @return void
	 */
    public function __construct($name, $rootDir, $lexer)
    {
		$this->name = $name;
		$this->rootDir = $rootDir;
		$this->lastCheckedDisk = now();
		$this->nameToGroupMap[$name] = $this;
		$this->templateLexerClass = $lexer;
        
        $this->$refreshIntervalInSeconds = intval('1000000000000000000000')/1000; // default: no refreshing from disk
	}

	/** Create a group from the input stream, but use a nondefault lexer
	 *  to break the templates up into chunks.  This is usefor changing
	 *  the delimiter from the default $...$ to <...>, for example.
     *
     * @param Reader $reader
     * @param string $lexer Lexer classname
     * @param StringTemplateErrorListener $listener
     * @param StringTemplateGroup $superGroup
     *
     * @return StringTemplateGroup
	 */
	public static function groupFactory($reader,
							   $lexer,
							   StringTemplateErrorListener $errors,
							   StringTemplateGroup $superGroup)
	{
		$this->templatesDefinedInGroupFile = true;
		// if no lexer specified, then assume <...> when loading from group file
		if ( $lexer==null ) {
			$lexer = new AngleBracketTemplateLexer;
		}
		$this->templateLexerClassName = $lexer;
		if ( $this->errors!=null ) { // always have to have a listener
			$this->listener = $errors;
		}
		$this->setSuperGroup(superGroup);
		$this->parseGroup(r);
		$this->nameToGroupMap[$name] = $this;
		$this->verifyInterfaceImplementations();
	}

	/** What lexer class to use to break up templates.  If not lexer set
	 *  for this group, use static default.
     *
     *  @return TemplateLexer
	 */
	public function templateLexerFactory()
    {
		return new $this->templateLexerClassName;
	}

    /**
     * Get group name
     *
     * @return string
     */
	public function getName()
    {
		return $this->name;
	}

    /**
     * Set group name
     *
     * @param string $name
     *
     * @return StringTemplateGroup
     */
	public function setName($name)
    {
		$this->name = $name;

        return $this;
	}

    /**
     * Set super group
     *
     * @param string|StringTemplateGroup $superGroup
     *
     * @return StringTemplateGroup
     */
	public function setSuperGroup(StringTemplateGroup $superGroup)
    {
        if (is_string($superGroup)) {
            $superGroup = $this->getSuperGroupByName($superGroup);
            if (!$superGroup) {
                return $this;
            }
        }
        $this->superGroup = $superGroup;

        return $this;
	}

	/**
     * Called by group parser when ": supergroupname" is found.
	 * This method forces the supergroup's lexer to be same as lexer
	 * for this (sub) group.
     *
     * @param string $superGroupName super group name
     *
     * @return StringTemplateGroup|null
	 */
	protected function getSuperGroupByName($superGroupName)
    {
		$superGroup = $this->nameToGroupMap[$superGroupName];
		if ( $superGroup !=null ) { // we've seen before; just use it
            return $superGroup;
		}
		// else load it using this group's template lexer
		$superGroup = $this->loadGroup($superGroupName, $this->templateLexerClassName);
		if ( $superGroup !=null ) {
			$this->nameToGroupMap[$superGroupName] = $superGroup;
            return $groupLoader;
		}
		else {
			if ( $this->groupLoader==null ) {
				$this->listener->error("no group loader registered", null);
			}
		}

        return null;
	}

	/**
     * Just track the new interface; check later.  Allows dups, but no biggie.
     *
     * @param StringTemplateGroupInterface $groupInterface
     *
     * @return void
     */
	public function implementInterface(StringTemplateGroupInterface $groupInterface)
    {
		if ( $this->interfaces==null ) {
            $this->interfaces = array();
		}
        if(is_string($groupInterface)) {
            $this->implementInterfaceByName($groupInterface);
        }
		$this->interfaces->add($groupInterface);
	}

	/**
     * Indicate that this group implements this interface; load if necessary
	 * if not in the nameToInterfaceMap.
     *
     * @param string $interfaceName
     *
     * @return void
	 */
	public function implementInterfaceByName($interfaceName)
    {
		$groupInterface = $this->nameToInterfaceMap[$interfaceName];
		if ( $groupInterface!=null ) { // we've seen before; just use it
			$this->implementInterface($groupInterface);
			return;
		}
		$groupInterface = $this->loadInterface($interfaceName); // else load it
		if ( $groupInterface!=null ) {
			$this->nameToInterfaceMap[$interfaceName] = $groupInterface;
			$this->implementInterface($groupInterface);
		}
		else {
			if ( $this->groupLoader==null ) {
				$this->listener->error("no group loader registered", null);
			}
		}
	}

    /**
     * Get super group
     *
     * @return StringTemplateGroupInterface
     */
	public function getSuperGroup()
    {
		return $this->superGroup;
	}

	/**
     * Walk up group hierarchy and show top down to this group
     *
     * @return string
     */
	public function getGroupHierarchyStackString() {
		$groupNames = array();
		$stringTemplateGroup = $this;
		while ( $stringTemplateGroup!=null ) {
			$groupNames[] = $stringTemplateGroup->name;
			$stringTemplateGroup = $stringTemplateGroup->superGroup;
		}
		return implode('',$groupNames);
	}

    /**
     * Get root dir
     *
     * @return
     */
	public function getRootDir() {
		return $this->rootDir;
	}

    /**
     * Set root dir
     *
     * @param string $rootDir
     *
     * @return StringTemplateGroup
     */
	public function setRootDir($rootDir) {
		$this->rootDir = $rootDir;

        return $this;
	}

	/**
     * StringTemplate object factory; each group can have its own.
     *
     * @return StringTemplate
     */
	public function createStringTemplate()
    {
        $stringTemplate = new StringTemplate();

        return $stringTemplate;
	}

	/**
     * A way of getting an instance of a template from this
	 * group. ST encloses it for error messages.
     *
     * @param StringTemplate $enclosingInstance
     * @param string         $name
     *
     * @return StringTemplate
     * @throws IllegalArgumentException
	 */
	public function getInstanceOf($name, StringTemplate $enclosingInstance=null, $attributes=null)
	{
		$stringTemplate = $this->lookupTemplate($enclosingInstance,$name);
		if ( $stringTemplate!=null ) {
			$instanceStringTemplate = $stringTemplate.getInstanceOf();
            if ($attributes) {
                $instanceStringTemplate->attributes = $attributes;
            }
			return $instanceStringTemplate;
		}

		return null;
	}

    /**
     * Get embedded instance
     *
     * @param StringTemplate $enclosingInstance
     * @param String         $name
     *
     * @return StringTemplate
     * @throws IllegalArgumentException
     */
	public function getEmbeddedInstanceOf(StringTemplate $enclosingInstance, $name)
	{
		$stringTemplate = null;
		// TODO: seems like this should go into lookupTemplate
		if ( strpos("super.",$name)===0) {
			// for super.foo() refs, ensure that we look at the native
			// group for the embedded instance not the current evaluation
			// group (which is always pulled down to the original group
			// from which somebody did group.getInstanceOf("foo");
			$stringTemplate = $enclosingInstance->getNativeGroup()->getInstanceOf($enclosingInstance, $name);
		}
		else {
			$stringTemplate = $this->getInstanceOf($enclosingInstance, $name);
		}
		// make sure all embedded templates have the same group as enclosing
		// so that polymorphic refs will start looking at the original group
		$stringTemplate->setGroup($this);
		$stringTemplate->setEnclosingInstance($enclosingInstance);

        return $stringTemplate;
	}

	/**
     * Get the template called 'name' from the group.  If not found,
	 * attempt to load.  If not found on disk, then try the superGroup
	 * if any.  If not even there, then record that it's
	 * NOT_FOUND so we don't waste time looking again later.  If we've gone
	 * past refresh interval, flush and look again.
	 *
	 * If I find a template in a super group, copy an instance down here
     *
     * @param StringTemplate $enclosingInstance
     * @param string         $name
     *
     * @return StringTemplate
	 */
	public function lookupTemplate(StringTemplate $enclosingInstance, $name)
	{
		if ( strpos($name,"super.") == 0 ) {
			if ( $this->superGroup!=null ) {
				$dot = strpos($name,'.');
				$name = substr($name.$dot+1,strlen($name));
				$superScopeST = $this->superGroup->lookupTemplate($enclosingInstance,$name);
				return $superScopeST;
			}
			throw new Exception($this->getName() . " has no super group; invalid template: " . $name);
		}
		$this->checkRefreshInterval();
		$stringTemplate = $this->templates[$name];
		if ( $stringTemplate==null ) {
			// not there?  Attempt to load
			if ( !$this->templatesDefinedInGroupFile ) {
				// only check the disk for individual template
				$stringTemplate = $this->loadTemplateFromBeneathRootDirOrCLASSPATH(getFileNameFromTemplateName(name));
			}
			if ( $stringTemplate==null && $this->superGroup!=null ) {
				// try to resolve in super group
				$stringTemplate = $this->superGroup->getInstanceOf($name);
				// make sure that when we inherit a template, that it's
				// group is reset; it's nativeGroup will remain where it was
				if ( $stringTemplate!=null ) {
					$stringTemplate->setGroup($this);
				}
			}
			if ( $stringTemplate!=null ) { // found in superGroup
				// insert into this group; refresh will allow super
				// to change it's def later or this group to add
				// an override.
				$this->templates[$name] = $stringTemplate;
			}
			else {
				// not found; remember that this sucker desn't exist
                $this->templates[$name] = $this->NOT_FOUND_ST;
				$context = "";
				if ( $this->enclosingInstance!=null ) {
					$context = "; context is "+
							  $enclosingInstance->getEnclosingInstanceStackString();
				}
				$hier = $this->getGroupHierarchyStackString();
				$context += "; group hierarchy is "+hier;
				throw new Exception("Can't find template " .
												   $this->getFileNameFromTemplateName($name)+
												   $context);
			}
		}
		else if ( !$this->templateExists($stringTemplate) ) {
			return null;
		}

		return $stringTemplate;
	}

    /**
     * Check refresh interval
     *
     * @return void
     */
	protected function checkRefreshInterval() {
		if ( $this->templatesDefinedInGroupFile ) {
			return;
		}
		$timeToFlush=$this->refreshIntervalInSeconds==0 ||
							(now()-$this->lastCheckedDisk)>=$this->refreshIntervalInSeconds*1000;
		if ( $timeToFlush ) {
			// throw away all pre-compiled references
			$this->templates = array();
			$this->lastCheckedDisk = now();
		}
	}

    /**
     * Load template
     *
     * @param string            $name
     * @param Antlr\Util\Reader $reader
     *
     * @return StringTemplate
     * @throws IOException
     */
	protected function _loadTemplate($name, Reader $reader)
	{
	    $line;
		$nl = PHP_EOL;
		$buf = array();
		foreach ($reader as $line) {
			$buf[] = $line;
			$buf[] = $nl;
		}
		// strip newlines etc.. from front/back since filesystem
		// may add newlines etc...
		$pattern = trim(implode('', $buf));
		if ( strlen($pattern)==0 ) {
			$this->error("no text in template '" . $name . "'");
			return null;
		}

		return $this->defineTemplate($name, $pattern);
	}

	/**
     * Load a template whose name is derived from the template filename.
	 * If there is no root directory, try to load the template from
	 * the classpath.  If there is a rootDir, try to load the file
	 * from there.
     *
     * @param string $fileName
     *
     * @return StringTemplate
	 */
	protected function loadTemplateFromBeneathRootDirOrCLASSPATH($fileName)
	{
		$template = null;
		$name = $this->getTemplateNameFromFileName($fileName);
		// if no rootDir, try to load as a resource in CLASSPATH
		/*if ( $rootDir==null ) {
			ClassLoader cl = Thread.currentThread().getContextClassLoader();
			InputStream is = cl.getResourceAsStream(fileName);
			if ( is==null ) {
				cl = this.getClass().getClassLoader();
				is = cl.getResourceAsStream(fileName);
			}
			if ( is==null ) {
				return null;
			}
			BufferedReader br = null;
			try {
				br = new BufferedReader(getInputStreamReader(is));
				template = loadTemplate(name, br);
			} catch (Exception $exception) {
				$this->error("Problem reading template file: "+$fileName, $exception);
			}
			if ( br!=null ) {
                try {
                    br.close();
				} catch (IOException ioe2) {
				  $this->error("Cannot close template file: "+$fileName, $exception);
                }
			}

			return $template;
		}*/
		// load via rootDir
		$template = $this->loadTemplate($name, $this->rootDir . "/" . $fileName);
		return template;
	}

	/**
     * Get filename from template
     *
     * (public so that people can override behavior; not a general
	 * purpose method)
     *
     * @param string templateName
     *
     * @return string
	 */
	public function getFileNameFromTemplateName($templateName) {
		return $templateName . '.st';
	}

	/**
     * Convert a filename relativePath/name.st to relativePath/name.
	 * (public so that people can override behavior; not a general
	 * purpose method)
     *
     * @param string $fileName
     *
     * @return string
	 */
	public function getTemplateNameFromFileName($fileName)
    {
		$name = $fileName;
		$suffix = strpos($name, ".st");
		if ( $suffix>=0 ) {
			$name = substr($name, 0, $suffix);
		}

		return $name;
	}

    /**
     * Load template
     *
     * @param string $name
     * @param string $fileName
     *
     * @return StringTemplate
     */
	protected function loadTemplate($name, $fileName)
	{
		$stringTemplate = null;
		if (file_exists($fileName)) {
			$buffer = file_get_contents($fileName);
		} else {
            // assume that fileName contains template buffer
            $buffer = $fileName;
		}
        $stringTemplate = $this->_loadTemplate(name, $buffer);

		return $stringTemplate;
	}

	/*protected InputStreamReader getInputStreamReader(InputStream in) {
		InputStreamReader isr = null;
		try {
			 isr = new InputStreamReader(in, fileCharEncoding);
		}
		catch (UnsupportedEncodingException uee) {
			error("Invalid file character encoding: "+fileCharEncoding);
		}
		return isr;
	}*/

    /**
     * Get file char encoding
     *
     * @return string
     */
	public function getFileCharEncoding() {
		return $this->fileCharEncoding;
	}

    /**
     * Set file char encoding
     *
     * @param strign $fileCharEncoding
     *
     * @return void
     */
	public function setFileCharEncoding($fileCharEncoding) {
		$this->fileCharEncoding = $fileCharEncoding;
	}

	/**
     * Define an examplar template; precompiled and stored
	 * with no attributes.  Remove any previous definition.
     *
     * @param string $name     template name
     * @param strign $template template value
     *
     * @return StringTemplate
	 */
	public function defineTemplate($name, $template)
	{
		if ( $name!=null && strpos($name, '.')!==false ) {
			throw new Exception("cannot have '.' in template names");
		}
		$stringTemplate = $this->createStringTemplate();
		$stringTemplate.setName($name);
		$stringTemplate.setGroup($this);
		$stringTemplate.setNativeGroup($this);
		$stringTemplate.setTemplate($template);
		$stringTemplate.setErrorListener($listener);
        $templates[$name] = $stringTemplate;

        return $stringTemplate;
	}

	/**
     * Track all references to regions <@foo>...<@end> or <@foo()>.
     *
     * Track all references to regions <@foo()>.  We automatically
	 * define as
	 *
	 *     @enclosingtemplate.foo() ::= ""
	 *
	 * You cannot set these manually in the same group; you have to subgroup
	 * to override.
     *
     * @param string $enclosingTemplateName
     * @param string $regionName
     * @param string $template
	 * @param int    $type
     *
     * @return StringTemplate
     */
	public function defineRegionTemplate($enclosingTemplateName,
										 $regionName,
									     $template='',
									     $type=StringTemplate::REGION_IMPLICIT)
	{
        if (is_object($enclosingTemplateName) &&  $enclosingTemplateName instanceof StringTemplate) {
            $regionST = $this->defineRegionTemplate($enclosingTemplate->getOutermostName(), $template);
            $enclosingTemplate
                ->getOutermostEnclosingInstance()
                ->addRegionName($regionName);
        } else {
            $mangledName = $this->getMangledRegionName($enclosingTemplateName, $regionName);
            $regionST = $this->defineTemplate($mangledName, $template);
            $regionST.setIsRegion(true);
            $regionST.setRegionDefType($type);
        }

		return $regionST;
	}

	/**
     * Get managed region name
     *
     * The "foo" of t() ::= "<@foo()>" is mangled to "region#t#foo"
     *
     * @param string $enclosingTemplateName
     * @param string $name
     *
     * @return string
     */
	public function getMangledRegionName($enclosingTemplateName, $name)
	{
		return 'region__' . $enclosingTemplateName . '__' . $name;
	}

	/**
     * Get unmanaged template name
     *
     * Return "t" from "region__t__foo"
     *
     * @param string $managedName
     *
     * @return string
     */
	public function getUnMangledTemplateName($mangledName)
	{
		return substr($mangledName,strlen("region__"), strpos($mangledName,"__"));
	}

	/**
     * Make name and alias for target.  Replace any previous def of name
     *
     * @param string $name
     * @param string $target
     *
     * @return StringTemplate
     */
	public function defineTemplateAlias($name, $target) {
		$targetST = getTemplateDefinition($target);
		if ( $targetST==null ){
			$this->error("cannot alias ".$name." to undefined template: ".$target);
			return null;
		}
		$templates[$name] = $targetST;

        return $targetST;
	}

    /**
     * Is defined in this group
     *
     * @param strign $name
     *
     * @return boolean
     */
	public function isDefinedInThisGroup($name) {
		$stringTemplate = $this->templates[$name];
		if ( $stringTemplate!=null ) {
			if ( $stringTemplate->isRegion() ) {
				// don't allow redef of @t.r() ::= "..." or <@r>...<@end>
				if ( $stringTemplate->getRegionDefType()==StringTemplate::REGION_IMPLICIT ) {
					return false;
				}
			}
			return true;
		}
		return false;
	}

	/**
     * Get the ST for 'name' in this group only
     *
     * @param string $name
     *
     * @return StringTemplate
     */
	public function getTemplateDefinition($name) {
		return $templates[$name];
	}

	/**
     * Is there *any* definition for template 'name' in this template
	 * or above it in the group hierarchy?
     *
     * @param string $name
     *
     * @return boolean
	 */
	public function isDefined($name) {
		try {
			return $this->lookupTemplate($name)!=null;
		} catch (Exception $exception) {
			return false;
		}
        return true;
	}

    /**
     * Parse group
     *
     * @return
     */
	protected function parseGroup(Reader $reader) {
		try {
			$lexer = new GroupLexer($reader);
			$parser = new GroupParser($lexer);
			$parser->group($this);
			//System.out.println("read group\n"+this.toString());
		} catch (Exception $exception) {
			$name = "<unknown>";
			if ( $this->getName()!=null ) {
				$name = $this->getName();
			}
			$this->error("problem parsing group "+name+": "+e, e);
		}
	}

	/**
     * Verify that this group satisfies its interfaces
     *
     * @return void
     */
	protected function verifyInterfaceImplementations() {
		foreach ($this->interfaces as $interface) {
			$missing = $interface->getMissingTemplates($this);
			$mismatched = $interface->getMismatchedTemplates($this);
			if ( $missing!=null ) {
				$this->error("group ".$this->getName()." does not satisfy interface ".
					  $interface->getName().": missing templates ".implode(',',$missing));
			}
			if ( $mismatched!=null ) {
				$this->error("group "+$this->getName()+" does not satisfy interface "+
					  $interface.getName()+": mismatched arguments on these templates "+implode(',',$mismatched));
			}
		}
	}

    /**
     * Get refresh interval in seconds
     *
     * @return int
     */
	public function getRefreshInterval()
    {
		return $this->refreshIntervalInSeconds;
	}

	/**
     * How often to refresh all templates from disk.  This is a crude
	 * mechanism at the moment--just tosses everything out at this
	 * frequency.  Set interval to 0 to refresh constantly (no caching).
	 * Set interval to a huge number like MAX_INT to have no refreshing
	 * at all (DEFAULT); it will cache stuff.
     *
     * @param int $refreshInterval
     *
     * @return void
	 */
	public function setRefreshInterval($refreshInterval)
    {
		$this->refreshIntervalInSeconds = refreshInterval;
	}

    /**
     * Set error listener
     *
     * @param StringTemplateErrorListener $listener
     *
     * @return void
     */
	public function setErrorListener(StringTemplateErrorListener $listener) {
		$this->listener = $listener;
	}

    /**
     * Get error listener
     *
     * @return StringTemplateErrorListener
     */
	public function getErrorListener() {
		return $this->listener;
	}

	/**
     * Specify a StringTemplateWriter implementing class to use for
	 * filtering output
     *
     * @param string $userSpecifiedWriterClassName
     *
     * @return void
	 */
	public function setStringTemplateWriter($userSpecifiedWriterClassName) {
		$this->userSpecifiedWriterClassName = $userSpecifiedWriterClassName;
	}

	/**
     * Return an instance of a StringTemplateWriter that spits output to w.
	 * If a writer is specified, use it instead of the default.
     *
     * @param Writer $writer
     *
     * @return StringTemplateWriter
	 */
	public function getStringTemplateWriter(Writer $writer)
    {
        $stw = null;
		if ($this->userSpecifiedWriterClassName != null) {
            try {
               $stw = $this->userSpecifiedWriterClassName($writer);
            } catch (Exception $exception) {
				error("problems getting StringTemplateWriter", $exception);
			}
		}
		if ( $stw==null ) {
			$stw = new AutoIndentWriter($writer);
		}

		return $stw;
	}

	/**
     * Specify a complete map of what object classes should map to which
	 * renderer objects for every template in this group (that doesn't
	 * override it per template).
     *
     * @param array $renders
     *
     * @return StringTemplateGroup
	 */
	public function setAttributeRenderers($renderers) {
		$this->attributeRenderers = $renderers;

        return $this;
	}

	/**
     * Register a renderer for all objects of a particular type for all
	 * templates in this group.
     * 
     * @param string $attributeClassType
     * @param object $renderer
     *
     * @return StringTemplateGroup
	 */
	public function registerRenderer($attributeClassType, $renderer) {
		if ( $this->attributeRenderers==null ) {
			$this->attributeRenderers = array();
		}
		$this->attributeRenderers[$attributeClassType] = $renderer;
	}

	/**
     * What renderer is registered for this attributeClassType for
	 * this group?  If not found, as superGroup if it has one.
     *
     * @param string $attributeClassType
     *
     * @return AttributeRenderer
	 */
	public function getAttributeRenderer($attributeClassType) {
		if ( $this->attributeRenderers==null ) {
			if ( $this->superGroup==null ) {
				return null; // no renderers and no parent?  Stop.
			}
			// no renderers; consult super group
			return $this->superGroup->getAttributeRenderer($attributeClassType);
		}

		$renderer = $this->attributeRenderers[$attributeClassType];
		if ( $renderer==null ) {
			if ( $superGroup!=null ) {
				// no renderer registered for this class, check super group
				$renderer = $superGroup->getAttributeRenderer($attributeClassType);
			}
		}

		return $renderer;
	}

    /**
     * Get map
     *
     * @param string $name
     *
     * @return array
     */
	public function getMap($name) {
		if ( $this->maps==null ) {
			if ( $this->superGroup==null ) {
				return null;
			}
			return $this->superGroup->getMap($name);
		}
		$map = $this->maps[$name];
		if ( $map == null && $this->superGroup!=null ) {
			$map = $this->superGroup->getMap($name);
		}

		return $map;
	}

	/**
     * Define a map for this group; not thread safe...do not keep adding
	 * these while you reference them.
     *
     * @param string $name
     * @param array  $mapping
     *
     * @return StringTemplateGroup
	 */
	public function defineMap($name, $mapping) {
		$this->maps[$name] = $mapping;

        return $this;
	}

    /**
     * Register default template lexer class name
     *
     * @param string $lexerClassName
     *
     * @return StringTemplateGroup
     */
	public static function registerDefaultLexer($lexerClassName) {
		$this->defaultTemplateLexerClassName = $lexerClassName;

        return $this;
	}

    /**
     * Register group loader
     *
     * @param StringTemplateGroupLoader $loader
     *
     * @return $loader
     */
	public static function registerGroupLoader(StringTemplateGroupLoader $loader)
    {
		$this->groupLoader = $loader;
	}

    /**
     * Load group
     *
     * @param string $name
     *
     * @return StringTemplateGroup
     */
	public static function loadGroup($name, $lexer, StringTemplateGroup $superGroup)
    {
		if ( $this->groupLoader != null ) {
			return $this->groupLoader->loadGroup($name, $lexer, $superGroup);
		}

        return null;
	}
	
    /**
     * Load interface
     *
     * @param string $name
     *
     * @return StringTemplateGroupInterface
     */
    public static function loadInterface($name) {
		if ( $this->groupLoader != null ) {
			return $this->groupLoader->loadInterface($name);
		}
        
		return null;
	}

    /**
     * Report an error
     *
     * @param string    $message
     * @param Exception $exception
     *
     * @return void
     */
	public function error($message, Exception $exception) {
		if ( $this->listener!=null ) {
            $this->listener->error($message,$exception);
		}
		else {
			echo "StringTemplate: "+$message;
			if ( $exception != null ) {
				$exception->getTraceAsString();
			}
		}
	}

    /**
     * Get template names
     *
     * @return array
     */
	public function getTemplateNames() {
		return array_keys($this->templates);
	}

	/**
     * Indicate whether ST should emit <templatename>...</templatename>
	 * strings for debugging around output for templates from this group.
     *
     * @param boolean $emit
     *
     * @return StringTemplateGroup
	 */
	public function emitDebugStartStopStrings($emit)
    {
		$this->debugTemplateOutput = $emit;

        return $this;
     }

    /**
     * Do not emit debug strings for template
     *
     * @param strign $templateName
     */
	public function doNotEmitDebugStringsForTemplate($templateName) {
		if ( $this->noDebugStartStopStrings==null ) {
			$this->noDebugStartStopStrings = array();
		}
		$this->noDebugStartStopStrings[] = $templateName;
        
        return $this;
	}

    /**
     * Emit template start debug string
     *
     * @param StringTemplate $stringTemplate
     * @param StringTemplateWriter $out
     *
     * @return StringTemplateGroup
     * @throws Exception
     */
	public function emitTemplateStartDebugString(StringTemplate $stringTemplate, StringTemplateWriter $out)
    {
		if ( $this->noDebugStartStopStrings==null
            || !in_array($stringTemplate->getName(), $this->noDebugStartStopStrings) ) {
			$groupPrefix = "";
			if ( strpos($stringTemplate->getName(), "if") !== 0 && strpos($stringTemplate->getName(), "else") !==0 ) {
				if ( $stringTemplate->getNativeGroup() != null ) {
					$groupPrefix = $stringTemplate->getNativeGroup()->getName()+".";
				}
				else {
					$groupPrefix = $stringTemplate->getGroup()->getName()+".";
				}
			}
			$out->write("<" . $groupPrefix . StringTemplate.getName() . ">");
		}

        return $this;
	}

    /**
     * Emit template stop debug string
     *
     * @param StringTemplate $stringTemplate
     * @param StringTemplateWriter $out
     *
     * @return StringTemplateGroup
     * @throws Exception
     */
	public function emitTemplateStopDebugString(StringTemplate $stringTemplate,
											StringTemplateWriter $out)
	{
		if ( $this->noDebugStartStopStrings==null
            || !in_array($stringTemplate->getName(), $this->noDebugStartStopStrings) ) {
			$groupPrefix = "";
			if ( strpos($stringTemplate->getName(), "if") !== 0 && strpos($stringTemplate->getName(), "else") !==0 ) {
				if ( $stringTemplate->getNativeGroup() != null ) {
					$groupPrefix = $stringTemplate->getNativeGroup()->getName()+".";
				}
				else {
					$groupPrefix = $stringTemplate->getGroup()->getName()+".";
				}
			}
			out.write("</" . $groupPrefix . $st->getName() . ">");
		}
	}

    /**
     * Check if template is not marked as not existion one
     *
     * @param String Template $stringTemplate
     *
     * @return boolean false if instance of the argument equals to a
     *                 non-existing constant
     */
    public function templateExists($stringTemplate)
    {
        return spl_object_hash(self::$NOT_FOUND_ST) != spl_object_hash($stringTemplate);
    }

    /**
     * Render template and return its result as a string
     *
     * @param boolean $showTemplatePatterns
     *
     * @return String
     */
	public function toString($showTemplatePatterns = true)
    {
        $buffer = new StringBuffer();
		$templateNames = $this->getTemplateNames();
		sort($templateNames);

		$buffe->append("group " . $this->getName() . ";\n");
        $formalArgs = new StringTemplate('$args;separator=\",\"$');
		foreach($templateNames as $templateName) {
			$stringTemplate = $this->templates[$templateName];
			if ( $this->templateExists($stringTemplate) ) {
				$formalArgs = formalArgs.getInstanceOf();
				$formalArgs.setAttribute("args", $stringTemplate->getFormalArguments());
				$buffer->append($templateName . "(" . $formalArgs .")");
				if ( $showTemplatePatterns ) {
					$buffer->append(" ::= <<");
					$buffer->append($string->getTemplate());
					$buffer->append(">>\n");
				}
				else {
					$buffer->append('\n');
				}
			}
		}
        
		return $buffer->toString();
	}

    /**
     * Magical alias for toString
     * 
     * @param boolean $showTemplatePatterns
     *
     * @return String
     */
    public function __toString()
    {
        return $this->toString(true);
    }
}


// mark a non-existend instance
StringTemplateGroup::$NOT_FOUND_ST = new StringTemplate();