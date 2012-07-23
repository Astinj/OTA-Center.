<!DOCTYPE html>
<html>
<head>
    <title>OTA-Center.com</title>

    <meta name="description" content="Over The Air Rom Update Center." />
    <meta name="keywords" content="OTA, Over The Air, Rom, Update, Center, Android, XDA, Custom, Roms, AOSP, Sense, Updater, Admin, App, Online Updates" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
    <script type="text/javascript" src="js/_ajax.new.js?<?=rand()?>"></script>
    <script type="text/javascript" src="js/_formdata2querystring.js"></script>
    <!--<script type="text/javascript" src="js/_applogin.js?<?=rand()?>"></script>-->
    <script type="text/javascript" src="js/infieldlabels.js"></script>

</head>
<?php
include 'pages/config.php';
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
    'admin',
    'forgotpass',
    'faq'
);

$page = $_GET['page']; //sets the page variable from http request
?>
<body>
    <div id="main">
        <header>
            <div id="logo">
                <a href="#">
                    <img src="images/android.gif" alt="Android" width="300" height="148" />
                    <img src="images/test.png" alt="OTA Update Center" width="500" height="148" />
                </a>
            </div>
            <nav>
                <div id="menu_container">
                    <ul class="sf-menu" id="nav">
                        <li><a href="?page=home">Home</a></li>
                        <? if (isset($_SESSION['user_id'])) { ?>
                            <li>
                                <a href="#">Roms</a>
                                <ul>
                                    <li><a href="?page=list-roms">List</a></li>
                                    <li><a href="?page=add">Add</a></li>
                                </ul>
                            </li>
                        <? } ?>
                        <? if (isset($_SESSION['user_id'])) { ?>
                            <li>
                                <a href="#"><? echo $_SESSION['user_name']; ?></a>
                                <ul>
                                    <li><a href="?page=useropties">Settings</a></li>
                                    <li><a href="?page=uitloggen">Logout</a></li>
                                </ul>
                            </li>
                        <? } else { ?>
                            <li><a href="?page=registreer">Register</a></li>
                        <? } ?>
                        <? if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 1) { ?>
                            <li>
                                <a href="#">Admin</a>
                                <ul>
                                    <li><a href="?page=listusers">List Users</a></li>
                                    <li><a href="?page=useradd">Add User</a></li>
                                </ul>
                            </li>
                        <? }  ?>
                        <li><a href="?page=credits">Credits</a></li>
                        <li><a href="?page=faq">FAQ</a></li>
                        <li><a href="?page=irc">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="site_content">
            <div id="sidebar_container">
                <? if ($page != 'inloggen') { ?>
                    <? include 'pages/inloggen.php'; ?>
                <? } ?>
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
                <? if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 1) { ?>
                    <div></div>
                <? } else { ?>
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
                            <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                        </div>
                    </div>
                <? } ?>
            </div>
            <div class="content">
                <?php
                if (in_array($page, $allowed_url)) { //check to see if request is in the allowed url list
                    $file = "pages/$page.php"; //setup the full path to page if request is ok
                    if (file_exists($file)) { //make sure file exists
                        include $file;
                    } else { //if it doesnt exist, the default is used
                        include $default_url;
                    }
                } else { //if the request is not in the allowed url list, show default
                    include $default_url;
                }
                ?>
            </div>
        </div>
        <footer>
            <p>Copyright &copy; OTA-Center.com | <a href="http://m3nti0n-xda.deviantart.com/">design by M3NTI0N</a></p>
        </footer>
    </div>
    <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
    <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('ul.sf-menu').sooperfish();
        });
    </script>

</body>
</html>
