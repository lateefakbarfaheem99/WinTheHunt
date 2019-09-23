
<script type="text/javascript" language="JavaScript1.2">

// -- Deluxe Tuner Style Names
var itemStylesNames=["Top Item",];
var menuStylesNames=["Top Menu",];
// -- End of Deluxe Tuner Style Names

//--- Common
var isHorizontal=1;
var smColumns=1;
var smOrientation=0;
var dmRTL=0;
var pressedItem=-2;
var itemCursor="pointer";
var itemTarget="_self";
var statusString="link";
var blankImage="templates/menus/images/blank.gif";
var pathPrefix_img="";
var pathPrefix_link="";

//--- Dimensions
var menuWidth="658px";
var menuHeight="20px";
var smWidth="200px";
var smHeight="";

//--- Positioning
var absolutePos=0;
var posX="10px";
var posY="10px";
var topDX=0;
var topDY=1;
var DX=-5;
var DY=0;
var subMenuAlign="left";
var subMenuVAlign="top";

//--- Font
var fontStyle=["normal 11px sans-serif","normal 11px sans-serif"];
var fontColor=["#000000","#000000"];
var fontDecoration=["none","none"];
var fontColorDisabled="#AAAAAA";

//--- Appearance
var menuBackColor="#FFFFFF";
var menuBackImage="";
var menuBackRepeat="repeat";
var menuBorderColor="#B9B9B9";
var menuBorderWidth=1;
var menuBorderStyle="solid";

//--- Item Appearance
var itemBackColor=["#FFFFFF","#c7d6fd"];
var itemBackImage=["",""];
var beforeItemImage=["",""];
var afterItemImage=["",""];
var beforeItemImageW="";
var afterItemImageW="";
var beforeItemImageH="";
var afterItemImageH="";
var itemBorderWidth=1;
var itemBorderColor=["",""];
var itemBorderStyle=["solid","dashed"];
var itemSpacing=1;
var itemPadding="3px 3px 3px 3px";
var itemAlignTop="left";
var itemAlign="left";

//--- Icons
var iconTopWidth=16;
var iconTopHeight=16;
var iconWidth=16;
var iconHeight=16;
var arrowWidth=7;
var arrowHeight=7;
var arrowImageMain=["templates/menus/images/arrv_black.gif",""];
var arrowWidthSub=0;
var arrowHeightSub=0;
var arrowImageSub=["templates/menus/images/arr_black.gif","templates/menus/images/arr_white.gif"];

//--- Separators
var separatorImage="";
var separatorWidth="100%";
var separatorHeight="3px";
var separatorAlignment="center";
var separatorVImage="";
var separatorVWidth="3px";
var separatorVHeight="100%";
var separatorPadding="0px";

//--- Floatable Menu
var floatable=0;
var floatIterations=6;
var floatableX=1;
var floatableY=1;
var floatableDX=15;
var floatableDY=15;

//--- Movable Menu
var movable=0;
var moveWidth=12;
var moveHeight=20;
var moveColor="#DECA9A";
var moveImage="";
var moveCursor="move";
var smMovable=0;
var closeBtnW=15;
var closeBtnH=15;
var closeBtn="";

//--- Transitional Effects & Filters
var transparency="100";
var transition=-1;
var transOptions="";
var transDuration=350;
var transDuration2=200;
var shadowLen=3;
var shadowColor="#B1B1B1";
var shadowTop=0;

//--- CSS Support (CSS-based Menu)
var cssStyle=0;
var cssSubmenu="";
var cssItem=["",""];
var cssItemText=["",""];

//--- Advanced
var dmObjectsCheck=0;
var saveNavigationPath=1;
var showByClick=0;
var noWrap=1;
var smShowPause=200;
var smHidePause=1000;
var smSmartScroll=1;
var topSmartScroll=0;
var smHideOnClick=1;
var dm_writeAll=1;
var useIFRAME=0;
var dmSearch=0;

//--- AJAX-like Technology
var dmAJAX=0;
var dmAJAXCount=0;
var ajaxReload=0;

//--- Dynamic Menu
var dynamic=0;

