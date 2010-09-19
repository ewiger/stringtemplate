<?php
// $ANTLR 3.2 Sep 23, 2009 12:02:23 src/php/Antlr/StringTemplate/Language/Group.g 2010-09-19 15:00:56

    namespace Antlr\StringTemplate\Language;


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

use Antlr\Runtime\IntStream;
use Antlr\Runtime\DFA;
use Antlr\Runtime\Parser;
use Antlr\Runtime\Lexer;
use Antlr\Runtime\CommonToken;
use Antlr\Runtime\Set;
use Antlr\Runtime\Token;
use Antlr\Runtime\CharStream;
use Antlr\Runtime\RecognizerSharedState;
use Antlr\Runtime\ParserRuleReturnScope;

use Antlr\Runtime\EarlyExitException;
use Antlr\Runtime\FailedPredicateException;
use Antlr\Runtime\MismatchedRangeException;
use Antlr\Runtime\MismatchedSetException;
use Antlr\Runtime\MismatchedTokenException;
use Antlr\Runtime\NoViableAltException;
use Antlr\Runtime\RecognitionException;
use Antlr\Runtime\UnwantedtokenException;

class GroupParser extends Parser {
    public static $tokenNames = array(
        "<invalid>", "<EOR>", "<DOWN>", "<UP>", "ID", "COLON", "COMMA", "SEMI", "AT", "DOT", "LPAREN", "RPAREN", "DEFINED_TO_BE", "STRING", "BIGSTRING", "ASSIGN", "ANONYMOUS_TEMPLATE", "LBRACK", "RBRACK", "STAR", "PLUS", "OPTIONAL", "COMMENT", "LINE_COMMENT", "WS", "'group'", "'implements'", "'default'"
    );
    public $RBRACK=18;
    public $STAR=19;
    public $LBRACK=17;
    public $T__27=27;
    public $T__26=26;
    public $LINE_COMMENT=23;
    public $T__25=25;
    public $ANONYMOUS_TEMPLATE=16;
    public $ID=4;
    public $EOF=-1;
    public $SEMI=7;
    public $LPAREN=10;
    public $OPTIONAL=21;
    public $COLON=5;
    public $AT=8;
    public $RPAREN=11;
    public $WS=24;
    public $DEFINED_TO_BE=12;
    public $COMMA=6;
    public $BIGSTRING=14;
    public $ASSIGN=15;
    public $PLUS=20;
    public $COMMENT=22;
    public $DOT=9;
    public $STRING=13;

    // delegates
    // delegators


