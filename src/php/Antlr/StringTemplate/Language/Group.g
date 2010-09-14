/*
 [The "BSD licence"]
 Copyright (c) 2003-2004 Terence Parr
 Copyright (c) 2009 Yauhen Yakimovich
 All rights reserved.

 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions
 are met:
 1. Redistributions of source code must retain the above copyright
    notice, this list of conditions and the following disclaimer.
 2. Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in the
    documentation and/or other materials provided with the distribution.
 3. The name of the author may not be used to endorse or promote products
    derived from this software without specific prior written permission.

 THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
 IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,
 INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

/** Match a group of template definitions beginning
 *  with a group name declaration.  Templates are enclosed
 *  in double-quotes or <<...>> quotes for multi-line templates.
 *  Template names have arg lists that indicate the cardinality
 *  of the attribute: present, optional, zero-or-more, one-or-more.
 *  Here is a sample group file:

	group nfa;

	// an NFA has edges and states
	nfa(states,edges) ::= <<
	digraph NFA {
	rankdir=LR;
	<states; separator="\\n">
	<edges; separator="\\n">
	}
	>>

	state(name) ::= "node [shape = circle]; <name>;"

 */
grammar Group;

options {
    language=Php;
    k=3;
    //charVocabulary = '\u0000'..'\uFFFE';
    //testLiterals=false;
}

@parser::members {
    
    protected StringTemplateGroup \$group;

    public void reportError(Exception \$exception) {
    	if ( \$this->group!=null ) {
	        \$group->error("template group parse error", \$exception);
    	} else {
	        echo "template group parse error: " . \$exception;
	    }
    }
}

group[StringTemplateGroup g]
@init{
    \$this->group = \$g;
}
    : 'group' name=ID {\$g->setName(\$name->getText());}
    ( COLON s=ID {\$g->setSuperGroup(\$s->getText());} )?
    ( 'implements' i=ID {\$g->implementInterface(\$i->getText());}
      (COMMA i2=ID {\$g->implementInterface(\$i2->getText());} )*
    )? SEMI  ( template[g] | mapdef[g] )+
    ;

template[StringTemplateGroup g]
@init {
    /* @var array \$formalArgs */
    \$formalArgs = null;
    /* @var StringTemplate \$st */
    \$st = null;
    \$ignore = false;
    /* @var string \$templateName */
    \$templateName=null;
    \$line = \$this->LT(1)->getLine();
}
    : ( AT enclosing=ID DOT region=ID
	    {
            \$templateName = \$g->getMangledRegionName(\$enclosing->getText(), \$region->getText());
            if ( \$g->isDefinedInThisGroup(\$templateName) ) {
                \$g->error("group ".\$g->getName()." line ".\$line.": redefinition of template region: @".
                \$enclosing->getText().".".\$region->getText());
                \$st = new StringTemplate(); // create bogus template to fill in
            }
            else {
                \$err = false;
                // @template.region() ::= "..."
                \$enclosingST = $g->lookupTemplate($enclosing->getText());
                if ( \$enclosingST==null ) {
                    \$g->error("group ".\$g->getName()." line ".\$line.": reference to region within undefined template: ".
                        \$enclosing->getText());
                    \$err = true;
                }
                if ( !\$enclosingST->containsRegionName(\$region->getText()) ) {
                    \$g->error("group ".\$g->getName()." line ".\$line.": template ".\$enclosing->getText()." has no region called ".
                        \$region->getText());
                    \$err = true;
                } 
                if ( \$err ) {
                    \$st = new StringTemplate();
                } else {
                    \$st = \$g->defineRegionTemplate(\$enclosingST->getText(),
                                                \$region->getText(),
                                                null,
                                                StringTemplate::REGION_EXPLICIT);
                }
            }
        }
    	|	name=ID {\$templateName = \$name->getText();}
			{
			if ( \$g->isDefinedInThisGroup(templateName) ) {
				\$g->error("redefinition of template: ".\$templateName);
				\$st = new StringTemplate(); // create bogus template to fill in
			}
			else {
				\$st = \$g->defineTemplate(\$templateName, null);
			}
			}
		)
        { if ( \$st!=null ) {\$st->setGroupFileLine(\$line);} }
	    LPAREN
	        (args[st]|{\$st->defineEmptyFormalArgumentList();})
	    RPAREN
	    DEFINED_TO_BE
	    (	t=STRING     {\$st->setTemplate(\$t->getText());}
	    |	bt=BIGSTRING {\$st->setTemplate(\$bt->getText());}
	    )

	|   alias=ID DEFINED_TO_BE target=ID
	    {\$g->defineTemplateAlias(\$alias->getText(), \$target->getText());}
	;

args[StringTemplate st]
    :	arg[st] ( COMMA arg[st] )*
	;

