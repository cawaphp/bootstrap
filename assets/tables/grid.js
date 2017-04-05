require([
    "jquery",
    "cawaphp/cawa/assets/widget"
], function($)
{
    $.widget("cawa.grid", $.cawa.widget, {

        _create: function() {
            var self = this;
            var element = $(this.element);

            $(element).find("tbody tr").on("dblclick", self._rowDoubleClick);

            element.find("nav form").on("submit", self._filterSubmit);
        },

        _filterSubmit: function(event)
        {
            event.preventDefault();
            event.stopImmediatePropagation();

            var form = $(event.target);

            var uri = form.attr('action');
            if (!uri) {
                uri = document.location.href;
            }


            $.goto(uri + (uri.indexOf("?") > 0 ?  "&" : "?") + form.serialize());
        },

        _rowDoubleClick: function(event)
        {
            var element = $(event.target);
            var links = element.closest('tr')
                .find("a[data-action-index]")
                .sort(function(a, b)
                {
                    var aIndex = $(a).attr('data-action-index');
                    var bIndex = $(b).attr('data-action-index');

                    return aIndex === bIndex ? 0 : (aIndex > bIndex ? 1 : -1);
                })
            ;

            if (links.first().attr("href")) {
                links.first().trigger("click");
            }
        }
    });
});

