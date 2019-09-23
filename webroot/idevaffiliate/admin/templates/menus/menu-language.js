var itemStylesNames=["Individual Style",];
var menuStylesNames=["Individual Style",];

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
var blankImage="templates/menus/images/blank.gif";

//--- Dimensions
var menuWidth="100%";
var menuHeight="";
var smWidth="";
var smHeight="";

//--- Positioning
var absolutePos=0;
var posX="10";
var posY="10";
var topDX=0;
var topDY=1;
var DX=1;
var DY=0;

//--- Font
var fontStyle="normal 11px Tahoma";
var fontColor=["#000000","#FFFFFF"];
var fontDecoration=["none","none"];
var fontColorDisabled="#AAAAAA";

//--- Appearance
var menuBackColor="";
var menuBackImage="";
var menuBackRepeat="repeat";
var menuBorderColor="";
var menuBorderWidth=0;
var menuBorderStyle="solid";

//--- Item Appearance
var itemBackColor=["",""];
var itemBackImage=["",""];
var itemBorderWidth=0;
var itemBorderColor=["#FCEEB0","#4C99AB"];
var itemBorderStyle=["solid","solid"];
var itemSpacing=1;
var itemPadding="3";
var itemAlignTop="left";
var itemAlign="left";
var subMenuAlign="";

//--- Icons
var iconTopWidth=12;
var iconTopHeight=12;
var iconWidth=18;
var iconHeight=18;
var arrowWidth=7;
var arrowHeight=7;
var arrowImageMain=["",""];
var arrowImageSub=["templates/menus/images/arr_black_2.gif","templates/menus/images/arr_black_2.gif"];

//--- Separators
var separatorImage="templates/menus/images/sep_grey.gif";
var separatorWidth="80%";
var separatorHeight="3";
var separatorAlignment="right";
var separatorVImage="";
var separatorVWidth="3";
var separatorVHeight="100%";

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
var transOptions="";
var transDuration=350;
var transDuration2=200;
var shadowLen=4;
var shadowColor="#B1B1B1";
var shadowTop=0;

//--- CSS Support (CSS-based Menu)
var cssStyle=1;
var cssSubmenu="submenu1";
var cssItem=["item1","item2"];
var cssItemText=["text1","text2"];

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
var keystrokes=1;
var dm_focus=1;
var dm_actKey=113;

var itemStyles = [
    ["CSS=topitem1,topitem2","CSSText=toptext1,toptext2"],
];
var menuStyles = [
    ["CSS=topsubmenu"],

];

