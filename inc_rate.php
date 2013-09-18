<?
//Please set the following variables for your mysql database:
$db_hostname = "localhost";  //usually "localhost be default"
$db_username = "ericblo1_blogger";  //your user name
$db_pass = "BloggerPasswordyo$";  //the password for your user
$db_name = "ericblo1_blog";  //the name of the database


/*MYSQL DATABASE CONNECTION/ TRACKING FUNCTIONS
--------------------------------------*/
// connect to database
$dbh = mysql_connect ($db_hostname, $db_username, $db_pass) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ($db_name);



//for security, html is not allowed, so bbcode is used for formatting

//START 3rd PARTY CODE:  I did not write this
/************************************************/
/*		BBCode v1.0a			*/
/*		Date: 03/2003			*/
/*						*/
/*	A simple and effective script that	*/
/*	allows you to implement bbcode type	*/
/*	behaviour on your php website.		*/
/*						*/
/*	Contact: bbcode@netgem.freeserve.co.uk	*/
/*						*/
/*	Usage:					*/
/*						*/
/*	Put the following line at the top of 	*/
/*	the page you want to have the bbocde	*/
/*	in...(assumes both pages are in the	*/
/*	folder					*/
/*						*/
/*	include("bbCode.php");			*/
/*						*/
/*	Pass the text to the function:		*/
/*						*/
/*	$mytext = BBCode("This is my BBCODE");	*/
/*	or					*/
/*	$mytext = "This is my text";		*/
/*	$mytext = BBCode($mytext);		*/
/*						*/
/*	echo $mytext;				*/
/*						*/
/************************************************/
?>
<style type="text/css">
<!--
body	{
	font-family: Courier new, courier, mono;
    font-size: 12px;
}

.bold {
	font-weight: bold;
}

.italics {
	font-style: italic;
}

.underline {
	text-decoration: underline;
}

.strikethrough {
	text-decoration: line-through;
}

.overline {
	text-decoration: overline;
}

.sized {
	text-size:
}

.quotecodeheader {
	font-family: Verdana, arial, helvetica, sans-serif;
	font-size: 12px;
	
}

.codebody {
	background-color: #FFFFFF;
    font-family: Courier new, courier, mono;
    font-size: 12px;
    color: #006600;
    border: 1px solid #BFBFBF;
}

.quotebody {
	background-color: #FFFFFF;
    font-family: Courier new, courier, mono;
    font-size: 12px;
    color: #660002;
	border: 1px solid #BFBFBF;
}

.listbullet {
	list-style-type: disc;
	list-style-position: inside;
}

.listdecimal {
	list-style-type: decimal;
	list-style-position: inside;
}

.listlowerroman {
	list-style-type: lower-roman;
	list-style-position: inside;
}

.listupperroman {
	list-style-type: upper-roman;
	list-style-position: inside;
}

.listloweralpha {
	list-style-type: lower-alpha;
	list-style-position: inside;
}

