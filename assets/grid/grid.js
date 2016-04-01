var $ = require("jquery");
var spf = require("spf");

$.widget("cawa.grid", $.cawa.widget, {

    _create: function() {
        var self = this;
        var element = $(this.element);

        $(element).find("tbody tr").on("dblclick", self._rowDoubleClick);

        element.find("nav form").on("submit", self._filterSubmit);
    },

    _filterSubmit: function(event)
    {
        var form = $(event.target);

        var uri = form.attr('action');
        if (!uri) {
            uri = document.location.href;
        }

        $.goto(uri + "?" + form.serialize());
        event.preventDefault();
    },

    _rowDoubleClick: function(event)
    {
        var element = $(event.target);
        var link = element.closest('tr')
            .find("a[data-main-action='true']");

        if (link.attr("href")) {
            $.goto(link.attr("href"))
        }
    }
});

