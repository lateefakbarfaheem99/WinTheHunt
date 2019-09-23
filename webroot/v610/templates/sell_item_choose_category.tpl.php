<?
#################################################################
## PHP Pro Bid v6.05															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<SCRIPT language=javascript>
<!--
var c = new Array();
function x(intParent, intListPos, strCategory, strCategoryID)
{
	c[intParent][intListPos] = new Option(strCategory,strCategoryID);
}
<?=$categories_initialize_msg;?>
// -->
</SCRIPT>
<SCRIPT language=javascript>
<!--
var blnIE;	//IE? for table highlighting etc...
var	strEmptyString;
var	strCatSelectedString;
var hexEnabled = "#ffffff";
var hexDisabled = "#dddddd";
var hexHighlightOn = "#FFB300";
var hexHighlightOff = "#ffffff";

//arrayLevel 0 for top level, 1 for next level down etc...
function populate(arrayLevel)
{
	//get the value of the selected index (click)
	strOptionValue = (docSelectorArray[arrayLevel].options[docSelectorArray[arrayLevel].selectedIndex].value);

	if (strOptionValue == 0) //if value is 0 then is a spacer option - move their choice to the bottom option
	{
		if (docSelectorArray[arrayLevel].selectedIndex != 0)
		{
			docSelectorArray[arrayLevel].selectedIndex	= docSelectorArray[arrayLevel].selectedIndex - 1;
			strOptionValue = (docSelectorArray[arrayLevel].options[docSelectorArray[arrayLevel].selectedIndex].value);
		}
		else //if they have clicked in an empty table then dont do anything
		{
			return;
		}
	}

	//get the option text so we can see if we have a leaf or a branch (" >")
	strOptionText = (docSelectorArray[arrayLevel].options[docSelectorArray[arrayLevel].selectedIndex].text);

	//clear lower level select boxes------------------------------------------
	//outerloop through select boxes, starting from the one below this click
	for (i = arrayLevel+1; i < intLevels; i++)
	{
		for (j = docSelectorArray[i].length-2; j >= 0; j--) //inner loop through the number of items in select boxes
		{
			docSelectorArray[i].options[j] = null;
		}

		docSelectorArray[i].options[0] = new Option(strEmptyString, "0"); //keep box a consistent width

		if (blnIE) //disable and unhighlight
		{
			docSelectorArray[i].style.background = hexDisabled;
			docTableArray[i].style.background = hexHighlightOff;
		}
		docSelectorArray[i].disabled = true;
		//docImageArray[i].src = docImageSrcOffArray[i];
	}

	//need another branch (branch or top level)-------------------------------
	if ((strOptionText.indexOf(" >") != -1))
	{
		<?=$category_id_type;?>.value = "";	//clear any value from the category box
		submitButton.disabled = true; //disable the next button

		//get the next array and the number of options in it
		intNextArray = docSelectorArray[arrayLevel].options[docSelectorArray[arrayLevel].selectedIndex].value;

		//populate the next level if they didn't choose the "Select a Category" option
		if (intNextArray != 0)
		{
			docSelectorArray[arrayLevel+1].disabled = false; //enable next arrayLevel

			if (blnIE) //IE only
			{
				docSelectorArray[arrayLevel+1].style.background = hexEnabled;		//color of next select box is now enabled
				docTableArray[arrayLevel].style.background = hexHighlightOff;		//this table now unhighlighted
				docTableArray[arrayLevel+1].style.background = hexHighlightOn;		//next table now highlighted
				docTableArray[intTableSubmit].style.background = hexHighlightOff;		//Next button table unhighlighted
			}

			//get the number of options for the next level and populate the options
			intNumberOptions = c[intNextArray].length;

			for (i = 0; i < intNumberOptions; i++) //populate array with options
			{
				docSelectorArray[arrayLevel+1].options[i] = c[intNextArray][i];
			}

			//put a new option at the end of the list so that we have a consistent size on the box
			docSelectorArray[arrayLevel+1].options[intNumberOptions] = new Option(strEmptyString, "0");

			if (docSelectorArray[arrayLevel+1].selectedIndex != -1) //unhighlight any previous selection
			{
				docSelectorArray[arrayLevel+1].selectedIndex = -1;
			}
		}
	} else { //have reached a leaf, populate the others with end text-------------------------------------------------
		if (strOptionValue != 0) //get the option for this selection
		{
			<?=$category_id_type;?>.value = strOptionValue;
		}


		for (i = arrayLevel+1; i < intLevels; i++) //outerloop through select boxes, starting from the one below this click
		{
			//populate with end text
			docSelectorArray[i].options[0] = new Option(strCatSelectedString, "0");
		}

		submitButton.disabled = false; //enable and hightlight submit button

		if (blnIE) //IE only
		{
			docTableArray[arrayLevel].style.background = hexHighlightOff;
			docTableArray[intTableSubmit].style.background = hexHighlightOn;
		}
	}
}