//--- Keystrokes Support
var keystrokes=0;
var dm_focus=1;
var dm_actKey=113;

//--- Sound
var onOverSnd="";
var onClickSnd="";

var itemStyles = [
    ["itemWidth=130px","itemHeight=20px","itemBackImage=templates/menus/images/cold.png,templates/menus/images/hot.png","itemBorderWidth=0","fontStyle='normal 11px sans-serif','normal 11px sans-serif'","fontColor=#000000,#000000"],
];
var menuStyles = [
    ["menuBackColor=transparent","menuBorderWidth=0","itemSpacing=1","itemPadding=0px 5px 0px 5px","smOrientation=undefined"],
];

var menuItems = [

    ["{$menu_drop_heading_stats}","account.php?page=1", "", "", "{$menu_drop_heading_stats}", "_self", "0", "0", "", "", "", ],

	  {if isset($tier_enabled)}
        ["|{$menu_drop_general_stats}","account.php?page=1", "", "", "{$menu_drop_general_stats}", "_self", "", "", "", "", "", ],

        ["|{$menu_drop_tier_stats}","account.php?page=2", "", "", "{$menu_drop_tier_stats}", "_self", "", "", "", "", "", ],
	  {/if}

    ["{$menu_drop_heading_commissions}","account.php?page=4&report=1", "", "", "{$menu_drop_heading_commissions}", "_self", "0", "0", "", "", "", ],

        ["|{$menu_drop_current}","account.php?page=4&report=1", "", "", "{$menu_drop_current}", "_self", "", "", "", "", "", ],

	  {if isset($tier_enabled)}
        ["|{$menu_drop_tier}","account.php?page=4&report=2", "", "", "{$menu_drop_tier}", "_self", "", "", "", "", "", ],
	  {/if}

	  {if isset($pending_enabled)}
        ["|{$menu_drop_pending}","account.php?page=4&report=3", "", "", "{$menu_drop_pending}", "_self", "", "", "", "", "", ],
	  {/if}

        ["|{$menu_drop_paid}","account.php?page=4&report=4", "", "", "{$menu_drop_paid}", "_self", "", "", "", "", "", ],

	  {if isset($tier_enabled)}
        ["|{$menu_drop_paid_rec}","account.php?page=4&report=5", "", "", "{$menu_drop_paid_rec}", "_self", "", "", "", "", "", ],
	  {/if}

	  {if isset($recurring_enabled)}
        ["|{$menu_drop_recurring}","account.php?page=5", "", "", "{$menu_drop_recurring}", "_self", "", "", "", "", "", ],
	  {/if}

    ["{$menu_drop_heading_history}","account.php?page=3", "", "", "{$menu_drop_heading_history}", "_self", "0", "0", "", "", "", ],

    ["{$menu_drop_heading_traffic}","account.php?page=6", "", "", "{$menu_drop_heading_traffic}", "_self", "0", "0", "", "", "", ],

    ["{$menu_drop_heading_account}","account.php?page=17", "", "", "{$menu_drop_heading_account}", "_self", "0", "0", "", "", "", ],

        ["|{$menu_drop_edit}","account.php?page=17", "", "", "{$menu_drop_edit}", "_self", "", "", "", "", "", ],

        ["|{$menu_drop_password}","account.php?page=18", "", "", "{$menu_drop_password}", "_self", "", "", "", "", "", ],

	  {if isset($change_commission)}
        ["|{$menu_drop_change}","account.php?page=19", "", "", "{$menu_drop_change}", "_self", "", "", "", "", "", ],
	  {/if}

	  {if isset($logos_enabled)}
    	  ["|{$menu_drop_heading_logo}","account.php?page=27", "", "", "{$menu_drop_heading_logo}", "_self", "", "", "", "", "", ],
	  {/if}

    {if isset($use_faq) && ($faq_location == 2)}
    ["|{$menu_drop_heading_faq}","account.php?page=21", "", "", "{$menu_drop_heading_faq}", "_self", "", "", "", "", "", ],
    {/if}

];

dm_init();

</script>
