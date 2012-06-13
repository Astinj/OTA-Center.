<!DOCTYPE HTML>
<html>
<head>
  <title>OTA-Center.com</title>
  <meta name="description" content="Over The Air Rom Update Center." />
  <meta name="keywords" content="OTA, Over The Air, Rom, Update, Center, Android, XDA, Custom, Roms, AOSP, Sense, Updater, Admin, App, Online Updates" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <script type="text/javascript" src="js/_ajax.new.js?<?=rand()?>"></script>
  <script type="text/javascript" src="js/_formdata2querystring.js"></script>
  <script type="text/javascript" src="js/_applogin.js?<?=rand()?>"></script>
  <script type="text/javascript">

 $(document).ready(function() {
/*
* In-Field Label jQuery Plugin
* http://fuelyourcoding.com/scripts/infield.html
*
* Copyright (c) 2009 Doug Neiner
* Dual licensed under the MIT and GPL licenses.
* Uses the same license as jQuery, see:
* http://docs.jquery.com/License
*
* @version 0.1
*/
(function($) { $.InFieldLabels = function(label, field, options) { var base = this; base.$label = $(label); base.$field = $(field); base.$label.data("InFieldLabels", base); base.showing = true; base.init = function() { base.options = $.extend({}, $.InFieldLabels.defaultOptions, options); base.$label.css('position', 'absolute'); var fieldPosition = base.$field.position(); base.$label.css({ 'left': fieldPosition.left, 'top': fieldPosition.top }).addClass(base.options.labelClass); if (base.$field.val() != "") { base.$label.hide(); base.showing = false; }; base.$field.focus(function() { base.fadeOnFocus(); }).blur(function() { base.checkForEmpty(true); }).bind('keydown.infieldlabel', function(e) { base.hideOnChange(e); }).change(function(e) { base.checkForEmpty(); }).bind('onPropertyChange', function() { base.checkForEmpty(); }); }; base.fadeOnFocus = function() { if (base.showing) { base.setOpacity(base.options.fadeOpacity); }; }; base.setOpacity = function(opacity) { base.$label.stop().animate({ opacity: opacity }, base.options.fadeDuration); base.showing = (opacity > 0.0); }; base.checkForEmpty = function(blur) { if (base.$field.val() == "") { base.prepForShow(); base.setOpacity(blur ? 1.0 : base.options.fadeOpacity); } else { base.setOpacity(0.0); }; }; base.prepForShow = function(e) { if (!base.showing) { base.$label.css({ opacity: 0.0 }).show(); base.$field.bind('keydown.infieldlabel', function(e) { base.hideOnChange(e); }); }; }; base.hideOnChange = function(e) { if ((e.keyCode == 16) || (e.keyCode == 9)) return; if (base.showing) { base.$label.hide(); base.showing = false; }; base.$field.unbind('keydown.infieldlabel'); }; base.init(); }; $.InFieldLabels.defaultOptions = { fadeOpacity: 0.5, fadeDuration: 300, labelClass: 'infield' }; $.fn.inFieldLabels = function(options) { return this.each(function() { var for_attr = $(this).attr('for'); if (!for_attr) return; var $field = $("input#" + for_attr + "[type='text']," + "input#" + for_attr + "[type='password']," + "input#" + for_attr + "[type='tel']," + "input#" + for_attr + "[type='email']," + "textarea#" + for_attr); if ($field.length == 0) return; (new $.InFieldLabels(this, $field[0], options)); }); }; })(jQuery);


    $("#RegisterUserForm label").inFieldLabels();
});

</script>
</head>
<?php 
include('pages/config.php');
$default_url = 'pages/home.php'; //sets the default_url variable 

$allowed_url = array( //this is our array of allowed requests 
'home', 
'add',
'add_ac',
'inloggen', 
'uitloggen',
'list-roms',
'listusers',
'userupdate',
'userupdate_ac',
'userdel_ac',
'useradd',
'useradd_ac',
'registreer',
'activeren',
'update',
'update_ac',
'useropties',
'del_ac',
'denied',
'credits',
'irc',
'admin'
); 

$page = $_GET['page']; //sets the page variable from http request 
?>
<body>
  <div id="main">
    <header>
      <div id="logo">
		<a href="#"><img style="" src="./images/android.gif" /><img style="" src="./images/test.png" /></a>
      </div>
      <nav>
        <div id="menu_container">
          <ul class="sf-menu" id="nav">
            <li><a href="?page=home">Home</a></li>
            <? if(isset($_SESSION['user_id'])) { ?>
            <li><a href="#">Roms</a>
            	<ul>
                	<li><a href="?page=list-roms">List</a></li>
                    <li><a href="?page=add">Add</a></li>
				</ul>
            </li>
            <? } else { } ?>
            <? if(isset($_SESSION['user_id'])) { ?>
				<li><a href="#"><? echo $_SESSION['user_name']; ?></a>
					<ul>
						<li><a href="?page=useropties">Settings</a></li>
						<li><a href="?page=uitloggen">Logout</a></li>
					</ul>
				</li>
			<? } else { ?> 
				<li><a href="?page=registreer">Register</a></li>
			<? }
			   if ($_SESSION['user_status'] == 1) { ?>
					<li><a href="#">Admin</a>
						<ul>
							<li><a href="?page=listusers">List Users</a></li>
							<li><a href="?page=useradd">Add User</a></li>
						</ul>
					</li>
					<? } else { } ?>
            <li><a href="?page=credits">Credits</a></li>
			<li><a href="?page=irc">Contact Us</a></li>

          </ul>
        </div>
      </nav>
    </header>
    <div id="site_content">
      <div id="sidebar_container">
		<? /* if(isset($_SESSION['user_id'])) { */?>
			<!-- <div class="sidebar">
				<? include('./pages/loggedin.php'); ?>
			</div> -->

			<?/* } else { */?>
			<div class="sidebar">
				<? include('./pages/inloggen.php'); ?>
			</div>
			<?/* } */?>
        <div class="sidebar">
          <h3>Useful Links</h3>
          <ul>
            <li><a href="http://www.xda-developers.com/" target="xdadevelopers">Xda-developers</a></li>
            <li><a href="#">Another Link</a></li>
            <li><a href="#">And Another</a></li>
            <li><a href="#">One More</a></li>
            <li><a href="#">Last One</a></li>
          </ul>
        </div>
		<? if($_SESSION[user_status] == 1 ) { ?> <div> </div> <? } else { ?>

		<div class="sidebar">
          <h3>Google Ads</h3>
			<div class="gsense">
				<script type="text/javascript"><!--
					google_ad_client = "ca-pub-2008116459666804";
					/* RomUpdater Little */
					google_ad_slot = "3822632448";
					google_ad_width = 250;
					google_ad_height = 250;
					//-->
				</script>
				<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div> 
        </div><? } ?>
      </div>
      <div class="content">
		<?php 
        if (in_array( $page, $allowed_url)) { //check to see if request is in the allowed url list 
			$file = "pages/".$page.".php"; //setup the full path to page if request is ok 
		    if(file_exists($file)) { //make sure file exists 
				include($file); 
			} else { //if it doesnt exist, the default is used 
				include($default_url); 
		    } 
		}else{ //if the request is not in the allowed url list, show default 
		    include($default_url); 
		}  
        ?>

      </div>
    </div>
    <footer>
      <p>Copyright &copy; OTA-Center.com | <a href="http://m3nti0n-xda.deviantart.com/">design by M3NTI0N</a></p>
    </footer>
  </div>
  <p>&nbsp;</p>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>