//arrayLevel 0 for top level, 1 for next level down etc...
function prePopulate(mCat)
{
	//check mCat is sane
	if (mCat.length < 5) return;					//must be at least 2 levels
	if (mCat.length % 5 != 0) return;				//each mCat is 5 chars long
	if (mCat.charAt(mCat.length - 1) != '-') return;//last char of last mCat is '-'

	var mCatArray = mCat.split('-');	//this is now an array of strings, mCatArray[0] = '0011' etc...
	var intMcat							//integer from string mcat '0011' -> 11 etc...
	var strOptionText					//text of option selected to see if we are a leaf or not
	var intNextArray					//next array down from the one we are currently working on
	var intNumberOptions				//number of options for the next level

	for (intArrayLevel = 0; intArrayLevel < (mCatArray.length - 1); intArrayLevel++) //outer loop down through the levels
	{
		intMcat = parseInt(mCatArray[intArrayLevel],10); //set integer version of mCat

		//inner loop - find the matching mCat and set it
		for (intArrayOption = 0; intArrayOption < docSelectorArray[intArrayLevel].length; intArrayOption++)
		{
			if (docSelectorArray[intArrayLevel].options[intArrayOption].value == intMcat) //found a match
			{
				//so select the index and get the text
				docSelectorArray[intArrayLevel].selectedIndex = intArrayOption;
				strOptionText = (docSelectorArray[intArrayLevel].options[intArrayOption].text);

				//unset the selected image and table highlight for the current level
				//docImageArray[intArrayLevel].src = docImageSrcOffArray[intArrayLevel];
				if (blnIE)
				{
					docTableArray[intArrayLevel].style.background = hexHighlightOff;
				}

				//do we need another branch or have we reached the leaf?
				//need another branch (branch or top level)-------------------------------
				if (strOptionText.indexOf(" >") != -1)
				{
					//set the selected image and table highlight for this next level
					//docImageArray[intArrayLevel+1].src = docImageSrcOnArray[intArrayLevel+1];
					if (blnIE)
					{
						docTableArray[intArrayLevel+1].style.background = hexHighlightOn;
						docSelectorArray[intArrayLevel+1].style.background = hexEnabled;
					}

					docSelectorArray[intArrayLevel+1].disabled = false; //enable this next level

					//get the next array
					intNextArray = docSelectorArray[intArrayLevel].options[docSelectorArray[intArrayLevel].selectedIndex].value;

					//get the number of options for the next level and populate the options
					intNumberOptions = c[intNextArray].length;
					for (i = 0; i < intNumberOptions; i++)
					{
						docSelectorArray[intArrayLevel+1].options[i] = c[intNextArray][i];
					}

					//put a new option at the end of the list so that we have a consistent size on the box
					docSelectorArray[intArrayLevel+1].options[intNumberOptions] = new Option(strEmptyString, "0");

					//if we are 1 level from the end then check and select the next option if appropriate
					if (intArrayLevel == 2)
					{
						intMcat = parseInt(mCatArray[intArrayLevel+1],10); //get last mCat

						//loop through the last category and find the appropriate category
						for (i = 0; i < intNumberOptions; i++)
						{
							if (docSelectorArray[intArrayLevel+1].options[i].value == intMcat)
							{
								//set the selected index and populate the category box
								docSelectorArray[intArrayLevel+1].selectedIndex = i;
								<?=$category_id_type;?>.value = intMcat;

								//unset the selected image and table highlight for the current level
								//docImageArray[intArrayLevel+1].src = docImageSrcOffArray[intArrayLevel];

								//enable and highlight submit button
								submitButton.disabled = false;

								if (blnIE)
								{
									docTableArray[intArrayLevel+1].style.background = hexHighlightOff;
									docTableArray[intTableSubmit].style.background = hexHighlightOn;
								}

								break; //break now to stop looping through the final box
							}
						}
						//found the final cat so stop here
						return;
					}
				}
				else //have reached a leaf, populate the others with end text------------------
				{
					//populate the category box
					<?=$category_id_type;?>.value = docSelectorArray[intArrayLevel].options[intArrayOption].value;

					//outerloop through select boxes, starting from the one above this click
					for (i = intArrayLevel+1; i < intLevels; i++)
					{
						//populate with end text
						docSelectorArray[i].options[0] = new Option(strCatSelectedString, "0");
						docSelectorArray[i].disabled = true;
					}

					//enable and highlight submit button
					submitButton.disabled = false;
					if (blnIE)
					{
						docTableArray[intTableSubmit].style.background = hexHighlightOn;
					}
				}
				//break out of this loop, as we have found a match and do not need to continue checking
				break;
			}
		}
	}
}

