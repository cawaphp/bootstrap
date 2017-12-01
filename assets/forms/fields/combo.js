require([
    "jquery",
    "../../../lang/fields-combo",
    "latinize",
    "cawaphp/cawa/assets/widget",
    "select2"
], function($, locale, latinize)
{
    $.widget("cawa.fields-combo", $.cawa.widget, {

        options: {
            initSelector: 'select.cawa-fields-combo', // select2 copy class of current element
            plugin: {
                theme: "bootstrap",
                language: $.locale()
            }
        },

        _select2: null,
        _hasValue: false,
        _create: function()
        {
            var self = this;
            var element = this.element;
            var options = self.options.plugin;

            // hide searchbox
            if (self.options.searchBox !== undefined && self.options.searchBox === false) {
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

                var keyupCallback = function (event)
                {
                    if (element.select2("isOpen") && event.which === 13 && (!element.val() || self._hasValue)) {
                        element.val(null).trigger('change');
                        self.options.noResultCreate.call(self, event, $(event.target).val());
                    }
                };
                $(document).on("keyup", ".select2-search__field", keyupCallback);

                self.addDestroyCallback(function()
                {
                    $(document).off("keyup", ".select2-search__field", keyupCallback);
                });
            }

            // remote ajax data sources
            if (options.ajax) {
                options.ajax.dataType = 'json';
                options.ajax.queryType = 'autocomplete';
                options.ajax.data = $.proxy(self._processParam, self);
                options.ajax.processResults = $.proxy(self._processResult, self);

                if (this.options.remoteHtml) {
                    options.escapeMarkup = function (markup)
                    {
                        return markup;
                    };

                    options.templateResult = function (data)
                    {
                        return data.html || data.text;
                    };

                    options.templateSelection = function (data)
                    {
                        return data.text;
                    };
                }

                if (!options.ajax.delay) {
                    options.ajax.delay = 250;
                }
            }

            // optgroup displayed on selection
            if (!options.ajax) {
                options.templateSelection = function (data)
                {
                    var parent = $(data.element).parent();
                    if (parent.prop("tagName") === "OPTGROUP") {
                        return parent[0].label + " » " + data.text;
                    } else {
                        return data.text;
                    }
                };
            }

            // data
            if (options.data) {
                options.escapeMarkup = function (markup)
                {
                    return markup;
                };

                options.templateSelection = function (data)
                {
                    return data.selectedText || data.text;
                };

                options.templateResult = function (node)
                {
                    if (node.html) {
                        return $(node.html)
                    } else {
                        return $('<span style="padding-left:' + (10 * (node.level ? node.level : 0)) + 'px;">' +
                            node.text +
                            '</span>');
                    }
                }
            }

            // css class
            options.containerCssClass = function()
            {
                return $('<div>').attr('class', element.attr('class'))
                    .removeClass('hidden')
                    .removeClass('cawa-fields-combo')
                    .attr('class');
            };

            /*
             * @see http://stackoverflow.com/a/33884094/1590168
             * @see https://github.com/select2/select2/issues/1645
             * @see https://github.com/twbs/bootstrap/pull/12142
             */
            var bootstrapDialog = element.closest(".bootstrap-dialog");
            if (bootstrapDialog.length) {
                options.dropdownParent = bootstrapDialog;
            }

            if (element.prop("multiple") && typeof options.closeOnSelect === "undefined") {
                options.closeOnSelect = false;
            }

            // custom matcher for optgroup
            options.matcher = $.proxy(self._matcher, self);

            // init
            self._select2 = element.select2(options);


            // data
            if (options.data) {
                self._select2.val(self.options.value).trigger('change');
            }

            // ugly hack : https://github.com/select2/select2/issues/3278
            $(self._select2).parent().find(".select2-container").css('width', '');

            self._hasValue = element.val() !== "" || typeof self.options.value !== "undefined";
            self._select2.removeClass("invisible");

            // loading
            element.data('select2').results.__proto__.showLoading = function()
            {
                $(self._select2).parent().find(".select2").addClass('loading');
            };

            element.data('select2').results.__proto__.hideLoading = function()
            {
                $(self._select2).parent().find(".select2").removeClass('loading');
            };

            // value selected
            self._select2.on("change", function()
            {
                self._hasValue = true;

                // remove type text on selection
                if (self.options.searchBox === undefined || self.options.searchBox === true) {
                    $(self._select2).parent().find(".select2-search__field").val('');
                    self.element.select2("trigger", "query");
                }
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

        /**
         * @private
         */
        _destroy: function()
        {
            this.element.select2('destroy');
            this.element.removeClass('hidden');

            this._super();
        },

        _matcher: function (params, data)
        {
            var self = this;

            data.parentText = data.parentText || "";

            // Always return the object if there is nothing to compare
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do a recursive check for options with children
            if (data.children && data.children.length > 0) {
                // Clone the data object if there are children
                // This is required as we modify the object to remove any non-matches
                var match = $.extend(true, {}, data);

                // Check each child of the option
                for (var c = data.children.length - 1; c >= 0; c--) {
                    var child = data.children[c];
                    if (!child.parentText) {
                        child.parentText = '';
                    }

                    child.parentText += data.parentText + " " + (data.text || "");

                    var matches = self._matcher(params, child);

                    // If there wasn't a match, remove the object in the array
                    if (matches === null) {
                        match.children.splice(c, 1);
                    }
                }

                // If any children matched, return the new object
                if (match.children.length > 0) {
                    return match;
                }

                // If there were no matching children, check just the plain object
                return self._matcher(params, match);
            }

            // If the typed-in term matches the text of this term, or the text from any
            // parent term, then it's a match.
            var original = (data.parentText + ' ' + data.text).toUpperCase();
            var term = params.term.toUpperCase();

            original = latinize(original);
            term = latinize(term);

            // Check if all words in term is present
            var terms = term.split(' ');
            var count = 0;
            for (var i = terms.length - 1; i >= 0; i--) {
                if (original.indexOf(terms[i]) > -1) {
                    count++;
                }
            }

            if (count === terms.length) {
                return data;
            }

            // If it doesn't contain the term, don't return anything
            return null;
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
});