arg[StringTemplate st]
@init {
	/* @var StringTemplate \$defaultValue */
	\$defaultValue = null;
}
	:	name=ID
		(	ASSIGN s=STRING
			{
			\$defaultValue=new StringTemplate("\$_val_\$");
			\$defaultValue->setAttribute("_val_", \$s->getText());
			\$defaultValue->defineFormalArgument("_val_");
			\$defaultValue->setName("<".\$st->getName()."'s arg ".\$name->getText()." default value subtemplate>");
			}
		|	ASSIGN bs=ANONYMOUS_TEMPLATE
			{
			\$defaultValue=new StringTemplate(\$st->getGroup(), \$bs->getText());
			\$defaultValue->setName("<".\$st->getName()."'s arg ".\$name->getText()." default value subtemplate>");
			}
		)?
        {\$st->defineFormalArgument(\$name->getText(), defaultValue);}
    ;

/*
suffix returns [int cardinality=FormalArgument.REQUIRED]
    :   OPTIONAL {cardinality=FormalArgument.OPTIONAL;}
    |   STAR     {cardinality=FormalArgument.ZERO_OR_MORE;}
    |   PLUS     {cardinality=FormalArgument.ONE_OR_MORE;}
	|
    ;
    */

mapdef[StringTemplateGroup g]
@init {
    Map m=null;
}
	: name=ID
	  DEFINED_TO_BE m=map
	  {
	    if ( \$g->getMap(\$name->getText())!=null ) {
	        \$g->error("redefinition of map: ".\$name->getText());
	    }
	    else if ( \$g->isDefinedInThisGroup(\$name->getText()) ) {
	        \$g->error("redefinition of template as map: ".\$name->getText());
	    }
	    else {
	    	\$g->defineMap(\$name->getText(), m);
	    }
	    }
	;

map returns [Map mapping=new HashMap()]
	:   LBRACK mapPairs[mapping] RBRACK
	;
	
mapPairs [Map mapping]
    : keyValuePair[mapping] (COMMA keyValuePair[mapping])*
      (COMMA defaultValuePair[mapping])?
    | defaultValuePair[mapping] 
    ;	
	
defaultValuePair[Map mapping]
@init{
StringTemplate v = null;
}	
	:	'default' COLON v=keyValue
        {\$mapping->put(ASTExp::DEFAULT_MAP_VALUE_NAME, \$v);}
	;

keyValuePair[Map mapping]
@init{
StringTemplate v = null;
}
	:	key=STRING COLON v=keyValue {\$mapping->put(\$key->getText(), \$v);}
	;

keyValue returns [StringTemplate value=null]
	:	s1=BIGSTRING	{value = new StringTemplate(group,\$s1->getText());}
	|	s2=STRING		{value = new StringTemplate(group,\$s2->getText());}
	|	k=ID			{\$k->getText() == "key"}?
						{\$value = ASTExpr::MAP_KEY_VALUE;}
	|					{\$value = null;}
	;

/**
 * Lexer grammar
 */

ID 
    : ('a'..'z'|'A'..'Z'|'_') ('a'..'z'|'A'..'Z'|'0'..'9'|'-'|'_')*
    ;

STRING
	:	'"'
		(	'\\' '"'
		|	'\\' ~'"'
		|	{
			String msg = "\\n in string";
    		NoViableAltException e = new NoViableAltException("", 0, 0, input);
			ErrorManager.syntaxError(ErrorType.SYNTAX_ERROR, getSourceName(), e, msg);
			}
			'\n'
		|	~('\\'|'"'|'\n')
		)*
		'"'
	;

BIGSTRING
	:	'<<'
		(	options {greedy=false;}
		:	'\\' '>'  // \> escape
		|	'\\' ~'>'
		|	~'\\'
		)*
        '>>'
        {
            String txt = getText().replaceAll("\\\\>",">");
		    setText(txt);
		}
	;


ANONYMOUS_TEMPLATE
//options {
//    greedy=false;
//}
	:	'{'
        /*{
            List args=null;
            StringTemplateToken t = null;
        }
		(	  // stop when you see the >>
		:	('\r')? '\n' {newline();}                          // else keep
		|	'\\' '}'   // \} escape
		|	.
		)*  */
	    '}'
	;


AT	:	'@' ;
LPAREN: '(' ;
RPAREN: ')' ;
LBRACK: '[' ;
RBRACK: ']' ;
COMMA:  ',' ;
DOT:  '.' ;
DEFINED_TO_BE:  '::=' ;
SEMI:   ';' ;
COLON:  ':' ;
STAR:   '*' ;
PLUS:   '+' ;
ASSIGN:   '=' ;
OPTIONAL : '?' ;

COMMENT
    :   '/*' ( options {greedy=false;} : . )* '*/' {skip();}
    ;

LINE_COMMENT
    :	'//' ~('\n'|'\r')* '\r'? '\n' {skip();}
    ;

WS  :	(' '|'\r'|'\t'|'\n') {skip();} ;