var menuItems = [

    ["<b>General Content</b>","", "templates/menus/images/gopen2.gif", , , , "0", , , ],
        ["|Header Content","setup.php?action=33&content=1", "", "", , , , , , ],
        ["|Footer Content","setup.php?action=33&content=2", "", "", , , , , , ],
        ["|Custom Fields Group Title","setup.php?action=33&content=3", "", "", , , , , , ],
        ["|Account Suspended","setup.php?action=33&content=24", "", "", , , , , , ],
        ["|Account Pending Approval","setup.php?action=33&content=25", "", "", , , , , , ],
    ["<b>Standard Pages</b>","", "templates/menus/images/gopen2.gif", , , , "0", , , ],
        ["|Index Page","", "", "", , , , , , ],
        	["||Main Page Content","setup.php?action=33&content=4", "", "", , , , , , ],
        	["||Login Box Content","setup.php?action=33&content=5", "", "", , , , , , ],
        	["||Details Table Content","setup.php?action=33&content=6", "", "", , , , , , ],
        ["|Signup Page","", "", "", , , , , , ],
        	["||Signup Success","setup.php?action=33&content=7", "", "", , , , , , ],
        	["||Left Column","setup.php?action=33&content=8", "", "", , , , , , ],
        	["||Login Box","setup.php?action=33&content=9", "", "", , , , , , ],
        	["||Standard Info Box","setup.php?action=33&content=10", "", "", , , , , , ],
        	["||Personal Info Box","setup.php?action=33&content=11", "", "", , , , , , ],
        	["||Commission Style Box","setup.php?action=33&content=12", "", "", , , , , , ],
        	["||PayPal Box","setup.php?action=33&content=13", "", "", , , , , , ],
        	["||Terms & Conditions Box","setup.php?action=33&content=14", "", "", , , , , , ],
        	["||Security Code Box","setup.php?action=33&content=66", "", "", , , , , , ],
        	["||Bottom Section","setup.php?action=33&content=15", "", "", , , , , , ],
        	["||Mainenance Page","setup.php?action=33&content=69", "", "", , , , , , ],
        	["||CANSPAM","setup.php?action=33&content=70", "", "", , , , , , ],
        ["|Login Page","", "", "", , , , , , ],
        	["||Left Column","setup.php?action=33&content=16", "", "", , , , , , ],
        	["||Main Page","setup.php?action=33&content=17", "", "", , , , , , ],
        ["|Logout Page","setup.php?action=33&content=18", "", "", , , , , , ],
        ["|Account Page","setup.php?action=33&content=19", "", "", , , , , , ],
        ["|Contact Us","", "", "", , , , , , ],
        	["||Left Column","setup.php?action=33&content=54", "", "", , , , , , ],
        	["||Main Page","setup.php?action=33&content=55", "", "", , , , , , ],
    ["<b>Internal Pages</b>","", "templates/menus/images/gopen2.gif", , , , "0", , , ],
        ["|Account Overview","", "", "", , , , , , ],
        ["||General Statistics","setup.php?action=33&content=53", "", "", , , , , , ],
        ["||Tier Statistics","setup.php?action=33&content=48", "", "", , , , , , ],
        ["||Payment History","setup.php?action=33&content=47", "", "", , , , , , ],
        ["||Commission Details","setup.php?action=33&content=52", "", "", , , , , , ],
        	["|||Commission Details View","setup.php?action=33&content=51", "", "", , , , , , ],
        ["||Recurring Commissions","setup.php?action=33&content=49", "", "", , , , , , ],
        ["||Incoming Traffic Log","setup.php?action=33&content=46", "", "", , , , , , ],
        ["||Logo Upload","setup.php?action=33&content=65", "", "", , , , , , ],
        ["|Marketing Materials","", "", "", , , , , , ],
        ["||General Marketing Content","setup.php?action=33&content=57", "", "", , , , , , ],
        ["||Banners","setup.php?action=33&content=41", "", "", , , , , , ],
        ["||Page Peels","setup.php?action=33&content=58", "", "", , , , , , ],
        ["||Lightboxes","setup.php?action=33&content=59", "", "", , , , , , ],
        ["||Text Ads","setup.php?action=33&content=42", "", "", , , , , , ],
        ["||Text Links","setup.php?action=33&content=43", "", "", , , , , , ],
        ["||Email Links","setup.php?action=33&content=44", "", "", , , , , , ],
        ["||Email Templates","setup.php?action=33&content=68", "", "", , , , , , ],
        ["||HTML Ads","setup.php?action=33&content=45", "", "", , , , , , ],
        ["||Offline Marketing","setup.php?action=33&content=40", "", "", , , , , , ],
        ["||Tier Links","setup.php?action=33&content=50", "", "", , , , , , ],
        ["||Email Friends","setup.php?action=33&content=36", "", "", , , , , , ],
        ["||Custom Links","setup.php?action=33&content=34", "", "", , , , , , ],
        ["||PDF Documents","setup.php?action=33&content=60", "", "", , , , , , ],
        ["|Account Management","", "", "", , , , , , ],
        ["||CommissionAlert","setup.php?action=33&content=33", "", "", , , , , , ],
        ["||CommissionStats","setup.php?action=33&content=32", "", "", , , , , , ],
        ["||Edit Account","setup.php?action=33&content=31", "", "", , , , , , ],
        ["||Change Password","setup.php?action=33&content=26", "", "", , , , , , ],
        ["||Change Commission Style","setup.php?action=33&content=21", "", "", , , , , , ],
        ["|General Information","", "", "", , , , , , ],
        ["||Browse Other Affiliates","setup.php?action=33&content=22", "", "", , , , , , ],
        ["||Frequently Asked Questions","setup.php?action=33&content=23", "", "", , , , , , ],
        ["|Payment Invoice","setup.php?action=33&content=56", "", "", , , , , , ],
        ["|Custom Tracking Links","", "", "", , , , , , ],
        ["||Keyword Tracking Links","setup.php?action=33&content=61", "", "", , , , , , ],
        ["||Sub-Affiliate Tracking Links","setup.php?action=33&content=62", "", "", , , , , , ],
        ["||Alternate Incoming Links","setup.php?action=33&content=63", "", "", , , , , , ],
        ["||Custom Reports","setup.php?action=33&content=64", "", "", , , , , , ],
        ["||Excel Report","setup.php?action=33&content=67", "", "", , , , , , ],

    ["<b>Affiliate Menu</b>","setup.php?action=33&content=20", "templates/menus/images/gopen2.gif", , , , "0", , , ],
    ["<b>Error Messages</b>","setup.php?action=33&content=30", "templates/menus/images/gopen2.gif", , , , "0", , , ],
    ["<b>Help Boxes</b>","", "templates/menus/images/gopen2.gif", , , , "0", , , ],
        ["||Change Password: New Password","setup.php?action=33&content=28", "", "", , , , , , ],
        ["||Change Password: Confirm Password","setup.php?action=33&content=29", "", "", , , , , , ],
        ["||Custom Links: Tracking Keyword","setup.php?action=33&content=35", "", "", , , , , , ],
        ["||Email Friends: Subject","setup.php?action=33&content=37", "", "", , , , , , ],
        ["||Email Friends: Message","setup.php?action=33&content=38", "", "", , , , , , ],
        ["||Email Friends: Footer","setup.php?action=33&content=39", "", "", , , , , , ],
];

dm_init();
