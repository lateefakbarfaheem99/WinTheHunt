var popupMode=1; 

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

            ["|Commission Settings","setup.php?action=4"],
            ["|Tier Commission Settings","setup.php?action=36"],
            ["|Recurring Commission Settings","setup.php?action=38"],
        	["|-",""],
            ["|Delayed Commission Settings","setup.php?action=42"],
        	["|-",""],
            ["|Pay-Per-Lead Setup","setup.php?action=2&cfg=93"],

];

dm_init();


