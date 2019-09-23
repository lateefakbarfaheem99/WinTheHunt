/*
   Deluxe Menu Data File
   Created by Deluxe Tuner v2.0
   http://deluxe-menu.com
*/


// -- Deluxe Tuner Style Names
var itemStylesNames=["Top Item",];
var menuStylesNames=["Top Menu",];
// -- End of Deluxe Tuner Style Names

//--- Common
var isHorizontal=1;
var smColumns=1;
var smOrientation=0;
var smViewType=0;
var dmRTL=0;
var pressedItem=-2;
var itemCursor="pointer"; 
var itemTarget="_self";
var statusString="link";
var blankImage="blank.gif";

//--- Dimensions
var menuWidth="";
var menuHeight="26px";
var smWidth="200px";
var smHeight="";

//--- Positioning
var absolutePos=0;
var posX="10";
var posY="10";
var topDX=0;
var topDY=0;
var DX=0;
var DY=0;

//--- Font
var fontStyle="normal 11px sans-serif";
var fontColor=["#000000","#F5FDF4"];
var fontDecoration=["none","none"];
var fontColorDisabled="#585858";

//--- Appearance
var menuBackColor="#FFFFFF";
var menuBackImage="";
var menuBackRepeat="repeat";
var menuBorderColor="#FFFFFF";
var menuBorderWidth=1;
var menuBorderStyle="ridge";

//--- Item Appearance
var itemBackColor=["#FFFFFF","#5e88bc"];
var itemBackImage=["",""];
var itemBorderWidth=0;
var itemBorderColor=["#5e88bc","#5e88bc"];
var itemBorderStyle=["solid","groove"];
var itemSpacing=2;
var itemPadding="5px";
var itemAlignTop="left";
var itemAlign="left";
var subMenuAlign="left";

//--- Icons
var iconTopWidth=16;
var iconTopHeight=16;
var iconWidth=16;
var iconHeight=16;
var arrowWidth=7;
var arrowHeight=7;
var arrowImageMain=["arrv_white.gif",""];
var arrowImageSub=["arr_black_2.gif","arr_white.gif"];

//--- Separators
var separatorImage="separ1.gif";
var separatorWidth="100%";
var separatorHeight="5";
var separatorAlignment="center";
var separatorVImage="";
var separatorVWidth="5";
var separatorVHeight="34";
var separatorPadding="0px";

//--- Floatable Menu
var floatable=0;
var floatIterations=6;
var floatableX=1;
var floatableY=1;

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
var transition=24;
var transOptions="gradientSize=0.4, wipestyle=1, motion=forward";
var transDuration=350;
var transDuration2=200;
var shadowLen=3;
var shadowColor="#B1B1B1";
var shadowTop=0;

//--- CSS Support (CSS-based Menu)
var cssStyle=0;
var cssSubmenu="submenu";
var cssItem=["itemNormal","itemOver"];
var cssItemText=["itemTextNormal","itemTextOver"];

//--- Advanced
var dmObjectsCheck=0;
var saveNavigationPath=1;
var showByClick=0;
var noWrap=1;
var pathPrefix_img="templates/menus/menu/";
var pathPrefix_link="";
var smShowPause=0;
var smHidePause=0;
var smSmartScroll=1;
var smHideOnClick=1;
var dm_writeAll=1;

//--- AJAX-like Technology
var dmAJAX=0;
var dmAJAXCount=0;

//--- Dynamic Menu
var dynamic=0;

//--- Keystrokes Support
var keystrokes=0;
var dm_focus=1;
var dm_actKey=113;

var itemStyles = [
    ["itemWidth=126px","itemBackColor=transparent,transparent","itemBorderWidth=0","fontStyle=bold 11px sans-serif","fontColor=#FFFFFF,#FFFFFF","itemBackImage=btn_black22.gif,btn_black.gif"],
];
var menuStyles = [
    ["menuBackColor=transparent","menuBorderWidth=0","itemSpacing=0","itemPadding=5px 6px 5px 6px"],
];