.listupperalpha {
	list-style-type: upper-alpha;
	list-style-position: inside;
}
a:focus {
border-color:#8cc63f;}

-->
</style>

<?php
	//Local copy

	function BBCode($Text)
	    {
        	// Replace any html brackets with HTML Entities to prevent executing HTML or script
            // Don't use strip_tags here because it breaks [url] search by replacing & with amp
            $Text = str_replace("<", "&lt;", $Text);
            $Text = str_replace(">", "&gt;", $Text);

           

            // Set up the parameters for a URL search string
            $URLSearchString = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
            // Set up the parameters for a MAIL search string
            $MAILSearchString = $URLSearchString . " a-zA-Z0-9\.@";
			
			//Non BB URL Search
			//$Text = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href=\"\\1://\\2\\3\" target=\"_blank\" target=\"_new\">\\1://\\2\\3</a>", $Text);
        	//$Text = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", "<a href=\"mailto:\\1\" target=\"_new\">\\1</a>", $Text);
        	if (substr($Text,0, 7) == "http://"){
            $Text = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href=\"\\1://\\2\\3\">\\1://\\2\\3</a>", $Text);
        	 // Convert new line chars to html <br /> tags
            $Text = nl2br($Text);
			} else { 
            // Perform URL Search
            $Text = preg_replace("/\[url\]([$URLSearchString]*)\[\/url\]/", '<a href="javascript:go(\'$1\',\'new\')">$1</a>', $Text);
            $Text = preg_replace("(\[url\=([$URLSearchString]*)\](.+?)\[/url\])", '<a href="javascript:go(\'$1\',\'new\')">$2</a>', $Text);
			//$Text = preg_replace("(\[url\=([$URLSearchString]*)\]([$URLSearchString]*)\[/url\])", '<a href="$1" target="_blank">$2</a>', $Text);
			 // Convert new line chars to html <br /> tags
            $Text = nl2br($Text);
			}
            // Perform MAIL Search
            $Text = preg_replace("(\[mail\]([$MAILSearchString]*)\[/mail\])", '<a href="mailto:$1">$1</a>', $Text);
            $Text = preg_replace("/\[mail\=([$MAILSearchString]*)\](.+?)\[\/mail\]/", '<a href="mailto:$1">$2</a>', $Text);
			
            // Check for bold text
            $Text = preg_replace("(\[b\](.+?)\[\/b])is",'<span class="bold">$1</span>',$Text);

            // Check for Italics text
            $Text = preg_replace("(\[i\](.+?)\[\/i\])is",'<span class="italics">$1</span>',$Text);

            // Check for Underline text
            $Text = preg_replace("(\[u\](.+?)\[\/u\])is",'<span class="underline">$1</span>',$Text);

            // Check for strike-through text
            $Text = preg_replace("(\[s\](.+?)\[\/s\])is",'<span class="strikethrough">$1</span>',$Text);

            // Check for over-line text
            $Text = preg_replace("(\[o\](.+?)\[\/o\])is",'<span class="overline">$1</span>',$Text);

            // Check for colored text
            $Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<span style=\"color: $1\">$2</span>",$Text);

            // Check for sized text
            $Text = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is","<span style=\"font-size: $1px\">$2</span>",$Text);

            // Check for list text
            $Text = preg_replace("/\[list\](.+?)\[\/list\]/is", '<ul class="listbullet">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=1\](.+?)\[\/list\]/is", '<ul class="listdecimal">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=i\](.+?)\[\/list\]/s", '<ul class="listlowerroman">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=I\](.+?)\[\/list\]/s", '<ul class="listupperroman">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=a\](.+?)\[\/list\]/s", '<ul class="listloweralpha">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=A\](.+?)\[\/list\]/s", '<ul class="listupperalpha">$1</ul>' ,$Text);
            $Text = str_replace("[*]", "<li>", $Text);

            // Check for font change text
            $Text = preg_replace("(\[font=(.+?)\](.+?)\[\/font\])","<span style=\"font-family: $1;\">$2</span>",$Text);

            // Declare the format for [code] layout
            $CodeLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="quotecodeheader"> Code:</td>
                                </tr>
                                <tr>
                                    <td class="codebody">$1</td>
                                </tr>
                           </table>';
            // Check for [code] text
            $Text = preg_replace("/\[code\](.+?)\[\/code\]/is","$CodeLayout", $Text);

            // Declare the format for [quote] layout
            $QuoteLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="quotecodeheader"> Quote:</td>
                                </tr>
                                <tr>
                                    <td class="quotebody">$1</td>
                                </tr>
                           </table>';
						   
            // Check for [code] text
            $Text = preg_replace("/\[quote\](.+?)\[\/quote\]/is","$QuoteLayout", $Text);
			
            // Images
            // [img]pathtoimage[/img]
            $Text = preg_replace("/\[img\](.+?)\[\/img\]/", '<img src="$1">', $Text);
			
            // [img=widthxheight]image source[/img]
            $Text = preg_replace("/\[img\=([0-9]*)x([0-9]*)\](.+?)\[\/img\]/", '<img src="$3" height="$2" width="$1">', $Text);
			
	        return $Text;
		}


//END 3rd PARTY CODE

//quick script to make the data look nice
function formatDate($val)  
  {  
      list($date, $time) = explode(" ", $val);  
      list($year, $month, $day) = explode("-", $date);
      list($hour, $minute, $second) = explode (":", $time);
      return date("l, m.j.y @ h:ia", mktime($hour, $minute, $second, $month, $day, $year));  
  } 

  

function getComments($tutid){
//creates a function that can easily be called from any page

//create the css code to make the form look good.  You can edit this to change colors, etc:
echo "
<style>
/*COMMENTS
*------------------------------------*/

.postedby {
	padding: 0 0 0 18px;
	background: url(images/abullet.gif) no-repeat 0 4px;
	}
	
h3.formtitle { font-family: 'Bangers', cursive;
color: #662C91;
	margin : 0px 0px 20px 0px;
	border-bottom: 1px solid #8CC63F;
	padding-bottom: 8px;
	text-align:left;
	font-weight: normal;
	font-size: 20px;
	}

.commentbody {
	border-top: 1px solid #8CC63F;
	}
	
/*gray box*/
.submitcomment, #submitcomment, #rating, .textad {min-height: 14px;
font-family: 'Bangers', cursive;
color:#662C91;
	background-color: #D1D1D1;
	border: 1px solid #8CC63F;
	padding: 5px;
	padding: 5px;
	margin: 20px 0px 0px 0px;
	}
	
	#currentcomments {
 font-family: Courier new, courier, mono;
color:#000000;
	background-color: #D1D1D1;
	border: 1px solid #8CC63F;
	padding: 5px;
	padding: 5px;
	margin: 20px 0px 0px 0px;}


/*FORMS
*------------------------------------*/


.form {color: #C4C4C4;
	width: 328px;
	min-height: 14px;
	border-width: 1px;
	border-style: solid;
	border-color: #B8B7B7;
	background-color: #FAFAFA;
	padding: 6px;
	line-height: 1;
	font-family: Courier New, Courier, monospace;
	font-style: normal;
	margin-left: 7px;
	position: relative;
	margin-top: -1px;
	margin-bottom: -1px;
	}

