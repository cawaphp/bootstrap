var $ = require("jquery");

$.widget("cawa.fields-image", $.cawa.widget, {

    options: {
        plugin: {
            language: $.locale()
        }
    },

    _create: function()
    {
        var pluginOptions = this.options.plugin;

        if (this.options.images) {
            pluginOptions["initialPreview"] = [];
            $(this.options.images).each(function (key, value)
            {
                pluginOptions["initialPreview"].push('<img src="' + value + '" class="file-preview-image" />');
            });
        }


        /* Plugins */
        this.element.fileinput(this.options.plugin);
    }
});

