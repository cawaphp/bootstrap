require([
    "jquery",
    "cawaphp/cawa/assets/widget",
    "cawaphp/cawa/assets/functions",
    "bootstrap-fileinput/js/plugins/sortable",
    "bootstrap-fileinput/js/fileinput",
    "bootstrap-fileinput"
], function($)
{
    $.widget("cawa.fields-file", $.cawa.widget, {

        options: {
            plugin: {
                language: $.locale(),
                showUpload: false,
                showClose: false,
                fileActionSettings: {}
            }
        },

        _create: function ()
        {
            var self = this;
            var pluginOptions = this.options.plugin;

            if (this.options.files) {
                pluginOptions.initialPreview = [];
                pluginOptions.initialPreviewConfig = [];
                $.forEach(this.options.files, function (value, key)
                {
                    if (typeof value === "string") {
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

            if (this.options.deleteUrl) {
                pluginOptions.deleteUrl = this.options.deleteUrl;
            } else {
                pluginOptions.initialPreviewShowDelete = false;
            }

            if (!this.options.sortUrl) {
                pluginOptions.fileActionSettings.showDrag = false;
            }

            this.options.required = this.element.prop("required");
            this.element.prop("required", false);
            this.element.attr("data-rule-image", "true");

            /* Plugins */
            this.element.fileinput(pluginOptions);

            if (this.options.deleteUrl &&
                !this.element.prop("multiple") &&
                !this.options.required &&
                self.options.files
            ) {
                this.element.on('filecleared', function (event)
                {
                    $.ajax(self.options.deleteUrl, {
                        method: 'POST',
                        data: self.options.files[Object.keys(self.options.files)[0]].extra
                    })
                });
            }

            if (this.options.sortUrl) {
                this.element.on('filesorted', $.proxy(this._onSorted, this));
            }
        },

        _onSorted: function (event, params)
        {
            var data = {
                extra: params.stack[params.newIndex].extra,
                oldIndex: params.oldIndex,
                newIndex: params.newIndex
            };

            $.ajax({
                url: this.options.sortUrl,
                type: 'POST',
                dataType: "json",
                data: data
            });
        },

        isValid: function ()
        {
            if (this.options.required === false) {
                return true;
            }

            if (this.element.val()) {
                return true;
            }

            return this.element.closest(".file-input").find("img.file-preview-image").length > 0;
        }
    });

    if ($.validator) {
        $.validator.addMethod("image", function (value, element)
        {
            return $(element)["fields-file"]("isValid");
        }, $.validator.messages.required);
    }
});
