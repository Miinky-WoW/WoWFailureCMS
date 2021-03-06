<?php
include("configs.php");
$page_cat = "settings";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb">
<head>
<title><?php echo $website['title']; ?> - Change Password</title>
<meta content="false" http-equiv="imagetoolbar" />
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
<link rel="shortcut icon" href="wow/static/local-common/images/favicons/bam.ico" type="image/x-icon"/>
<link rel="search" type="application/opensearchdescription+xml" href="http://eu.battle.net/en-gb/data/opensearch" title="Battle.net Search" />
<link rel="stylesheet" type="text/css" media="all" href="wow/static/local-common/css/management/common.css" />
<!--[if IE]><link rel="stylesheet" type="text/css" media="all" href="wow/static/local-common/css/common-ie.css?v22" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" media="all" href="wow/static/local-common/css/common-ie6.css?v22" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" media="all" href="wow/static/local-common/css/common-ie7.css?v22" /><![endif]-->
<link rel="stylesheet" type="text/css" media="all" href="wow/static/css/bnet.css" />
<link rel="stylesheet" type="text/css" media="print" href="wow/static/css/bnet-print.css" />
<!--[if IE]><link rel="stylesheet" type="text/css" media="all" href="wow/static/css/bnet-ie.css?v21" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" media="all" href="wow/static/css/bnet-ie6.css?v21" /><![endif]-->
<script type="text/javascript" src="wow/static/local-common/js/third-party/jquery-1.4.4-p1.min.js"></script>
<script type="text/javascript" src="wow/static/local-common/js/core.js"></script>
<script type="text/javascript" src="wow/static/local-common/js/tooltip.js"></script>
<!--[if IE 6]> <script type="text/javascript">
//<![CDATA[
try { document.execCommand('BackgroundImageCache', false, true) } catch(e) {}
//]]>
</script>
<![endif]-->
<script type="text/javascript">
//<![CDATA[
Core.staticUrl = '/account';
Core.sharedStaticUrl= 'wow/static/local-common';
Core.baseUrl = '/account';
Core.supportUrl = 'http://eu.battle.net/support/';
Core.secureSupportUrl= 'https://eu.battle.net/support/';
Core.project = 'bam';
Core.locale = 'en-gb';
Core.buildRegion = 'eu';
Core.shortDateFormat= 'dd/MM/yyyy';
Core.dateTimeFormat = 'dd/MM/yyyy HH:mm';
Core.loggedIn = true;
Flash.videoPlayer = 'http://eu.media.blizzard.com/global-video-player/themes/bam/video-player.swf';
Flash.videoBase = 'http://eu.media.blizzard.com/bam/media/videos';
Flash.ratingImage = 'http://eu.media.blizzard.com/global-video-player/ratings/bam/rating-pegi.jpg';
Flash.expressInstall= 'http://eu.media.blizzard.com/global-video-player/expressInstall.swf';
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-544112-16']);
_gaq.push(['_trackPageview']);
_gaq.push(['_trackPageLoadTime']);
//]]>
</script>
</head>
<body class="en-gb logged-in">
<div id="layout-top">
<div class="wrapper">
<div id="header">
<?php include("functions/header_account.php"); ?>
<?php include("functions/footer_man_nav.php"); ?>
</div>
<div id="layout-middle">
<div class="wrapper">
<div id="content">
<div id="page-header">
<span class="float-right"><span class="form-req">*</span> Required</span>
<h2 class="subcategory">Account Settings</h2>
<h3 class="headline">Change Your Password</h3>
</div>
<div id="page-content" class="page-content">
<p>You <b>MUST</b> be offline for this tool to successfully work! Plus you need to be Loged to the website. Use this form to change your password.</p>
<form autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<input type="hidden" name="csrftoken" value="" />
<?php 
if(isset($_POST['submit']))
{
        $account = $_POST['account'];
        $passwordOld = $_POST['passwordOld'];
        $passwordNew = $_POST['passwordNew'];
        $passwordNew1 = $_POST['passwordNew1'];
        $passwordolde = sha1(strtoupper($account) . ":" . strtoupper($passwordOld));
        $passwordnewe = sha1(strtoupper($account) . ":" . strtoupper($passwordNew));
        $passwordNew1e = sha1(strtoupper($account) . ":" . strtoupper($passwordNew1));

        $account = /*mysql_real_escape_string*/($account);
        $eoldpass = strtoupper($passwordolde);
        $enewpass = strtoupper($passwordnewe);
        $enewpass1 = strtoupper($passwordNew1e);
        
        $con = mysql_connect("$serveraddress", "$serveruser", "$serverpass") or die(mysql_error());
        mysql_select_db("$server_adb", $con) or die(mysql_error());
        $query = "SELECT id FROM account WHERE username = '".$account."' AND sha_pass_hash = '".$eoldpass."'";

        $result = mysql_query($query) or die(mysql_error());
        $numrows = mysql_num_rows($result);

        if($enewpass != $enewpass1) { die("<p align='center'>Error:<br><br>New password fields must match!<br><br>Please go back and try again.</p>"); }

        if(strlen($_POST['passwordNew']) < 5){
                $chars = strlen($passwordNew);
                die("<p align='center'>Error:<br><br>Your new password is too short!<br><br>You entered ".$chars." character(s).<br><br>The minimum length is 5 characters and the maximum length is 15.<br><br>Please go back and try again.</p>");
        }

        if($numrows == 0) { die("<p align='center'>Error:<br><br>Invalid account name/password!<br><br>Please go back and try again.</p>"); }

        $query = "UPDATE account SET sha_pass_hash = '".$enewpass."' WHERE username = '".$account."'";
		$query = "UPDATE account SET v = '0' WHERE username = '".$account."'";
        $result = mysql_query($query) or die(mysql_error());
        $query = "UPDATE account SET s = '0' WHERE username = '".$account."'";
        $result = mysql_query($query) or die(mysql_error());
        

        echo "<p align='center'>Password for the Account<br><br>'<b>".$account."</b>'<br><br>has been successfully changed!";

        //close mysql connection
        mysql_close($con);
}
else{
?>
<div class="form-row required">
<label for="oldPassword" class="label-full ">
<strong> Account Name:
</strong>
<span class="form-required">*</span>
</label>
<input type="text" id="firstname" disabled="disabled" name="account" value="<?php echo strtolower($_SESSION['username']); ?>" class=" input border-5 glow-shadow-2 form-disabled
" maxlength="16" tabindex="1" />
</div>
<div class="form-row required">
<label for="oldPassword" class="label-full ">
<strong> Old Password:
</strong>
<span class="form-required">*</span>
</label>
<input type="password" id="oldPassword" name="passwordOld" value="" class=" input border-5 glow-shadow-2
" maxlength="16" tabindex="1" />
</div>
<div class="form-row required">
<label for="newPassword" class="label-full ">
<strong> New Password:
</strong>
<span class="form-required">*</span>
</label>
<input type="password" id="newPassword" name="passwordNew" value="" class=" input border-5 glow-shadow-2
" maxlength="16" tabindex="1" />
<div class="ui-note">
<div class="form-note toggle-note border-5 glow-shadow" id="newPassword-note">
<div class="note">
<h5>Password Rules</h5><ul><li>Your password may only contain <strong>alphabetic characters (A–Z), numeric characters (0–9), and punctuation.</strong></li><li>Your password <strong>must</strong> contain at least one alphabetic character <strong>and</strong> one numeric character.</li><li>You cannot enter your account name as your password.</li><li>Your password must be between <strong>eight and sixteen characters</strong> in length.</li><li>For your security, we highly recommend you choose a unique password that you don’t use for any other online account.</li></ul>
<a href="#" class="close-note" rel="newPassword-note"></a>
</div>
<div class="note-arrow"></div>
</div>
<a href="#" class="note-toggler" rel="newPassword-note">
<img src="wow/static/images/icons/tooltip-help.gif" alt="?" width="16" height="16" />
</a>
</div>
</div>
<div class="form-row required">
<label for="newPasswordVerify" class="label-full ">
<strong> Confirm New Password:
</strong>
<span class="form-required">*</span>
</label>
<input type="password" id="newPasswordVerify" name="passwordNew1" value="" class=" input border-5 glow-shadow-2
" maxlength="16" tabindex="1" />
</div>
<fieldset class="ui-controls " >
<button
class="ui-button button1 disabled"
type="submit"
name="submit"
disabled="disabled"
id="settings-submit"
value="Change my password!"
tabindex="1">
<span>
<span>Continue</span>
</span>
</button>
<a class="ui-cancel "
href="account_man.php"
tabindex="1">
<span>
Cancel </span>
</a>
</fieldset>
</form>
</div>
</div>
<?php
}
?>
</div>
</div>
<div id="layout-bottom">
<?php include("functions/footer_man.php"); ?>
</div>
<script type="text/javascript">
//<![CDATA[
var xsToken = 'b213c993-d61d-4957-9141-9da399fd7d54';
var Msg = {
support: {
ticketNew: 'Ticket {0} was created.',
ticketStatus: 'Ticket {0}’s status changed to {1}.',
ticketOpen: 'Open',
ticketAnswered: 'Answered',
ticketResolved: 'Resolved',
ticketCanceled: 'Cancelled',
ticketArchived: 'Archived',
ticketInfo: 'Need Info',
ticketAll: 'View All Tickets'
},
cms: {
requestError: 'Your request cannot be completed.',
ignoreNot: 'Not ignoring this user',
ignoreAlready: 'Already ignoring this user',
stickyRequested: 'Sticky requested',
postAdded: 'Post added to tracker',
postRemoved: 'Post removed from tracker',
userAdded: 'User added to tracker',
userRemoved: 'User removed from tracker',
validationError: 'A required field is incomplete',
characterExceed: 'The post body exceeds XXXXXX characters.',
searchFor: "Search for",
searchTags: "Articles tagged:",
characterAjaxError: "You may have become logged out. Please refresh the page and try again.",
ilvl: "Item Lvl",
shortQuery: "Search requests must be at least three characters long."
},
bml: {
bold: 'Bold',
italics: 'Italics',
underline: 'Underline',
list: 'Unordered List',
listItem: 'List Item',
quote: 'Quote',
quoteBy: 'Posted by {0}',
unformat: 'Remove Formating',
cleanup: 'Fix Linebreaks',
code: 'Code Blocks',
item: 'WoW Item',
itemPrompt: 'Item ID:',
url: 'URL',
urlPrompt: 'URL Address:'
},
ui: {
viewInGallery: 'View in gallery',
loading: 'Loading…',
unexpectedError: 'An error has occurred',
fansiteFind: 'Find this on…',
fansiteFindType: 'Find {0} on…',
fansiteNone: 'No fansites available.'
},
grammar: {
colon: '{0}:',
first: 'First',
last: 'Last'
},
fansite: {
achievement: 'achievement',
character: 'character',
faction: 'faction',
'class': 'class',
object: 'object',
talentcalc: 'talents',
skill: 'profession',
quest: 'quest',
spell: 'spell',
event: 'event',
title: 'title',
arena: 'arena team',
guild: 'guild',
zone: 'zone',
item: 'item',
race: 'race',
npc: 'NPC',
pet: 'pet'
}
};
//]]>
</script>
<script type="text/javascript" src="wow/static/js/bam.js?v21"></script>
<script type="text/javascript" src="wow/static/local-common/js/tooltip.js?v22"></script>
<script type="text/javascript" src="wow/static/local-common/js/menu.js?v22"></script>
<script type="text/javascript">
$(function() {
Menu.initialize();
Menu.config.colWidth = 190;
Locale.dataPath = 'data/i18n.frag.xml';
});
</script>
<!--[if lt IE 8]>
<script type="text/javascript" src="wow/static/local-common/js/third-party/jquery.pngFix.pack.js?v22"></script>
<script type="text/javascript">$('.png-fix').pngFix();</script>
<![endif]-->
<script type="text/javascript" src="wow/static/js/settings/settings.js?v21"></script>
<script type="text/javascript" src="wow/static/js/settings/password.js?v21"></script>
<script type="text/javascript">
//<![CDATA[
Core.load("wow/static/local-common/js/overlay.js?v22");
Core.load("wow/static/local-common/js/search.js?v22");
Core.load("wow/static/local-common/js/third-party/jquery-ui-1.8.6.custom.min.js?v22");
Core.load("wow/static/local-common/js/third-party/jquery.mousewheel.min.js?v22");
Core.load("wow/static/local-common/js/third-party/jquery.tinyscrollbar.custom.js?v22");
Core.load("wow/static/local-common/js/login.js?v22", false, function() {
Login.embeddedUrl = 'https://eu.battle.net/login/login.frag';
});
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
(function() {
var ga = document.createElement('script');
var src = "https://ssl.google-analytics.com/ga.js";
if ('http:' == document.location.protocol) {
src = "http://www.google-analytics.com/ga.js";
}
ga.type = 'text/javascript';
ga.setAttribute('async', 'true');
ga.src = src;
var s = document.getElementsByTagName('script');
s = s[s.length-1];
s.parentNode.insertBefore(ga, s.nextSibling);
})();
//]]>
</script>
</body>
</html>