// -->
</SCRIPT>

<?=$choose_category_expl_message;?>
<table width="100%" border="0" cellspacing="2" cellpadding="3" align="center" class="border">
   <tr>
      <td class="c4" colspan="2"><b>
         <?=$choose_category_title;?>
         </b></td>
   </tr>
	<? if ($current_step == 'addl_category') { ?>  
   <tr class="contentfont">
		<td class="c1" align="right" width="100%"><table cellspacing="2" border="0">
            <tr>
               <td><input id="form_next_step" type=submit value="<?=MSG_SKIP_THIS_STEP;?>" name="form_next_step">
               </td>
            </tr>
         </table></td>
   </tr>
	<? } ?>
   <tr class="contentfont">
      <td width="100%" class="c2" colspan="2"><table cellspacing="5" cellpadding="2" border="0" width="100%">
            <tr valign="top" bgcolor="#ffffff">
               <td align="middle" width="50%"><table id="table_0" cellspacing="5" border="0" width="100%">
                     <tr>
                        <td><?=$main_categories_select;?></td>
                     </tr>
                  </table></td>
               <td align=middle width="50%"><table id=table_1 cellspacing=5 border=0 width=100%>
                     <tr>
                        <td><select class="contentfont" id="selector_1" onchange="populate(1)" size="10" name="selector_1" style="width: 100%; ">
                              <option value=""></option>
                           </select></td>
                     </tr>
                  </table></td>
            </tr>
            <tr valign=top bgcolor=#ffffff>
               <td align=middle><table id=table_2 cellspacing=5 border=0 width=100%>
                     <tr>
                        <td><select class="contentfont" id="selector_2" onchange="populate(2)" size="7" name="selector_2" style="width: 100%; ">
                              <option value=""></option>
                           </select></td>
                     </tr>
                  </table></td>
               <td align=middle><table id=table_3 cellspacing=5 border=0 width=100%>
                     <tr>
                        <td><select class="contentfont" id="selector_3"
                        onchange="populate(3)" size="7" name="selector_3" style="width: 100%; ">
                              <option value=""></option>
                           </select></td>
                     </tr>
                  </table></td>
            </tr>
            <tr valign=top bgcolor=#ffffff>
               <td align=middle><table id=table_4 cellspacing=5 border=0 width=100%>
                     <tr>
                        <td><select class="contentfont" id="selector_4" onchange="populate(4)" size="7" name="selector_4" style="width: 100%; ">
                              <option value=""></option>
                           </select></td>
                     </tr>
                  </table></td>
               <td align=middle><table id=table_5 cellspacing=5 border=0 width=100%>
                     <tr>
                        <td><select class="contentfont" id="selector_5"
                        onchange="populate(5)" size="7" name="selector_5" style="width: 100%; ">
                              <option value=""></option>
                           </select></td>
                     </tr>
                  </table></td>
            </tr>
         </table></td>
   </tr>
   <?=$previously_selected_cats_list; ?>
   <tr class="contentfont">
      <input id="<?=$category_id_type;?>" type="hidden" name="<?=$category_id_type;?>">
		<td class="c1" align="right"><table id="table_submit" cellspacing="2" border="0">
            <tr>
               <td><input id="form_next_step" type=submit value="<?=GMSG_NEXT_STEP;?>" name="form_next_step"></td>
            </tr>
         </table></td>
   </tr>
