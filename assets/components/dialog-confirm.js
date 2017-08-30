require([
    "jquery",
    "../../lang/dialog-confirm",
    "cawaphp/cawa/assets/widget"
], function($, locale)
{
    $.widget("cawa.dialog-confirm", $.cawa.widget, {
        options: {
            initSelector: '[data-confirm]',
            message: locale[$.locale()]['message']
        },

        _create: function ()
        {
            var self = this;
            var element = $(this.element);

            element.on("click", function (event)
            {
                event.stopPropagation();
                event.preventDefault();

                var message = self.options.message;

                if (element.attr("data-confirm") !== "true") {
                    message = element.attr("data-confirm");
                }

                if (confirm(message)) {
                    $.goto(element.attr("href"));
                }

                return false;
            });
        }
    });
});
