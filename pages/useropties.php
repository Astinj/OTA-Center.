<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: wachtwoord.php: Pagina om wachtwoord te wijzigen
// Inloggen verplicht; safe.php
include("safe.php");

if(isset($_POST['submit'])) {
 if(preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$/i", $_POST['email'])) {
  if($_POST['pass1'] != "") {
   // Wachtwoord wijzigen
   $sql = "SELECT wachtwoord FROM gebruikers WHERE id='".$_SESSION['user_id']."'";
   $query = mysql_query($sql);
   $rij = mysql_fetch_object($query);
   $dbpass = htmlspecialchars($rij->wachtwoord);
   if($dbpass == md5($_POST['pasnow'])) {
    if($_POST['pass1'] == $_POST['pass2']) {
     $newpass = md5($_POST['pass1']);
     $sql = "UPDATE gebruikers SET email='".$_POST['email']."',wachtwoord='".$newpass."' WHERE id='".$_SESSION['user_id']."'";
     $query = mysql_query($sql);
     if($query == TRUE) {
      echo "Your mailadress is changed to '".$_POST['email']."', your password has changed too.<br />\n<a href=\"?page=useropties\">&laquo; Go back</a>";
      if(isset($_COOKIE['user_password'])) {
       setcookie("user_password", $newpass, time() + 365 * 86400);
      }
     }else{
      echo "An error has occured while changing password or mailadress... Please try again later.<br />\n<a href=\"javascript:history.back()\">&laquo; Go Back</a>";
     }
    }else{
     echo "The new passwords do not match. Please try again.<br />\n<a href=\"javascript:history.back()\">&laquo; Go Back</a>";
    }
   }else{
    echo "The filled out 'current password' is not right.<br />\n<a href=\"javascript:history.back()\">&laquo; Go Back</a>";
   }
  }else{
   // Alleen e-mail wijzigen
   $sql = "UPDATE gebruikers SET email='".$_POST['email']."' WHERE id='".$_SESSION['user_id']."'";
   $query = mysql_query($sql);
   if($query == TRUE) {
    echo "Your mailadress has changed to '".$_POST['email']."'.<br />\n<a href=\"?page=useropties\">&laquo; Go Back</a>";
   }else{
    echo "An error occured while changing your mailadress. Please try again later.<br />\n<a href=\"javascript:history.back()\">&laquo; Go Back</a>";
   }
  }
 }else{
  echo "You'd fill out a wrong mailadress (it has to look like name@domain.com).<br />\n<a href=\"javascript:history.back()\">&laquo; Go Back</a>";
 }
}else{
 // Formulier
 $sql = "SELECT naam,email FROM gebruikers WHERE id='".$_SESSION['user_id']."'";
 $query = mysql_query($sql);
 $rij = mysql_fetch_object($query);
 $naam = htmlspecialchars($rij->naam);
 $email = htmlspecialchars($rij->email);
 ?>
 <div id="registration">
 <h2>Edit your Account</h2>

 <form id="RegisterUserForm" action="?page=useropties" method="post">
 	<fieldset>
         <p>
         Username: <b><?= $naam ?></b>

         </p>
         <p>
            <label for="email">Email</label>
            <input id="email" name="email" type="text" class="text" value="" />
         </p> 
		 <p>
            <label for="pasnow">Current Password</label>
            <input id="pasnow" name="pasnow" class="text" type="password" />
         </p>
		 <p>
            <label for="pass1">New Password</label>
            <input id="pass1" name="pass1" class="text" type="password" />
         </p>
         <p>
            <label for="pass2">Verify</label>
            <input id="pass2" name="pass2" class="text" type="password" />
         </p>
         <p>
            <button id="updateAccountNew" name="submit" type="submit">Save</button>
         </p>
 	</fieldset>

 </form>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>

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
 <?
}

?>