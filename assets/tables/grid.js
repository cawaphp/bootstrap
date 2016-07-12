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
            var link = element.closest('tr')
                .find("a[data-main-action='true']");

            if (link.attr("href")) {
                link.trigger("click");
            }
        }
    });
});

