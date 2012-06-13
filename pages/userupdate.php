<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update: you can edit the details of given rom(id)
// the adress would be something like this: http://<domain>/<path>/update.php?id=<romid>
include('./pages/safe_admin.php');
// Connect to server and select database.
error_reporting(E_ALL); ini_set('display_errors', true);
mysql_connect($db_host, $db_user, $db_pass)or die("cannot connect");
mysql_select_db($db_db)or die("cannot select DB");
//Continue when ID is set in the header
if(!empty($_GET['id'])) {
	$id = $_GET['id'];
	
	// Retrieve data from database
	$sql = "SELECT * FROM gebruikers WHERE id = '".$id."'";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	?>

		<div id="registration">
			<h2>Update User</h2>
			<form id="RegisterUserForm" action="?page=userupdate_ac" method="post">
				<fieldset>
					<p>
						<label for="naam">Username:</label>
						<input id="rom" name="naam" type="text" class="rom" value="<? echo $rows['naam']; ?>" />
					</p>
					<p>
						<label for="wachtwoord">Password in md5:</label>
						<input id="rom" name="wachtwoord" type="text" class="rom" value="<? echo $rows['wachtwoord']; ?>" />
					</p>
					<p>
						<label for="status">Status: <small>(Admin = 1 / User = 0)</small></label>
						<input id="rom" name="status" type="text" class="rom" value="<? echo $rows['status']; ?>" />
					</p>
					<p>
						<label for="email">Email:</label>
						<input id="rom" name="email" type="text" class="rom" value="<? echo $rows['email']; ?>" />
					</p>
					<p>
						<label for="actief">Active: <small>(Active = 1 / Inactive = 0)</small></label>
						<input id="rom" name="actief" type="text" class="rom" value="<? echo $rows['actief']; ?>" />
					</p>							 
					<p>
						<label for="lastactive">Last active on:</label>
						<input id="rom" name="lastactive" disable="disable" type="text" class="rom" value="<? echo $rows['lastactive']; ?>" />
					</p>				 
					<input name="id" type="hidden" id="id" value="<? echo $rows['id']; ?>">
					<input name="actcode" type="hidden" id="actcode" value="<? echo $rows['actcode']; ?>">
					
					<p>
						<button id="updateRomNew" name="submit_form" type="submit">Update Rom</button>
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
} else {
	echo "fuck you, add an id at the end of the url ass!";
}