var menuItems = [

    ["Setup & Tools", , , , "Setup & Configuration", , "0", "0", , ],
        ["|Site Configuration","setup.php?action=1"],
        ["|General Settings","setup.php?action=3"],
        ["|-",""],
        ["|Email Settings","setup.php?action=31"],
        ["|-",""],
        ["|PayPal Payments","setup.php?action=35"],
        ["|-",""],
        ["|Admin Accounts","setup.php?action=11"],
        ["|-",""],
        ["|Display Affiliate Info","setup.php?action=32"],
        ["|Affiliate Logo Settings","setup.php?action=43"],
        ["|-",""],
        ["|iDevDirect Affiliate Link","setup.php?action=45"],
        ["|-",""],
        ["|Database Tools",""],
            ["||Manage Traffic Logs","logs.php"],
            ["||Export Wizard","export.php"],
            ["||Import Wizard","import.php"],
        ["|-",""],
        ["|Advanced Developer Tools",""],
        	["||API Scripts","setup.php?action=44"],
        	["||Custom Functions","setup.php?action=46"],

    ["Cart Integration", , , , "Cart Integration", , "0", , , ],
        ["|Shopping Cart Integration Wizard","setup.php?action=10"],
        ["|Integration Profiles & Instructions","setup.php?action=2"],
        ["|-",""],
        ["|PayPal Recurring Commission Logs","setup.php?action=40"],

    ["General Settings", , , , "General Settings", , "0", , , ],
        ["|Commission Settings",""],
            ["||Commission Settings","setup.php?action=4"],
            ["||Tier Commission Settings","setup.php?action=36"],
            ["||Recurring Commission Settings","setup.php?action=38"],
        	["||-",""],
            ["||Delayed Commission Settings","setup.php?action=42"],
        ["|-",""],
        ["|Email Notifications","setup.php?action=5"],
        ["|Customer Tracking","setup.php?action=16"],
        ["|Offline Marketing","setup.php?action=17"],
        ["|Performance Rewards","setup.php?action=18"],
        ["|Links and Statistics","setup.php?action=19"],
        ["|Fraud Control","setup.php?action=51"],
        ["|Commission Blocking","setup.php?action=57"],
        ["|-",""],
        ["|Advanced Tracking Settings","setup.php?action=47"],
        ["|-",""],
        ["|Affiliate Training Videos","setup.php?action=53"],

    ["Templates", , , , "Templates", , "0", , , ],
        ["|Control Panel Customization","setup.php?action=9",""],
        ["|-",""],
        ["|Language Templates","setup.php?action=33"],
        ["|Custom Language Tokens","setup.php?action=41"],
        ["|-",""],
        ["|Add An Internal Control Panel Page","setup.php?action=30"],
        ["|Add An External Control Panel Page","setup.php?action=52"],
        ["|-",""],
        ["|Email Templates","setup.php?action=6"],
        ["|-",""],
        ["|Frequently Asked Questions","setup.php?action=21"],
        ["|Terms and Conditions","setup.php?action=15"],
		["|CAN-SPAM Rules and Acceptance","setup.php?action=56"],
        ["|-",""],
        ["|Form Field Controls","setup.php?action=34"],

    ["Add-On Modules", , , , "Add-On Modules", , "0", , , ],
        ["|CommissionAlert & CommissionStats","module_cacs.php"],
        ["|Quickbooks Export","module_quickbooks.php"],
        ["|Language Packs","setup.php?action=33"],
        ["|Custom Filename","module_filename.php"],
        ["|SEO Links","setup.php?action=19"],

    ["Support", , , , "Support", , "0", , , ],
    	  ["|iDevDirect Helpdesk","http://www.idevsupport.com/", "", "", "", "_blank", "", "", "", "", "", ],
    	  ["|Admin Video Tutorials ","http://www.idevtutorials.com/training/videos/index.php", "", "", "", "_blank", "", "", "", "", "", ],
    	  ["|Affiliate Video Tutorials","setup.php?action=53"],
    	  ["|User Documentation","manuals.php"],
    	  ["|Quick Setup Guide","setup_guide.php"],
];

dm_init();

