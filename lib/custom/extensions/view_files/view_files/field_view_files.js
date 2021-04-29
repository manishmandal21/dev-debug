/* global confirm, redux, redux_change */

jQuery(document).ready(function() {
    jQuery('fieldset#dev_debug-view-log-file').parent().parent().find('th').remove()
    jQuery('fieldset#dev_debug-view-php-settings').parent().parent().find('th').remove()
    jQuery("p:contains(PHP Warning)").css("color", "rgb(255, 198, 38)");
    jQuery("p:contains(PHP Fatal error)").css("color", "rgb(245, 1, 1)");
    jQuery("p:contains(PHP Notice)").css("color", "rgb(1, 121, 245)");
    jQuery("p:contains(PHP Parse error)").css("color", "green");
    jQuery('fieldset#dev_debug-view-log-file > p:empty').remove()
    jQuery('.redux-ajax-loading').remove()
    jQuery('.spinner').remove()


});
