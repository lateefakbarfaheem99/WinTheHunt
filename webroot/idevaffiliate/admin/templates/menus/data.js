//--- Common
var isHorizontal=1;
var smColumns=1;
var smOrientation=0;
var smViewType=0;
var dmRTL=0;
var pressedItem=-2;
var itemCursor="default";
var itemTarget="_self";
var statusString="link";
var blankImage="images/blank.gif";

//--- Dimensions
var menuWidth="400px";
var menuHeight="";
var smWidth="";
var smHeight="";

//--- Positioning
var absolutePos=1;
var posX="10";
var posY="10";
var topDX=0;
var topDY=1;
var DX=-5;
var DY=0;

//--- Font
var fontStyle="normal 11px Trebuchet MS, Tahoma";
var fontColor=["#000000","#FFFFFF"];
var fontDecoration=["none","none"];
var fontColorDisabled="#AAAAAA";

//--- Appearance
var menuBackColor="#FCEEB0";
var menuBackImage="";
var menuBackRepeat="repeat";
var menuBorderColor="#C0AF62";
var menuBorderWidth=1;
var menuBorderStyle="solid";

//--- Item Appearance
var itemBackColor=["#FCEEB0","#65BDDC"];
var itemBackImage=["",""];
var itemBorderWidth=1;
var itemBorderColor=["#FCEEB0","#4C99AB"];
var itemBorderStyle=["solid","solid"];
var itemSpacing=3;
var itemPadding="2px";
var itemAlignTop="left";
var itemAlign="left";
var subMenuAlign="";

//--- Icons
var iconTopWidth=16;
var iconTopHeight=16;
var iconWidth=16;
var iconHeight=16;
var arrowWidth=8;
var arrowHeight=16;
var arrowImageMain=["",""];
var arrowImageSub=["",""];

//--- Separators
var separatorImage="";
var separatorWidth="100%";
var separatorHeight="3";
var separatorAlignment="left";
var separatorVImage="";
var separatorVWidth="3";
var separatorVHeight="100%";
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
var transparency="80";
var transition=24;
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
var pathPrefix_img="";
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


var menuItems = [

    ["Home","testlink.html"],
    ["Product Info",""],
        ["|Features","testlink.html"],
        ["|Installation","testlink.html"],
            ["||Description of Files","testlink.html"],
            ["||How To Setup","testlink.html"],
        ["|Parameters Info","testlink.html"],
        ["|Dynamic Functions","testlink.html"],
        ["|Supported Browsers","testlink.html"],
    ["Samples",""],
        ["|Sample 1","testlink.html"],
        ["|Sample 2","testlink.html"],
        ["|Sample 3","testlink.html"],
        ["|Sample 4","testlink.html"],
        ["|Sample 5","testlink.html"],
        ["|Sample 6","testlink.html"],
        ["|Sample 7","testlink.html"],
        ["|Sample 8","testlink.html"],
        ["|Sample 9","testlink.html"],
    ["Purchase","testlink.html"],
    ["Contact Us","testlink.html"],
];

dm_init();