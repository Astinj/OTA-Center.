<?php
// Connect to server and select database.
include('safe_admin.php');
//mysql_connect("$db_host", "$db_user", "$db_pass")or die("cannot connect");
//mysql_select_db("$db_db")or die("cannot select DB");
if (isset($_SESSION['user_id'])) {
    ?>

    <div id="registration">
        <h2>Add User</h2>

        <form id="RegisterUserForm" action="?page=useradd_ac" method="post">
            <fieldset>
                <p>
                    <label for="naam">Username</label>
                    <input id="rom" name="naam" type="text" class="rom" value="" />
                </p>
                <p>
                    <label for="wachtwoord">Password</label>
                    <input id="rom" name="wachtwoord" type="password" class="rom" value="changeme" />
                </p>
                <p>
                    <label for="status">Status</label>
                    <input id="rom" name="status" type="text" class="rom" value="0" />
                </p>
                <p>
                    <label for="email">Email</label>
                    <input id="rom" name="email" type="text" class="rom" value="" />
                </p>
                <p>
                    <label for="actief">Actief?</label>
                    <input id="rom" name="actief" type="text" class="rom" value="1" />
                </p>
                <p>
                    <label for="actcode">Activation code</label>
                    <textarea id="rom" name="actcode" class="rom"></textarea>			
                </p>
                <p>
                    <button id="addUserNew" name="submit" type="submit">Add User</button>
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
            (function($) {
                $.InFieldLabels = function(label, field, options) {
                    var base = this;
                    base.$label = $(label);
                    base.$field = $(field);
                    base.$label.data("InFieldLabels", base);
                    base.showing = true;
                    base.init = function() {
                        base.options = $.extend({}, $.InFieldLabels.defaultOptions, options);
                        base.$label.css('position', 'absolute');
                        var fieldPosition = base.$field.position();
                        base.$label.css({ 'left': fieldPosition.left, 'top': fieldPosition.top }).addClass(base.options.labelClass);
                        if (base.$field.val() != "") {
                            base.$label.hide();
                            base.showing = false;
                        };
                        base.$field.focus(function() {
                            base.fadeOnFocus();
                        }).blur(function() {
                            base.checkForEmpty(true);
                        }).bind('keydown.infieldlabel', function(e) {
                            base.hideOnChange(e);
                        }).change(function(e) {
                            base.checkForEmpty();
                        }).bind('onPropertyChange', function() {
                            base.checkForEmpty();
                        });
                    };
                    base.fadeOnFocus = function() {
                        if (base.showing) {
                            base.setOpacity(base.options.fadeOpacity);
                        };
                    };
                    base.setOpacity = function(opacity) {
                        base.$label.stop().animate({ opacity: opacity }, base.options.fadeDuration);
                        base.showing = (opacity > 0.0); };
                        base.checkForEmpty = function(blur) {
                            if (base.$field.val() == "") {
                                base.prepForShow();
                                base.setOpacity(blur ? 1.0 : base.options.fadeOpacity);
                            } else {
                                base.setOpacity(0.0);
                            };
                        };
                        base.prepForShow = function(e) {
                            if (!base.showing) {
                                base.$label.css({ opacity: 0.0 }).show();
                                base.$field.bind('keydown.infieldlabel', function(e) {
                                    base.hideOnChange(e);
                                });
                            };
                        };
                        base.hideOnChange = function(e) {
                            if ((e.keyCode == 16) || (e.keyCode == 9)) return;
                            if (base.showing) {
                                base.$label.hide();
                                base.showing = false;
                            };
                            base.$field.unbind('keydown.infieldlabel');
                        };
                        base.init();
                };
                $.InFieldLabels.defaultOptions = { fadeOpacity: 0.5, fadeDuration: 300, labelClass: 'infield' };
                $.fn.inFieldLabels = function(options) {
                    return this.each(function() {
                        var for_attr = $(this).attr('for');
                        if (!for_attr) return;
                        var $field = $("input#" + for_attr + "[type='text']," +
                                "input#" + for_attr + "[type='password']," +
                                "input#" + for_attr + "[type='tel']," +
                                "input#" + for_attr + "[type='email']," +
                                "textarea#" + for_attr);
                        if ($field.length == 0) return;
                        (new $.InFieldLabels(this, $field[0], options));
                    });
                };
            })(jQuery);


            $("#RegisterUserForm label").inFieldLabels();
        });
    </script>
    <?
} else {
    echo "You are not logged in...";
}
?>
