var $ = require("jquery");


/*
if ($.fn.modal) {
    console.log("sdfsd");
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
}
*/



$.widget("cawa.fields-combo", $.cawa.widget, {

    options: {
        plugin: {
            theme: "bootstrap",
            language: $.locale()
        }
    },

    _create: function() {
        var self = this;
        var element = this.element;
        var options = self.options.plugin;

        if (options.searchBox !== undefined && options.searchBox == false) {
            options.minimumResultsForSearch = Infinity;
        }

        if (options.ajax) {
            options.ajax.dataType = 'json';
            options.ajax.data = $.proxy(self._processParam, self);
            options.ajax.processResults = $.proxy(self._processResult, self);

            if (this.options.remoteHtml) {
                options.escapeMarkup = function (markup)
                {
                    return markup;
                };

                options.templateResult = function(data)
                {
                    return  data.html;
                };
                options.templateSelection = function(data)
                {
                    return  data.text;
                };
            }

            if (!options.ajax.delay) {
                options.ajax.delay = 250;
            }
        }

        /*
         * @see http://stackoverflow.com/a/33884094/1590168
         * @see https://github.com/select2/select2/issues/1645
         * @see https://github.com/twbs/bootstrap/pull/12142
         */
        var bootstrapDialog = element.closest(".bootstrap-dialog");
        if (bootstrapDialog.length) {
            options.dropdownParent = bootstrapDialog;
        }

        element.select2(options);
    },

    _processParam: function (params)
    {
        var query = {
            query: params.term,
            page: params.page
        };

        if (this.options.remoteHtml) {
            query.html = true;
        }

        return query;
    },

    _processResult: function (data, params)
    {
        // select2 format
        if (data.results) {
            return data;
        }

        // cawa format {items: [], count: 123, page: 12}
        params.page = params.page || 1;

        if (data.items) {
            return {
                results: data.items,
                pagination: {
                    more: params.page < data.page
                }
            };
        }

        // default
        return {
            results: data
        };
    }
});

