var $ = require("jquery");

$.widget("cawa.tabs", $.cawa.widget, {

    _create: function ()
    {
        var element = this.element.find('ul.nav-tabs:first');

        element.append($('<span class="glyphicon glyphicon-triangle-bottom"></span>'));
        element.append($('<span class="glyphicon glyphicon-triangle-top"></span>'));

        element.on('click', 'li.active > a, span.glyphicon', function ()
        {
            element.toggleClass('open');
        }.bind(this));

        element.on('click', 'li:not(.active) > a', function ()
        {
            element.removeClass('open');
        }.bind(this));
    }
});