.formtext {width:97.5%;
resize:none;
	background-color: #FAFAFA;
	border: solid 1px #B8B7B7;
	padding: 6px;
	border-bottom: 1px solid #ccc;
	font-family: Courier New, Courier, monospace;
	font-style: normal;
	margin-top:-1px;
	margin-left: 7px;
	color: #C4C4C4;
	
	}

.form:hover, .formtext:hover {
	border-color: #8CC63F;
	background-color: #FFFFFF;
	padding-top: 6px;
	padding-bottom: 6px;
	color:#000000;

	
	
	
	}
	
.form:focus, .formtext:focus {

color:#000000;
	outline: none;

	border-color: #662C91;
	background-color: #FFFFFF;
	padding-top: 6px;
	padding-bottom: 6px;
	min-height: 14px;
	

	
}
	
	
	}
	 
.submit {
          height: 170px;
          width: 47px;
background-image:url('http://www.twowheelmotive.com/images/submit_h.png');
          background-repeat:no-repeat;
	}
	
.submit:hover, .submit:focus {height: 170px;
          width: 47px;
background-image:url('http://www.twowheelmotive.com/images/submit_h.png');
          background-repeat:no-repeat;
	}
	</style>

	
	";
//fetch all comments from database where the tutorial number is the one you are asking for
	$commentquery = mysql_query("SELECT * FROM comments WHERE tutorialid='$tutid' ORDER BY date") or die(mysql_error());
//find the number of comments
	$commentNum = mysql_num_rows($commentquery);
//create a headline
	echo "<div id=\"currentcomments\" class=\"submitcomment\"><h3 class=\"formtitle\">Current Comments</h3>\n";
	
//for each comment in the database in the right category number...
	while($commentrow = mysql_fetch_row($commentquery)){
//for security, parse through the bbcode script
//the number corresponds to the column (the message is always stored in column 4
//COUTING STARTS at 0!!!
	$commentbb = BBCode($commentrow[4]);
//create the right date format
		$commentDate = formatDate($commentrow[6]);

		echo "<div class=\"commentbody\" id=\"$commentrow[0]\">\n
		<p>$commentbb</p>\n
		<p class=\"postedby\">Posted by ";
		if($commentrow[3]){
		echo "<a href=\"$commentrow[3]\">$commentrow[2]</a> ";
		} else {
		echo "$commentrow[2] ";
		}
		echo "on $commentDate PST</p>\n
		\n</div>";
		
	}
	echo "</div>";
}

function submitComments($tutid2,$tuturl){
//a javascript script to make sure all the required fields are filled in
?>
<script language="javascript">

function form_Validator(form)
{

  if (form.name.value == "")
  {
    alert("Please enter your name.");
    form.name.focus();
	return (false);
     }

  if (form.message.value == "")
  {
    alert("Please enter your message.");
    form.message.focus();
    return (false);
  }
  
  return (true);
  }
  //-->
  </script>
<?php
//create the form to submit comments
//you can add more fields, but make sure you add them to the db table and the page, submitcomment.php
	echo "
<a name=\"post\">
<div id=\"submitcomment\" class=\"submitcomment\">
<form name=\"submitcomment\" method=\"post\" action=\"php/submitcomment.php\" onSubmit=\" return form_Validator(this)\">
<table width=\"100%\">
		<tr>
				<th colspan=\"2\" ><h3 class=\"formtitle\">Leave A Comment...</h3></th>
				
				
		</tr>
		<tr>
                
				<th scope=\"row\"><p class=\"req\"></p></th>
				
				<td><input class=\"form\" tabindex=\"1\" id=\"name\" placeholder=\"Name\" name=\"name\" /></td>
		</tr>
		<tr>
				<th scope=\"row\"><p class=\"opt\"></p></th>
				<td><input class=\"form\" tabindex=\"2\" id=\"email\" placeholder=\"Email\" name=\"email\" /></td>
		</tr>
		
		<tr valign=\"top\">
				<th scope=\"row\"><p class=\"req\"></p><br /></th>
				<td><textarea class=\"formtext\" tabindex=\"4\" id=\"message\" placeholder=\"Leave A Comment...\" name=\"message\" rows=\"10\" cols=\"90\"></textarea></td>
		</tr>

		<tr>	
				<td>&nbsp;</td>
				<td>
				   
				   
				   
				   
         \\this is where I was trying to embed the captcha\\
     
	 
	 
	 
	 
	  </br>
				<input type=\"image\" name=\"submit\" id=\"submit\" value=\"Submit\" src=\"http://www.twowheelmotive.com/images/submit.png\" onMouseOver=\"this.src='http://www.twowheelmotive.com/images/submit_h.png'\" onMouseOut=\"this.src='http://www.twowheelmotive.com/images/submit.png'\"
				
			
				
				
				
				 /><br />
				

</td>
		</tr>
</table>
<input type=\"hidden\" name=\"tuturl\" value=\"$tuturl\" />
<input type=\"hidden\" name=\"tutid2\" value=\"$tutid2\" />
</form>


</div>
";
}
?>
