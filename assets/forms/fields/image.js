var $ = require("jquery");
var _ = require("lodash");

$.widget("cawa.fields-image", $.cawa.widget, {

    options: {
        plugin: {
            language: $.locale(),
            showUpload: false,
            showClose: false,
            showDelete: true
        }
    },

    _create: function()
    {
        var pluginOptions = this.options.plugin;

        if (this.options.images) {
            pluginOptions.initialPreview = [];
            pluginOptions.initialPreviewConfig = [];
            _.each(this.options.images, function (value, key)
            {
                if (typeof value == "string") {
                    pluginOptions.initialPreview.push('<img src="' + value + '" class="file-preview-image" />');
                } else {
                    pluginOptions.initialPreview.push('<img src="' + key + '" class="file-preview-image" />');
                    pluginOptions.initialPreviewConfig.push(value);
                }
            });
        }

        if (this.element.prop("multiple")) {
            pluginOptions.overwriteInitial = false;
        }

        this.options.required = this.element.prop("required");
        this.element.prop("required", false);
        this.element.attr("data-rule-image", "true");

        /* Plugins */
        this.element.fileinput(pluginOptions);
    },

    isValid: function()
    {
        if (this.options.required == false) {
            return true;
        }

        if(this.element.val()) {
            return true;
        }

        return this.element.closest(".file-input").find("img.file-preview-image").length > 0;
    }
});

if ($.validator) {
    $.validator.addMethod("image", function (value, element)
    {
        return $(element)["fields-image"]("isValid");
    }, $.validator.messages.required);
}
