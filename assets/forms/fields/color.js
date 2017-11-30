require([
    "jquery",
    "jquery-simplecolorpicker/jquery.simplecolorpicker",
    "cawaphp/cawa/assets/widget"
], function($, locale, latinize)
{
    $.widget("cawa.fields-color", $.cawa.widget, {

        options: {
            plugin: {
                theme: "fontawesome",
                picker: true
            }
        },

        _create: function()
        {
            var input = this.element.find('input[type="text"]');
            var select = this.element.find('select');
            var change = function()
            {
                $(this).parent().find('span.simplecolorpicker').css('background', select.val());
                input.val(select.val());
            };

            select.val(input.val());

            $(select)
                .simplecolorpicker(this.options.plugin)
                .removeClass('hidden')
                .on('change load', change)
            ;

            input.on('click',  function () {
                select.simplecolorpicker('showPicker')
            });

            $.proxy(change, this.element)();
        }
    });
});
