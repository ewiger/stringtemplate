<?php
// $ANTLR 3.2 Sep 23, 2009 12:02:23 Group.g 2010-06-20 00:50:44

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

# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class GroupParser extends AntlrParser {
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

    
    static $FOLLOW_25_in_group66;
    static $FOLLOW_ID_in_group70;
    static $FOLLOW_COLON_in_group80;
    static $FOLLOW_ID_in_group84;
    static $FOLLOW_26_in_group97;
    static $FOLLOW_ID_in_group101;
    static $FOLLOW_COMMA_in_group112;
    static $FOLLOW_ID_in_group116;
    static $FOLLOW_SEMI_in_group130;
    static $FOLLOW_template_in_group135;
    static $FOLLOW_mapdef_in_group140;
    static $FOLLOW_AT_in_template169;
    static $FOLLOW_ID_in_template173;
    static $FOLLOW_DOT_in_template175;
    static $FOLLOW_ID_in_template179;
    static $FOLLOW_ID_in_template197;
    static $FOLLOW_LPAREN_in_template225;
    static $FOLLOW_args_in_template237;
    static $FOLLOW_RPAREN_in_template248;
    static $FOLLOW_DEFINED_TO_BE_in_template255;
    static $FOLLOW_STRING_in_template266;
    static $FOLLOW_BIGSTRING_in_template283;
    static $FOLLOW_ID_in_template302;
    static $FOLLOW_DEFINED_TO_BE_in_template304;
    static $FOLLOW_ID_in_template308;
    static $FOLLOW_arg_in_args330;
    static $FOLLOW_COMMA_in_args335;
    static $FOLLOW_arg_in_args337;
    static $FOLLOW_ID_in_arg360;
    static $FOLLOW_ASSIGN_in_arg366;
    static $FOLLOW_STRING_in_arg370;
    static $FOLLOW_ASSIGN_in_arg381;
    static $FOLLOW_ANONYMOUS_TEMPLATE_in_arg385;
    static $FOLLOW_ID_in_mapdef430;
    static $FOLLOW_DEFINED_TO_BE_in_mapdef435;
    static $FOLLOW_map_in_mapdef439;
    static $FOLLOW_LBRACK_in_map461;
    static $FOLLOW_mapPairs_in_map463;
    static $FOLLOW_RBRACK_in_map466;
    static $FOLLOW_keyValuePair_in_mapPairs483;
    static $FOLLOW_COMMA_in_mapPairs487;
    static $FOLLOW_keyValuePair_in_mapPairs489;
    static $FOLLOW_COMMA_in_mapPairs501;
    static $FOLLOW_defaultValuePair_in_mapPairs503;
    static $FOLLOW_defaultValuePair_in_mapPairs514;
    static $FOLLOW_27_in_defaultValuePair538;
    static $FOLLOW_COLON_in_defaultValuePair540;
    static $FOLLOW_keyValue_in_defaultValuePair544;
    static $FOLLOW_STRING_in_keyValuePair572;
    static $FOLLOW_COLON_in_keyValuePair574;
    static $FOLLOW_keyValue_in_keyValuePair578;
    static $FOLLOW_BIGSTRING_in_keyValue597;
    static $FOLLOW_STRING_in_keyValue606;
    static $FOLLOW_ID_in_keyValue616;

    
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
             
            
            
        }
        

    public function getTokenNames() { return GroupParser::$tokenNames; }
    public function getGrammarFileName() { return "Group.g"; }


        
        protected StringTemplateGroup $group;

        public void reportError(Exception $exception) {
        	if ( $this->group!=null ) {
    	        $group->error("template group parse error", $exception);
        	} else {
    	        echo "template group parse error: " . $exception;
    	    }
        }



    // $ANTLR start "group"
    // Group.g:72:1: group[StringTemplateGroup g] : 'group' name= ID ( COLON s= ID )? ( 'implements' i= ID ( COMMA i2= ID )* )? SEMI ( template[g] | mapdef[g] )+ ; 
    public function group(StringTemplateGroup g){
        $name=null;
        $s=null;
        $i=null;
        $i2=null;


            $this->group = $g;

        try {
            // Group.g:76:5: ( 'group' name= ID ( COLON s= ID )? ( 'implements' i= ID ( COMMA i2= ID )* )? SEMI ( template[g] | mapdef[g] )+ ) 
            // Group.g:76:7: 'group' name= ID ( COLON s= ID )? ( 'implements' i= ID ( COMMA i2= ID )* )? SEMI ( template[g] | mapdef[g] )+ 
            {
            $this->match($this->input,$this->getToken('25'),self::$FOLLOW_25_in_group66); 
            $name=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_group70); 
              $g->setName($name->getText());
            // Group.g:77:5: ( COLON s= ID )? 
            $alt1=2;
            $LA1_0 = $this->input->LA(1);

            if ( ($LA1_0==$this->getToken('COLON')) ) {
                $alt1=1;
            }
            switch ($alt1) {
                case 1 :
                    // Group.g:77:7: COLON s= ID 
                    {
                    $this->match($this->input,$this->getToken('COLON'),self::$FOLLOW_COLON_in_group80); 
                    $s=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_group84); 
                      $g->setSuperGroup($s->getText());

                    }
                    break;

            }

            // Group.g:78:5: ( 'implements' i= ID ( COMMA i2= ID )* )? 
            $alt3=2;
            $LA3_0 = $this->input->LA(1);

            if ( ($LA3_0==$this->getToken('26')) ) {
                $alt3=1;
            }
            switch ($alt3) {
                case 1 :
                    // Group.g:78:7: 'implements' i= ID ( COMMA i2= ID )* 
                    {
                    $this->match($this->input,$this->getToken('26'),self::$FOLLOW_26_in_group97); 
                    $i=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_group101); 
                      $g->implementInterface($i->getText());
                    // Group.g:79:7: ( COMMA i2= ID )* 
                    //loop2:
                    do {
                        $alt2=2;
                        $LA2_0 = $this->input->LA(1);

                        if ( ($LA2_0==$this->getToken('COMMA')) ) {
                            $alt2=1;
                        }


                        switch ($alt2) {
                    	case 1 :
                    	    // Group.g:79:8: COMMA i2= ID 
                    	    {
                    	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_group112); 
                    	    $i2=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_group116); 
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

            $this->match($this->input,$this->getToken('SEMI'),self::$FOLLOW_SEMI_in_group130); 
            // Group.g:80:14: ( template[g] | mapdef[g] )+ 
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
            	    // Group.g:80:16: template[g] 
            	    {
            	    $this->pushFollow(self::$FOLLOW_template_in_group135);
            	    $this->template(g);

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // Group.g:80:30: mapdef[g] 
            	    {
            	    $this->pushFollow(self::$FOLLOW_mapdef_in_group140);
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

    public static class template_return extends ParserRuleReturnScope {
    };

    // $ANTLR start "template"
    // Group.g:83:1: template[StringTemplateGroup g] : ( ( AT enclosing= ID DOT region= ID | name= ID ) LPAREN ( args[st] | ) RPAREN DEFINED_TO_BE (t= STRING | bt= BIGSTRING ) | alias= ID DEFINED_TO_BE target= ID ); 
    public function template(StringTemplateGroup g){
        $retval = new GroupParser.template_return();
        $retval->start = $this->input->LT(1);

        $enclosing=null;
        $region=null;
        $name=null;
        $t=null;
        $bt=null;
        $alias=null;
        $target=null;


            /* @var array $formalArgs */
            $formalArgs = null;
            /* @var StringTemplate $st */
            $st = null;
            $ignore = false;
            /* @var string $templateName */
            $templateName=null;
            $line = $this->LT(1)->getLine();

        try {
            // Group.g:94:5: ( ( AT enclosing= ID DOT region= ID | name= ID ) LPAREN ( args[st] | ) RPAREN DEFINED_TO_BE (t= STRING | bt= BIGSTRING ) | alias= ID DEFINED_TO_BE target= ID ) 
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
                    // Group.g:94:7: ( AT enclosing= ID DOT region= ID | name= ID ) LPAREN ( args[st] | ) RPAREN DEFINED_TO_BE (t= STRING | bt= BIGSTRING ) 
                    {
                    // Group.g:94:7: ( AT enclosing= ID DOT region= ID | name= ID ) 
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
                            // Group.g:94:9: AT enclosing= ID DOT region= ID 
                            {
                            $this->match($this->input,$this->getToken('AT'),self::$FOLLOW_AT_in_template169); 
                            $enclosing=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template173); 
                            $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_template175); 
                            $region=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template179); 

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
                            // Group.g:126:8: name= ID 
                            {
                            $name=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template197); 
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
                    $this->match($this->input,$this->getToken('LPAREN'),self::$FOLLOW_LPAREN_in_template225); 
                    // Group.g:139:10: ( args[st] | ) 
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
                            // Group.g:139:11: args[st] 
                            {
                            $this->pushFollow(self::$FOLLOW_args_in_template237);
                            $this->args(st);

                            $this->state->_fsp--;


                            }
                            break;
                        case 2 :
                            // Group.g:139:20:  
                            {
                              $st->defineEmptyFormalArgumentList();

                            }
                            break;

                    }

                    $this->match($this->input,$this->getToken('RPAREN'),self::$FOLLOW_RPAREN_in_template248); 
                    $this->match($this->input,$this->getToken('DEFINED_TO_BE'),self::$FOLLOW_DEFINED_TO_BE_in_template255); 
                    // Group.g:142:6: (t= STRING | bt= BIGSTRING ) 
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
                            // Group.g:142:8: t= STRING 
                            {
                            $t=$this->match($this->input,$this->getToken('STRING'),self::$FOLLOW_STRING_in_template266); 
                              $st->setTemplate($t->getText());

                            }
                            break;
                        case 2 :
                            // Group.g:143:8: bt= BIGSTRING 
                            {
                            $bt=$this->match($this->input,$this->getToken('BIGSTRING'),self::$FOLLOW_BIGSTRING_in_template283); 
                              $st->setTemplate($bt->getText());

                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // Group.g:146:6: alias= ID DEFINED_TO_BE target= ID 
                    {
                    $alias=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template302); 
                    $this->match($this->input,$this->getToken('DEFINED_TO_BE'),self::$FOLLOW_DEFINED_TO_BE_in_template304); 
                    $target=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_template308); 
                      $g->defineTemplateAlias($alias->getText(), $target->getText());

                    }
                    break;

            }
            retval.stop = input.LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return retval;
    }
    // $ANTLR end "template"


    // $ANTLR start "args"
    // Group.g:150:1: args[StringTemplate st] : arg[st] ( COMMA arg[st] )* ; 
    public function args(StringTemplate st){
        try {
            // Group.g:151:5: ( arg[st] ( COMMA arg[st] )* ) 
            // Group.g:151:7: arg[st] ( COMMA arg[st] )* 
            {
            $this->pushFollow(self::$FOLLOW_arg_in_args330);
            $this->arg(st);

            $this->state->_fsp--;

            // Group.g:151:15: ( COMMA arg[st] )* 
            //loop9:
            do {
                $alt9=2;
                $LA9_0 = $this->input->LA(1);

                if ( ($LA9_0==$this->getToken('COMMA')) ) {
                    $alt9=1;
                }


                switch ($alt9) {
            	case 1 :
            	    // Group.g:151:17: COMMA arg[st] 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_args335); 
            	    $this->pushFollow(self::$FOLLOW_arg_in_args337);
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
    // Group.g:154:1: arg[StringTemplate st] : name= ID ( ASSIGN s= STRING | ASSIGN bs= ANONYMOUS_TEMPLATE )? ; 
    public function arg(StringTemplate st){
        $name=null;
        $s=null;
        $bs=null;


        	/* @var StringTemplate $defaultValue */
        	$defaultValue = null;

        try {
            // Group.g:159:2: (name= ID ( ASSIGN s= STRING | ASSIGN bs= ANONYMOUS_TEMPLATE )? ) 
            // Group.g:159:4: name= ID ( ASSIGN s= STRING | ASSIGN bs= ANONYMOUS_TEMPLATE )? 
            {
            $name=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_arg360); 
            // Group.g:160:3: ( ASSIGN s= STRING | ASSIGN bs= ANONYMOUS_TEMPLATE )? 
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
                    // Group.g:160:5: ASSIGN s= STRING 
                    {
                    $this->match($this->input,$this->getToken('ASSIGN'),self::$FOLLOW_ASSIGN_in_arg366); 
                    $s=$this->match($this->input,$this->getToken('STRING'),self::$FOLLOW_STRING_in_arg370); 

                      			$defaultValue=new StringTemplate("$_val_$");
                      			$defaultValue->setAttribute("_val_", $s->getText());
                      			$defaultValue->defineFormalArgument("_val_");
                      			$defaultValue->setName("<".$st->getName()."'s arg ".$name->getText()." default value subtemplate>");
                      			

                    }
                    break;
                case 2 :
                    // Group.g:167:5: ASSIGN bs= ANONYMOUS_TEMPLATE 
                    {
                    $this->match($this->input,$this->getToken('ASSIGN'),self::$FOLLOW_ASSIGN_in_arg381); 
                    $bs=$this->match($this->input,$this->getToken('ANONYMOUS_TEMPLATE'),self::$FOLLOW_ANONYMOUS_TEMPLATE_in_arg385); 

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
    // Group.g:185:1: mapdef[StringTemplateGroup g] : name= ID DEFINED_TO_BE m= map ; 
    public function mapdef(StringTemplateGroup g){
        $name=null;
        $m = null;



            Map m=null;

        try {
            // Group.g:189:2: (name= ID DEFINED_TO_BE m= map ) 
            // Group.g:189:4: name= ID DEFINED_TO_BE m= map 
            {
            $name=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_mapdef430); 
            $this->match($this->input,$this->getToken('DEFINED_TO_BE'),self::$FOLLOW_DEFINED_TO_BE_in_mapdef435); 
            $this->pushFollow(self::$FOLLOW_map_in_mapdef439);
            $m=$this->map();

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
    // Group.g:204:1: map returns [Map mapping=new HashMap()] : LBRACK mapPairs[mapping] RBRACK ; 
    public function map(){
        $mapping = new HashMap();

        try {
            // Group.g:205:2: ( LBRACK mapPairs[mapping] RBRACK ) 
            // Group.g:205:6: LBRACK mapPairs[mapping] RBRACK 
            {
            $this->match($this->input,$this->getToken('LBRACK'),self::$FOLLOW_LBRACK_in_map461); 
            $this->pushFollow(self::$FOLLOW_mapPairs_in_map463);
            $this->mapPairs(mapping);

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('RBRACK'),self::$FOLLOW_RBRACK_in_map466); 

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
    // Group.g:208:1: mapPairs[Map mapping] : ( keyValuePair[mapping] ( COMMA keyValuePair[mapping] )* ( COMMA defaultValuePair[mapping] )? | defaultValuePair[mapping] ); 
    public function mapPairs(Map mapping){
        try {
            // Group.g:209:5: ( keyValuePair[mapping] ( COMMA keyValuePair[mapping] )* ( COMMA defaultValuePair[mapping] )? | defaultValuePair[mapping] ) 
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
                    // Group.g:209:7: keyValuePair[mapping] ( COMMA keyValuePair[mapping] )* ( COMMA defaultValuePair[mapping] )? 
                    {
                    $this->pushFollow(self::$FOLLOW_keyValuePair_in_mapPairs483);
                    $this->keyValuePair(mapping);

                    $this->state->_fsp--;

                    // Group.g:209:29: ( COMMA keyValuePair[mapping] )* 
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
                    	    // Group.g:209:30: COMMA keyValuePair[mapping] 
                    	    {
                    	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_mapPairs487); 
                    	    $this->pushFollow(self::$FOLLOW_keyValuePair_in_mapPairs489);
                    	    $this->keyValuePair(mapping);

                    	    $this->state->_fsp--;


                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop11;
                        }
                    } while (true);

                    // Group.g:210:7: ( COMMA defaultValuePair[mapping] )? 
                    $alt12=2;
                    $LA12_0 = $this->input->LA(1);

                    if ( ($LA12_0==$this->getToken('COMMA')) ) {
                        $alt12=1;
                    }
                    switch ($alt12) {
                        case 1 :
                            // Group.g:210:8: COMMA defaultValuePair[mapping] 
                            {
                            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_mapPairs501); 
                            $this->pushFollow(self::$FOLLOW_defaultValuePair_in_mapPairs503);
                            $this->defaultValuePair(mapping);

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // Group.g:211:7: defaultValuePair[mapping] 
                    {
                    $this->pushFollow(self::$FOLLOW_defaultValuePair_in_mapPairs514);
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
    // Group.g:214:1: defaultValuePair[Map mapping] : 'default' COLON v= keyValue ; 
    public function defaultValuePair(Map mapping){
        $v = null;



        StringTemplate v = null;

        try {
            // Group.g:218:2: ( 'default' COLON v= keyValue ) 
            // Group.g:218:4: 'default' COLON v= keyValue 
            {
            $this->match($this->input,$this->getToken('27'),self::$FOLLOW_27_in_defaultValuePair538); 
            $this->match($this->input,$this->getToken('COLON'),self::$FOLLOW_COLON_in_defaultValuePair540); 
            $this->pushFollow(self::$FOLLOW_keyValue_in_defaultValuePair544);
            $v=$this->keyValue();

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
    // Group.g:222:1: keyValuePair[Map mapping] : key= STRING COLON v= keyValue ; 
    public function keyValuePair(Map mapping){
        $key=null;
        $v = null;



        StringTemplate v = null;

        try {
            // Group.g:226:2: (key= STRING COLON v= keyValue ) 
            // Group.g:226:4: key= STRING COLON v= keyValue 
            {
            $key=$this->match($this->input,$this->getToken('STRING'),self::$FOLLOW_STRING_in_keyValuePair572); 
            $this->match($this->input,$this->getToken('COLON'),self::$FOLLOW_COLON_in_keyValuePair574); 
            $this->pushFollow(self::$FOLLOW_keyValue_in_keyValuePair578);
            $v=$this->keyValue();

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
    // Group.g:229:1: keyValue returns [StringTemplate value=null] : (s1= BIGSTRING | s2= STRING | k= ID {...}? | ); 
    public function keyValue(){
        $value = null;

        $s1=null;
        $s2=null;
        $k=null;

        try {
            // Group.g:230:2: (s1= BIGSTRING | s2= STRING | k= ID {...}? | ) 
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
                    // Group.g:230:4: s1= BIGSTRING 
                    {
                    $s1=$this->match($this->input,$this->getToken('BIGSTRING'),self::$FOLLOW_BIGSTRING_in_keyValue597); 
                      value = new StringTemplate(group,$s1->getText());

                    }
                    break;
                case 2 :
                    // Group.g:231:4: s2= STRING 
                    {
                    $s2=$this->match($this->input,$this->getToken('STRING'),self::$FOLLOW_STRING_in_keyValue606); 
                      value = new StringTemplate(group,$s2->getText());

                    }
                    break;
                case 3 :
                    // Group.g:232:4: k= ID {...}? 
                    {
                    $k=$this->match($this->input,$this->getToken('ID'),self::$FOLLOW_ID_in_keyValue616); 
                    if ( !(($k->getText() == "key")) ) {
                        throw new FailedPredicateException($this->input, "keyValue", "\\$k->getText() == \"key\"");
                    }
                      $value = ASTExpr::MAP_KEY_VALUE;

                    }
                    break;
                case 4 :
                    // Group.g:234:8:  
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

 



GroupParser::$FOLLOW_25_in_group66 = new Set(array(4));
GroupParser::$FOLLOW_ID_in_group70 = new Set(array(5, 7, 26));
GroupParser::$FOLLOW_COLON_in_group80 = new Set(array(4));
GroupParser::$FOLLOW_ID_in_group84 = new Set(array(7, 26));
GroupParser::$FOLLOW_26_in_group97 = new Set(array(4));
GroupParser::$FOLLOW_ID_in_group101 = new Set(array(6, 7));
GroupParser::$FOLLOW_COMMA_in_group112 = new Set(array(4));
GroupParser::$FOLLOW_ID_in_group116 = new Set(array(6, 7));
GroupParser::$FOLLOW_SEMI_in_group130 = new Set(array(4, 8));
GroupParser::$FOLLOW_template_in_group135 = new Set(array(1, 4, 8));
GroupParser::$FOLLOW_mapdef_in_group140 = new Set(array(1, 4, 8));
GroupParser::$FOLLOW_AT_in_template169 = new Set(array(4));
GroupParser::$FOLLOW_ID_in_template173 = new Set(array(9));
GroupParser::$FOLLOW_DOT_in_template175 = new Set(array(4));
GroupParser::$FOLLOW_ID_in_template179 = new Set(array(10));
GroupParser::$FOLLOW_ID_in_template197 = new Set(array(10));
GroupParser::$FOLLOW_LPAREN_in_template225 = new Set(array(4, 11));
GroupParser::$FOLLOW_args_in_template237 = new Set(array(11));
GroupParser::$FOLLOW_RPAREN_in_template248 = new Set(array(12));
GroupParser::$FOLLOW_DEFINED_TO_BE_in_template255 = new Set(array(13, 14));
GroupParser::$FOLLOW_STRING_in_template266 = new Set(array(1));
GroupParser::$FOLLOW_BIGSTRING_in_template283 = new Set(array(1));
GroupParser::$FOLLOW_ID_in_template302 = new Set(array(12));
GroupParser::$FOLLOW_DEFINED_TO_BE_in_template304 = new Set(array(4));
GroupParser::$FOLLOW_ID_in_template308 = new Set(array(1));
GroupParser::$FOLLOW_arg_in_args330 = new Set(array(1, 6));
GroupParser::$FOLLOW_COMMA_in_args335 = new Set(array(4));
GroupParser::$FOLLOW_arg_in_args337 = new Set(array(1, 6));
GroupParser::$FOLLOW_ID_in_arg360 = new Set(array(1, 15));
GroupParser::$FOLLOW_ASSIGN_in_arg366 = new Set(array(13));
GroupParser::$FOLLOW_STRING_in_arg370 = new Set(array(1));
GroupParser::$FOLLOW_ASSIGN_in_arg381 = new Set(array(16));
GroupParser::$FOLLOW_ANONYMOUS_TEMPLATE_in_arg385 = new Set(array(1));
GroupParser::$FOLLOW_ID_in_mapdef430 = new Set(array(12));
GroupParser::$FOLLOW_DEFINED_TO_BE_in_mapdef435 = new Set(array(17));
GroupParser::$FOLLOW_map_in_mapdef439 = new Set(array(1));
GroupParser::$FOLLOW_LBRACK_in_map461 = new Set(array(13, 27));
GroupParser::$FOLLOW_mapPairs_in_map463 = new Set(array(18));
GroupParser::$FOLLOW_RBRACK_in_map466 = new Set(array(1));
GroupParser::$FOLLOW_keyValuePair_in_mapPairs483 = new Set(array(1, 6));
GroupParser::$FOLLOW_COMMA_in_mapPairs487 = new Set(array(13));
GroupParser::$FOLLOW_keyValuePair_in_mapPairs489 = new Set(array(1, 6));
GroupParser::$FOLLOW_COMMA_in_mapPairs501 = new Set(array(13, 27));
GroupParser::$FOLLOW_defaultValuePair_in_mapPairs503 = new Set(array(1));
GroupParser::$FOLLOW_defaultValuePair_in_mapPairs514 = new Set(array(1));
GroupParser::$FOLLOW_27_in_defaultValuePair538 = new Set(array(5));
GroupParser::$FOLLOW_COLON_in_defaultValuePair540 = new Set(array(4, 13, 14));
GroupParser::$FOLLOW_keyValue_in_defaultValuePair544 = new Set(array(1));
GroupParser::$FOLLOW_STRING_in_keyValuePair572 = new Set(array(5));
GroupParser::$FOLLOW_COLON_in_keyValuePair574 = new Set(array(4, 13, 14));
GroupParser::$FOLLOW_keyValue_in_keyValuePair578 = new Set(array(1));
GroupParser::$FOLLOW_BIGSTRING_in_keyValue597 = new Set(array(1));
GroupParser::$FOLLOW_STRING_in_keyValue606 = new Set(array(1));
GroupParser::$FOLLOW_ID_in_keyValue616 = new Set(array(1));

?>