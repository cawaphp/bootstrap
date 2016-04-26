var $ = require("jquery");
var locale = require("../../lang/dialogs-confim");
var BootstrapDialog = require("bootstrap-dialog");

$.widget("cawa.dialog-confirm", $.cawa.widget, {

    options: {
        initSelector: '[data-confirm]',
        plugin: {
            title: locale[$.locale()]['title'],
            message: locale[$.locale()]['message'],
            animate: false,
            closable: true,
            type: BootstrapDialog.TYPE_WARNING
        }
    },

    _create: function ()
    {
        var self = this;
        var element = $(this.element);

        element.on("click", function (event)
        {
            event.stopPropagation();
            event.preventDefault();

            var options = self.options.plugin;

            if (element.attr("data-confirm") !== "true") {
                options.message = element.attr("data-confirm");
            }

            options.callback = function (result)
            {
                if (result) {
                    $.goto(element.attr("href"));
                }
            };

            BootstrapDialog.confirm(options);
        });
    }
});

