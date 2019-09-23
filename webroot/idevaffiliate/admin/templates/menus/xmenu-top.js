//--- Common
var isHorizontal=1;
var smColumns=1;
var smOrientation=0;
var smViewType=0;
var dmRTL=0;
var pressedItem=-2;
var itemCursor="default";
var itemTarget="";
var statusString="text";
var blankImage="templates/menus/images/blank.gif";

//--- Dimensions
var menuWidth="";
var menuHeight="";
var smWidth="";
var smHeight="";

//--- Positioning
var absolutePos=0;
var posX="20";
var posY="10";
var topDX=0;
var topDY=-3;
var DX=-5;
var DY=0;

//--- Font
var fontStyle="";
var fontColor=["",""];
var fontDecoration=["overline","overline"];
var fontColorDisabled="#AAAAAA";

//--- Appearance
var menuBackColor="#FFFFFF";
var menuBackImage="";
var menuBackRepeat="repeat";
var menuBorderColor="#BFBFBF #737373 #4D4D4D #AAAAAA ";
var menuBorderWidth=1;
var menuBorderStyle="solid";

//--- Item Appearance
var itemBackColor=["",""];
var itemBackImage=["",""];
var itemBorderWidth=0;
var itemBorderColor=["",""];
var itemBorderStyle=["solid","solid"];
var itemSpacing=0;
var itemPadding="5";
var itemAlignTop="left";
var itemAlign="left";
var subMenuAlign="left";

//--- Icons
var iconTopWidth=12;
var iconTopHeight=12;
var iconWidth=16;
var iconHeight=16;
var arrowWidth=7;
var arrowHeight=7;
var arrowImageMain=["",""];
var arrowImageSub=["arrow_sub6.gif","arrow_sub7.gif"];

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
var floatIterations=5;
var floatableX=1;
var floatableY=1;

//--- Movable Menu
var movable=0;
var moveWidth=12;
var moveHeight=18;
var moveColor="#AA0000";
var moveImage="";
var moveCursor="move";
var smMovable=0;
var closeBtnW=15;
var closeBtnH=15;
var closeBtn="";

//--- Transitional Effects & Filters
var transparency="100";
var transition=24;
var transOptions="";
var transDuration=300;
var transDuration2=200;
var shadowLen=3;
var shadowColor="#555555";
var shadowTop=0;

//--- CSS Support (CSS-based Menu)
var cssStyle=1;
var cssSubmenu="submenu";
var cssItem=["itemNormal","itemOver"];
var cssItemText=["itemTextNormal","itemTextOver"];

//--- Advanced
var dmObjectsCheck=0;
var saveNavigationPath=1;
var showByClick=0;
var noWrap=1;
var pathPrefix_img="templates/menus/images/";
var pathPrefix_link="";
var smShowPause=200;
var smHidePause=1000;
var smSmartScroll=1;
var smHideOnClick=1;
var dm_writeAll=0;

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
    ["CSS=topItemNormal,topItemOver","CSSText=topItemTextNormal,topItemTextOver"],
];
var menuStyles = [
    ["CSS=topMenu"],
];

var menuItems = [

    ["Setup & Tools","", "gopen.gif", "gopen.gif", "Setup & Configuration", , "0", "0", , ],
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
            ["||Remove Traffic Logs","logs.php"],
            ["||Export Wizard","export.php"],
            ["||Import Wizard","import.php"],
        ["|-",""],
        ["|Advanced Developer Tools",""],
        	["||API Scripts","setup.php?action=44"],
        	["||Custom Functions","setup.php?action=46"],

    ["Cart Integration","", "gopen.gif", "gopen.gif", "Cart Integration", , "0", , , ],
        ["|Shopping Cart Integration Wizard","setup.php?action=10"],
        ["|Integration Profiles & Instructions","setup.php?action=2"],
        ["|-",""],
        ["|PayPal Recurring Commission Logs","setup.php?action=40"],

    ["General Settings","", "gopen.gif", "gopen.gif", "General Settings", , "0", , , ],
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
        ["|-",""],
        ["|Advanced Tracking Settings","setup.php?action=47"],

    ["Templates","", "gopen.gif", "gopen.gif", "Templates", , "0", , , ],
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
        ["|-",""],
        ["|Form Field Controls","setup.php?action=34"],

    ["Add-On Modules","", "gopen.gif", "gopen.gif", "Add-On Modules", , "0", , , ],
        ["|CommissionAlert & CommissionStats","module_cacs.php"],
        ["|Quickbooks Export","module_quickbooks.php"],
        ["|Language Packs","setup.php?action=33"],
        ["|Custom Filename","module_filename.php"],
        ["|SEO Links","setup.php?action=19"],

    ["Technical Support","http://www.idevsupport.com/", "gopen.gif", "gopen.gif", "Technical Support", "_blank", "0", , , ],
];

dm_init();

