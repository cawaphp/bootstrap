/**
 * @see http://stackoverflow.com/questions/29331261/disable-radio-button-in-bootstrap-3
 * @see https://github.com/twbs/bootstrap/issues/16703
 */
require([
    "jquery",
    "cawaphp/cawa/assets/widget"
], function($)
{
    $.widget("cawa.fields-button-group", $.cawa.widget, {
        _create: function() {
            this.element.on("click", ".disabled", function(event) {
                event.preventDefault();
                return false;
            });
        }
    });
});
