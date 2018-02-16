require([
    "jquery",
    "sweetalert2",
    "../../lang/dialog-confirm",
    "cawaphp/cawa/assets/widget"
], function($, swal, locale)
{
    $.widget("cawa.dialog-confirm", $.cawa.widget, {
        options: {
            initSelector: '[data-confirm]',
            message: locale[$.locale()]['message'],
            cancelButton: locale[$.locale()]['cancel']
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
                var cancelButton = self.options.cancelButton;

                if (element.attr("data-confirm") !== "true") {
                    message = element.attr("data-confirm");
                }

                swal({
                    text: message,
                    type: 'question',
                    cancelButtonText: cancelButton,
                    showCancelButton: true
                }).then(function (result) {
                    if (result.value) {
                        $.goto(element.attr("href"));
                    }
                });

                return false;
            });
        }
    });
});
