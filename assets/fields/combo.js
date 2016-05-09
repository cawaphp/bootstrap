var $ = require("jquery");
var locale = require("../../lang/fields-combo");


$.widget("cawa.fields-combo", $.cawa.widget, {

    options: {
        plugin: {
            width: '100%',
            theme: "bootstrap",
            language: $.locale()
        }
    },

    _select2: null,
    _hasValue: false,
    _create: function() {
        var self = this;
        var element = this.element;
        var options = self.options.plugin;

        // hide searchbox
        if (self.options.searchBox !== undefined && self.options.searchBox == false) {
            options.minimumResultsForSearch = Infinity;
        }

        // no result event
        if (self.options.noResultCreate) {
            options.language = {
                noResults: function (term)
                {
                    return locale[$.locale()]["noResult"];
                }
            };

            $(document).on("keyup", ".select2-search__field", function(event)
            {
                if (event.which == 13 && (!element.val() || self._hasValue)) {
                    element.val(null).trigger('change');
                    self.options.noResultCreate.call(self, event, $(event.target).val());
                }
            });
        }

        // remote ajax data sources
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

        self._select2 = element.select2(options);
        self._hasValue = element.val() !== "";
        self._select2.on("change", function()
        {
            self._hasValue = true;
        });

        // open menu on keypress
        $(self._select2).parent().find(".select2-selection").on("keydown", function(event)
        {
            var input = String.fromCharCode(event.which || event.keyCode);
            if (/[a-zA-Z0-9-_ ]/.test(input)) {
                self.element.select2("open");
            }
        });
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