    static public $FOLLOW_25_in_group71 = array(4 => 4);
    static public $FOLLOW_ID_in_group75 = array(5 => 5, 7 => 7, 26 => 26);
    static public $FOLLOW_COLON_in_group85 = array(4 => 4);
    static public $FOLLOW_ID_in_group89 = array(7 => 7, 26 => 26);
    static public $FOLLOW_26_in_group102 = array(4 => 4);
    static public $FOLLOW_ID_in_group106 = array(6 => 6, 7 => 7);
    static public $FOLLOW_COMMA_in_group117 = array(4 => 4);
    static public $FOLLOW_ID_in_group121 = array(6 => 6, 7 => 7);
    static public $FOLLOW_SEMI_in_group135 = array(4 => 4, 8 => 8);
    static public $FOLLOW_template_in_group140 = array(1 => 1, 4 => 4, 8 => 8);
    static public $FOLLOW_mapdef_in_group145 = array(1 => 1, 4 => 4, 8 => 8);
    static public $FOLLOW_AT_in_template174 = array(4 => 4);
    static public $FOLLOW_ID_in_template178 = array(9 => 9);
    static public $FOLLOW_DOT_in_template180 = array(4 => 4);
    static public $FOLLOW_ID_in_template184 = array(10 => 10);
    static public $FOLLOW_ID_in_template202 = array(10 => 10);
    static public $FOLLOW_LPAREN_in_template230 = array(4 => 4, 11 => 11);
    static public $FOLLOW_args_in_template242 = array(11 => 11);
    static public $FOLLOW_RPAREN_in_template253 = array(12 => 12);
    static public $FOLLOW_DEFINED_TO_BE_in_template260 = array(13 => 13, 14 => 14);
    static public $FOLLOW_STRING_in_template271 = array(1 => 1);
    static public $FOLLOW_BIGSTRING_in_template288 = array(1 => 1);
    static public $FOLLOW_ID_in_template307 = array(12 => 12);
    static public $FOLLOW_DEFINED_TO_BE_in_template309 = array(4 => 4);
    static public $FOLLOW_ID_in_template313 = array(1 => 1);
    static public $FOLLOW_arg_in_args335 = array(1 => 1, 6 => 6);
    static public $FOLLOW_COMMA_in_args340 = array(4 => 4);
    static public $FOLLOW_arg_in_args342 = array(1 => 1, 6 => 6);
    static public $FOLLOW_ID_in_arg365 = array(1 => 1, 15 => 15);
    static public $FOLLOW_ASSIGN_in_arg371 = array(13 => 13);
    static public $FOLLOW_STRING_in_arg375 = array(1 => 1);
    static public $FOLLOW_ASSIGN_in_arg386 = array(16 => 16);
    static public $FOLLOW_ANONYMOUS_TEMPLATE_in_arg390 = array(1 => 1);
    static public $FOLLOW_ID_in_mapdef435 = array(12 => 12);
    static public $FOLLOW_DEFINED_TO_BE_in_mapdef440 = array(17 => 17);
    static public $FOLLOW_map_in_mapdef444 = array(1 => 1);
    static public $FOLLOW_LBRACK_in_map466 = array(13 => 13, 27 => 27);
    static public $FOLLOW_mapPairs_in_map468 = array(18 => 18);
    static public $FOLLOW_RBRACK_in_map471 = array(1 => 1);
    static public $FOLLOW_keyValuePair_in_mapPairs488 = array(1 => 1, 6 => 6);
    static public $FOLLOW_COMMA_in_mapPairs492 = array(13 => 13);
    static public $FOLLOW_keyValuePair_in_mapPairs494 = array(1 => 1, 6 => 6);
    static public $FOLLOW_COMMA_in_mapPairs506 = array(13 => 13, 27 => 27);
    static public $FOLLOW_defaultValuePair_in_mapPairs508 = array(1 => 1);
    static public $FOLLOW_defaultValuePair_in_mapPairs519 = array(1 => 1);
    static public $FOLLOW_27_in_defaultValuePair543 = array(5 => 5);
    static public $FOLLOW_COLON_in_defaultValuePair545 = array(4 => 4, 13 => 13, 14 => 14);
    static public $FOLLOW_keyValue_in_defaultValuePair549 = array(1 => 1);
    static public $FOLLOW_STRING_in_keyValuePair577 = array(5 => 5);
    static public $FOLLOW_COLON_in_keyValuePair579 = array(4 => 4, 13 => 13, 14 => 14);
    static public $FOLLOW_keyValue_in_keyValuePair583 = array(1 => 1);
    static public $FOLLOW_BIGSTRING_in_keyValue602 = array(1 => 1);
    static public $FOLLOW_STRING_in_keyValue611 = array(1 => 1);
    static public $FOLLOW_ID_in_keyValue621 = array(1 => 1);




        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);

        }
        

    public function getTokenNames() { return GroupParser::$tokenNames; }
    public function getGrammarFileName() { return "src/php/Antlr/StringTemplate/Language/Group.g"; }


        
        protected StringTemplateGroup $group;

        public void reportError(Exception $exception) {
        	if ( $this->group!=null ) {
    	        $group->error("template group parse error", $exception);
        	} else {
    	        echo "template group parse error: " . $exception;
    	    }
        }



    // $ANTLR start "group"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function group($StringTemplateGroup g){
        $name = null;
        $s = null;
        $i = null;
        $i2 = null;


            $this->group = $g;

        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->match($this->input,$this->getToken('25'),self::$FOLLOW_25_in_group71); 
            $name=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_group75); 
              $g->setName($name->getText());
            // src/php/Antlr/StringTemplate/Language/Group.g
            $alt1=2;
            $LA1_0 = $this->input->LA(1);

            if ( ($LA1_0==$this->getToken('COLON')) ) {
                $alt1=1;
            }
            switch ($alt1) {
                case 1 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $this->match($this->input,$this->getToken('COLON'),self::$FOLLOW_COLON_in_group85); 
                    $s=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_group89); 
                      $g->setSuperGroup($s->getText());

                    }
                    break;

            }

            // src/php/Antlr/StringTemplate/Language/Group.g
            $alt3=2;
            $LA3_0 = $this->input->LA(1);

            if ( ($LA3_0==$this->getToken('26')) ) {
                $alt3=1;
            }
            switch ($alt3) {
                case 1 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $this->match($this->input,$this->getToken('26'),self::$FOLLOW_26_in_group102); 
                    $i=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_group106); 
                      $g->implementInterface($i->getText());
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    //loop2:
                    do {
                        $alt2=2;
                        $LA2_0 = $this->input->LA(1);

                        if ( ($LA2_0==$this->getToken('COMMA')) ) {
                            $alt2=1;
                        }


                        switch ($alt2) {
                    	case 1 :
                    	    // src/php/Antlr/StringTemplate/Language/Group.g
                    	    {
                    	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_group117); 
                    	    $i2=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_group121); 
                    	      $g->implementInterface($i2->getText());

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop2;
                        }
                    } while (true);


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('SEMI'),self::$FOLLOW_SEMI_in_group135); 
            // src/php/Antlr/StringTemplate/Language/Group.g
            $cnt4=0;
            //loop4:
            do {
                $alt4=3;
                $LA4_0 = $this->input->LA(1);

                if ( ($LA4_0==$this->getToken('AT')) ) {
                    $alt4=1;
                }
                else if ( ($LA4_0==$this->getToken('ID')) ) {
                    $LA4_3 = $this->input->LA(2);

                    if ( ($LA4_3==$this->getToken('DEFINED_TO_BE')) ) {
                        $LA4_4 = $this->input->LA(3);

                        if ( ($LA4_4==$this->getToken('ID')) ) {
                            $alt4=1;
                        }
                        else if ( ($LA4_4==$this->getToken('LBRACK')) ) {
                            $alt4=2;
                        }


                    }
                    else if ( ($LA4_3==$this->getToken('LPAREN')) ) {
                        $alt4=1;
                    }


                }


                switch ($alt4) {
            	case 1 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    $this->pushFollow(self::$FOLLOW_template_in_group140);
            	    $this->template(g);

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    $this->pushFollow(self::$FOLLOW_mapdef_in_group145);
            	    $this->mapdef(g);

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt4 >= 1 ) break 2;//loop4;
                        $eee =
                            new EarlyExitException(4, $this->input);
                        throw $eee;
                }
                $cnt4++;
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return ;
    }
    // $ANTLR end "group"

    public static function template_return() {
        $retval = new ParserRuleReturnScope();
    	return $retval;
    }

    // $ANTLR start "template"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function template($StringTemplateGroup g){
        $retval = $this->template_return();
        $retval->start = $this->input->LT(1);


        $enclosing = null;
        $region = null;
        $name = null;
        $t = null;
        $bt = null;
        $alias = null;
        $target = null;


            /* @var array $formalArgs */
            $formalArgs = null;
            /* @var StringTemplate $st */
            $st = null;
            $ignore = false;
            /* @var string $templateName */
            $templateName=null;
            $line = $this->LT(1)->getLine();

        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            $alt8=2;
            $LA8_0 = $this->input->LA(1);

            if ( ($LA8_0==$this->getToken('AT')) ) {
                $alt8=1;
            }
            else if ( ($LA8_0==$this->getToken('ID')) ) {
                $LA8_2 = $this->input->LA(2);

                if ( ($LA8_2==$this->getToken('DEFINED_TO_BE')) ) {
                    $alt8=2;
                }
                else if ( ($LA8_2==$this->getToken('LPAREN')) ) {
                    $alt8=1;
                }
                else {
                    $nvae = new NoViableAltException("", 8, 2, $this->input);

                    throw $nvae;
                }
            }
            else {
                $nvae = new NoViableAltException("", 8, 0, $this->input);

                throw $nvae;
            }
            switch ($alt8) {
                case 1 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    $alt5=2;
                    $LA5_0 = $this->input->LA(1);

                    if ( ($LA5_0==$this->getToken('AT')) ) {
                        $alt5=1;
                    }
                    else if ( ($LA5_0==$this->getToken('ID')) ) {
                        $alt5=2;
                    }
                    else {
                        $nvae = new NoViableAltException("", 5, 0, $this->input);

                        throw $nvae;
                    }
                    switch ($alt5) {
                        case 1 :
                            // src/php/Antlr/StringTemplate/Language/Group.g
                            {
                            $this->match($this->input,$this->getToken('AT'),self::$FOLLOW_AT_in_template174); 
                            $enclosing=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template178); 
                            $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_template180); 
                            $region=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template184); 

                                          $templateName = $g->getMangledRegionName($enclosing->getText(), $region->getText());
                                          if ( $g->isDefinedInThisGroup($templateName) ) {
                                              $g->error("group ".$g->getName()." line ".$line.": redefinition of template region: @".
                                              $enclosing->getText().".".$region->getText());
                                              $st = new StringTemplate(); // create bogus template to fill in
                                          }
                                          else {
                                              $err = false;
                                              // @template.region() ::= "..."
                                              $enclosingST = g->lookupTemplate(enclosing->getText());
                                              if ( $enclosingST==null ) {
                                                  $g->error("group ".$g->getName()." line ".$line.": reference to region within undefined template: ".
                                                      $enclosing->getText());
                                                  $err = true;
                                              }
                                              if ( !$enclosingST->containsRegionName($region->getText()) ) {
                                                  $g->error("group ".$g->getName()." line ".$line.": template ".$enclosing->getText()." has no region called ".
                                                      $region->getText());
                                                  $err = true;
                                              } 
                                              if ( $err ) {
                                                  $st = new StringTemplate();
                                              } else {
                                                  $st = $g->defineRegionTemplate($enclosingST->getText(),
                                                                              $region->getText(),
                                                                              null,
                                                                              StringTemplate::REGION_EXPLICIT);
                                              }
                                          }
                                      

                            }
                            break;
                        case 2 :
                            // src/php/Antlr/StringTemplate/Language/Group.g
                            {
                            $name=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template202); 
                              $templateName = $name->getText();

                              			if ( $g->isDefinedInThisGroup(templateName) ) {
                              				$g->error("redefinition of template: ".$templateName);
                              				$st = new StringTemplate(); // create bogus template to fill in
                              			}
                              			else {
                              				$st = $g->defineTemplate($templateName, null);
                              			}
                              			

                            }
                            break;

                    }

                       if ( $st!=null ) {$st->setGroupFileLine($line);} 
                    $this->match($this->input,$this->getToken('LPAREN'),self::$FOLLOW_LPAREN_in_template230); 
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    $alt6=2;
                    $LA6_0 = $this->input->LA(1);

                    if ( ($LA6_0==$this->getToken('ID')) ) {
                        $alt6=1;
                    }
                    else if ( ($LA6_0==$this->getToken('RPAREN')) ) {
                        $alt6=2;
                    }
                    else {
                        $nvae = new NoViableAltException("", 6, 0, $this->input);

                        throw $nvae;
                    }
                    switch ($alt6) {
                        case 1 :
                            // src/php/Antlr/StringTemplate/Language/Group.g
                            {
                            $this->pushFollow(self::$FOLLOW_args_in_template242);
                            $this->args(st);

                            $this->state->_fsp--;


                            }
                            break;
                        case 2 :
                            // src/php/Antlr/StringTemplate/Language/Group.g
                            {
                              $st->defineEmptyFormalArgumentList();

                            }
                            break;

                    }

                    $this->match($this->input,$this->getToken('RPAREN'),self::$FOLLOW_RPAREN_in_template253); 
                    $this->match($this->input,$this->getToken('DEFINED_TO_BE'),self::$FOLLOW_DEFINED_TO_BE_in_template260); 
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    $alt7=2;
                    $LA7_0 = $this->input->LA(1);

                    if ( ($LA7_0==$this->getToken('STRING')) ) {
                        $alt7=1;
                    }
                    else if ( ($LA7_0==$this->getToken('BIGSTRING')) ) {
                        $alt7=2;
                    }
                    else {
                        $nvae = new NoViableAltException("", 7, 0, $this->input);

                        throw $nvae;
                    }
                    switch ($alt7) {
                        case 1 :
                            // src/php/Antlr/StringTemplate/Language/Group.g
                            {
                            $t=$this->match($this->input,$this->getToken('STRING'),self::$FOLLOW_STRING_in_template271); 
                              $st->setTemplate($t->getText());

                            }
                            break;
                        case 2 :
                            // src/php/Antlr/StringTemplate/Language/Group.g
                            {
                            $bt=$this->match($this->input,$this->getToken('BIGSTRING'),self::$FOLLOW_BIGSTRING_in_template288); 
                              $st->setTemplate($bt->getText());

                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $alias=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template307); 
                    $this->match($this->input,$this->getToken('DEFINED_TO_BE'),self::$FOLLOW_DEFINED_TO_BE_in_template309); 
                    $target=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template313); 
                      $g->defineTemplateAlias($alias->getText(), $target->getText());

                    }
                    break;

            }
            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return $retval;
    }
    // $ANTLR end "template"


    // $ANTLR start "args"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function args($StringTemplate st){
        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->pushFollow(self::$FOLLOW_arg_in_args335);
            $this->arg(st);

            $this->state->_fsp--;

            // src/php/Antlr/StringTemplate/Language/Group.g
            //loop9:
            do {
                $alt9=2;
                $LA9_0 = $this->input->LA(1);

                if ( ($LA9_0==$this->getToken('COMMA')) ) {
                    $alt9=1;
                }


                switch ($alt9) {
            	case 1 :
            	    // src/php/Antlr/StringTemplate/Language/Group.g
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_args340); 
            	    $this->pushFollow(self::$FOLLOW_arg_in_args342);
            	    $this->arg(st);

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop9;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return ;
    }
    // $ANTLR end "args"


    // $ANTLR start "arg"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function arg($StringTemplate st){
        $name = null;
        $s = null;
        $bs = null;


        	/* @var StringTemplate $defaultValue */
        	$defaultValue = null;

        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $name=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_arg365); 
            // src/php/Antlr/StringTemplate/Language/Group.g
            $alt10=3;
            $LA10_0 = $this->input->LA(1);

            if ( ($LA10_0==$this->getToken('ASSIGN')) ) {
                $LA10_1 = $this->input->LA(2);

                if ( ($LA10_1==$this->getToken('STRING')) ) {
                    $alt10=1;
                }
                else if ( ($LA10_1==$this->getToken('ANONYMOUS_TEMPLATE')) ) {
                    $alt10=2;
                }
            }
            switch ($alt10) {
                case 1 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $this->match($this->input,$this->getToken('ASSIGN'),self::$FOLLOW_ASSIGN_in_arg371); 
                    $s=$this->match($this->input,$this->getToken('STRING'),self::$FOLLOW_STRING_in_arg375); 

                      			$defaultValue=new StringTemplate("$_val_$");
                      			$defaultValue->setAttribute("_val_", $s->getText());
                      			$defaultValue->defineFormalArgument("_val_");
                      			$defaultValue->setName("<".$st->getName()."'s arg ".$name->getText()." default value subtemplate>");
                      			

                    }
                    break;
                case 2 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $this->match($this->input,$this->getToken('ASSIGN'),self::$FOLLOW_ASSIGN_in_arg386); 
                    $bs=$this->match($this->input,$this->getToken('ANONYMOUS_TEMPLATE'),self::$FOLLOW_ANONYMOUS_TEMPLATE_in_arg390); 

                      			$defaultValue=new StringTemplate($st->getGroup(), $bs->getText());
                      			$defaultValue->setName("<".$st->getName()."'s arg ".$name->getText()." default value subtemplate>");
                      			

                    }
                    break;

            }

              $st->defineFormalArgument($name->getText(), defaultValue);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return ;
    }
    // $ANTLR end "arg"


    // $ANTLR start "mapdef"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function mapdef($StringTemplateGroup g){
        $name = null;
        $m = null;



            Map m=null;

        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $name=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_mapdef435); 
            $this->match($this->input,$this->getToken('DEFINED_TO_BE'),self::$FOLLOW_DEFINED_TO_BE_in_mapdef440); 
            $this->pushFollow(self::$FOLLOW_map_in_mapdef444);
            $m = $this->map();

            $this->state->_fsp--;


              	    if ( $g->getMap($name->getText())!=null ) {
              	        $g->error("redefinition of map: ".$name->getText());
              	    }
              	    else if ( $g->isDefinedInThisGroup($name->getText()) ) {
              	        $g->error("redefinition of template as map: ".$name->getText());
              	    }
              	    else {
              	    	$g->defineMap($name->getText(), m);
              	    }
              	    

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return ;
    }
    // $ANTLR end "mapdef"


    // $ANTLR start "map"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function map(){
        $mapping = new HashMap();

        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->match($this->input,$this->getToken('LBRACK'),self::$FOLLOW_LBRACK_in_map466); 
            $this->pushFollow(self::$FOLLOW_mapPairs_in_map468);
            $this->mapPairs(mapping);

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('RBRACK'),self::$FOLLOW_RBRACK_in_map471); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return $mapping;
    }
    // $ANTLR end "map"


    // $ANTLR start "mapPairs"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function mapPairs($Map mapping){
        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            $alt13=2;
            $LA13_0 = $this->input->LA(1);

            if ( ($LA13_0==$this->getToken('STRING')) ) {
                $alt13=1;
            }
            else if ( ($LA13_0==$this->getToken('27')) ) {
                $alt13=2;
            }
            else {
                $nvae = new NoViableAltException("", 13, 0, $this->input);

                throw $nvae;
            }
            switch ($alt13) {
                case 1 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $this->pushFollow(self::$FOLLOW_keyValuePair_in_mapPairs488);
                    $this->keyValuePair(mapping);

                    $this->state->_fsp--;

                    // src/php/Antlr/StringTemplate/Language/Group.g
                    //loop11:
                    do {
                        $alt11=2;
                        $LA11_0 = $this->input->LA(1);

                        if ( ($LA11_0==$this->getToken('COMMA')) ) {
                            $LA11_1 = $this->input->LA(2);

                            if ( ($LA11_1==$this->getToken('STRING')) ) {
                                $alt11=1;
                            }


                        }


                        switch ($alt11) {
                    	case 1 :
                    	    // src/php/Antlr/StringTemplate/Language/Group.g
                    	    {
                    	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_mapPairs492); 
                    	    $this->pushFollow(self::$FOLLOW_keyValuePair_in_mapPairs494);
                    	    $this->keyValuePair(mapping);

                    	    $this->state->_fsp--;


                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop11;
                        }
                    } while (true);

                    // src/php/Antlr/StringTemplate/Language/Group.g
                    $alt12=2;
                    $LA12_0 = $this->input->LA(1);

                    if ( ($LA12_0==$this->getToken('COMMA')) ) {
                        $alt12=1;
                    }
                    switch ($alt12) {
                        case 1 :
                            // src/php/Antlr/StringTemplate/Language/Group.g
                            {
                            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_mapPairs506); 
                            $this->pushFollow(self::$FOLLOW_defaultValuePair_in_mapPairs508);
                            $this->defaultValuePair(mapping);

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $this->pushFollow(self::$FOLLOW_defaultValuePair_in_mapPairs519);
                    $this->defaultValuePair(mapping);

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return ;
    }
    // $ANTLR end "mapPairs"


    // $ANTLR start "defaultValuePair"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function defaultValuePair($Map mapping){
        $v = null;



        StringTemplate v = null;

        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $this->match($this->input,$this->getToken('27'),self::$FOLLOW_27_in_defaultValuePair543); 
            $this->match($this->input,$this->getToken('COLON'),self::$FOLLOW_COLON_in_defaultValuePair545); 
            $this->pushFollow(self::$FOLLOW_keyValue_in_defaultValuePair549);
            $v = $this->keyValue();

            $this->state->_fsp--;

              $mapping->put(ASTExp::DEFAULT_MAP_VALUE_NAME, $v);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return ;
    }
    // $ANTLR end "defaultValuePair"


    // $ANTLR start "keyValuePair"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function keyValuePair($Map mapping){
        $key = null;
        $v = null;



        StringTemplate v = null;

        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            // src/php/Antlr/StringTemplate/Language/Group.g
            {
            $key=$this->match($this->input,$this->getToken('STRING'),self::$FOLLOW_STRING_in_keyValuePair577); 
            $this->match($this->input,$this->getToken('COLON'),self::$FOLLOW_COLON_in_keyValuePair579); 
            $this->pushFollow(self::$FOLLOW_keyValue_in_keyValuePair583);
            $v = $this->keyValue();

            $this->state->_fsp--;

              $mapping->put($key->getText(), $v);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return ;
    }
    // $ANTLR end "keyValuePair"


    // $ANTLR start "keyValue"
    // src/php/Antlr/StringTemplate/Language/Group.g
    public function keyValue(){
        $value = null;

        $s1 = null;
        $s2 = null;
        $k = null;

        try {
            // src/php/Antlr/StringTemplate/Language/Group.g
            $alt14=4;
            $LA14 = $this->input->LA(1);
            if($this->getToken('BIGSTRING')== $LA14)
                {
                $alt14=1;
                }
            else if($this->getToken('STRING')== $LA14)
                {
                $alt14=2;
                }
            else if($this->getToken('ID')== $LA14)
                {
                $alt14=3;
                }
            else if($this->getToken('COMMA')== $LA14||$this->getToken('RBRACK')== $LA14)
                {
                $alt14=4;
                }
            else{
                $nvae =
                    new NoViableAltException("", 14, 0, $this->input);

                throw $nvae;
            }

            switch ($alt14) {
                case 1 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $s1=$this->match($this->input,$this->getToken('BIGSTRING'),self::$FOLLOW_BIGSTRING_in_keyValue602); 
                      value = new StringTemplate(group,$s1->getText());

                    }
                    break;
                case 2 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $s2=$this->match($this->input,$this->getToken('STRING'),self::$FOLLOW_STRING_in_keyValue611); 
                      value = new StringTemplate(group,$s2->getText());

                    }
                    break;
                case 3 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                    $k=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_keyValue621); 
                    if ( !(($k->getText() == "key")) ) {
                        throw new FailedPredicateException($this->input, "keyValue", '\\$k->getText() == \"key\"');
                    }
                      $value = ASTExpr::MAP_KEY_VALUE;

                    }
                    break;
                case 4 :
                    // src/php/Antlr/StringTemplate/Language/Group.g
                    {
                      $value = null;

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }

        return $value;
    }
    // $ANTLR end "keyValue"

    // Delegated rules



}

 
?>