</table>
<SCRIPT language=javascript>
<!--
	//IE but not a Mac
	if ((navigator.appVersion.indexOf("MSIE")!= -1) && (navigator.appVersion.indexOf("Mac") == -1))
	{
		strEmptyString = "                                                     ";
		strCatSelectedString = "Category Selected - Click Next.           ";

		//can we use this function? (forget about early IE browsers)
		blnIE = (document.getElementById) ? true : false;
	}
	else
	{
		strEmptyString = "--------------------------------------";
		strCatSelectedString =	"----Category Selected - Click Next-----";
	}

	//IE only
	if (blnIE)
	{
		//tables to border
		var docTableArray = new Array;
		var intTableSubmit = 0;

		//tables : hard code for now
		docTableArray[0] = document.getElementById('table_0');
		docTableArray[1] = document.getElementById('table_1');
		docTableArray[2] = document.getElementById('table_2');
		docTableArray[3] = document.getElementById('table_3');
		docTableArray[4] = document.getElementById('table_4');
		docTableArray[5] = document.getElementById('table_5');
		docTableArray[6] = document.getElementById('table_submit');
		intTableSubmit = 6;

		docTableArray[0].style.background = hexHighlightOn;	//highlight the first box for them to select
	}

	var i = 0;

	//selectors to populate
	var docSelectorArray = new Array;
	var intLevels; // = categoryLevel.length; //number of levels in our form
	var selectorLoop = 0;

	//submit button
	var submitButton;

	//category_ID
	var <?=$category_id_type;?>;

	//build small arrays that we can index by id later
	for (i = 0; i < document.ad_create_form.elements.length; i++)
	{
		if (document.ad_create_form.elements[i].name.indexOf("selector_") != -1) //cat selectors
		{
			docSelectorArray[selectorLoop] = document.ad_create_form.elements[i];
			selectorLoop++;
		}
		else if (document.ad_create_form.elements[i].name.indexOf("category") != -1) //categoryID
		{
			<?=$category_id_type;?> = document.ad_create_form.elements[i];
		}
		else if (document.ad_create_form.elements[i].name.indexOf("form_next_step") != -1) //submit button
		{
			submitButton = document.ad_create_form.elements[i];
		}
	}

	intLevels = docSelectorArray.length;	//number of levels in our form
	submitButton.disabled = true;			//disable, will be enabled if appropriate

	for (i = 1; i < selectorLoop; i++)
	{
		docSelectorArray[i].disabled = true;	//disable all these boxes
		if (blnIE)
		{
			docSelectorArray[i].style.background = hexDisabled;	//set an obvious disabled colour
		}
	}
//-->
</SCRIPT>
<br>
