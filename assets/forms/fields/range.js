require([
    "jquery",
    "cawaphp/cawa/assets/widget"
], function($)
{
    $.widget("cawa.fields-range", $.cawa.widget, {
        options: {
        },
        _create: function()
        {
            this.element.bootstrapSlider();
        }
    });
});

