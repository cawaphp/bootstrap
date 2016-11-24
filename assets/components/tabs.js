/**
 * @see http://www.eyecon.ro/bootstrap-tabdrop/
 */

var $ = require("jquery");

$.widget("cawa.tabs", $.cawa.widget, {
    options: {
        text: '&nbsp;<i class="icon-align-justify"></i>'
    },

    _dropdown : null,

    _create: function ()
    {
        this._dropdown = $(
            '<li role="presentation" class="dropdown hide pull-right tabdrop">' +
            '   <a class="dropdown-toggle" data-toggle="dropdown" href="#">' +
                    this.options.text +
                    '<span class="caret"></span>' +
            '   </a>' +
            '   <ul class="dropdown-menu">' +
            '   </ul>' +
            '</li>')
            .prependTo(this.element.find('ul.nav:first-child'));

        if (this.element.find('ul.nav:first-child').parent().is('.tabs-below')) {
            this._dropdown.addClass('dropup');
        }

        var WinReszier = this._winResizer();
        WinReszier.register($.proxy(this._layout, this));

        this._layout();
    },

    _layout: function ()
    {
        var collection = [];
        this._dropdown.removeClass('hide');
        this.element
            .find('ul.nav:first-child')
            .append(this._dropdown.find('li'))
            .find('>li')
            .not('.tabdrop')
            .each(function ()
            {
                if (this.offsetTop > 0) {
                    collection.push(this);
                }
            });

        if (collection.length > 0) {
            collection = $(collection);
            this._dropdown
                .find('ul')
                .empty()
                .append(collection);
            if (this._dropdown.find('.active').length == 1) {
                this._dropdown.addClass('active');
            } else {
                this._dropdown.removeClass('active');
            }
        } else {
            this._dropdown.addClass('hide');
        }
    },

    _winResizer: function ()
    {
        var registered = [];
        var inited = false;
        var timer;
        var resize = function (ev)
        {
            clearTimeout(timer);
            timer = setTimeout(notify, 100);
        };
        var notify = function ()
        {
            for (var i = 0, cnt = registered.length; i < cnt; i++) {
                if (typeof registered[i] == 'function') {
                    registered[i].apply();
                }
            }
        };
        return {
            register: function (fn)
            {
                registered.push(fn);
                if (inited === false) {
                    $(window).bind('resize', resize);
                    inited = true;
                }
            },
            unregister: function (fn)
            {
                for (var i = 0, cnt = registered.length; i < cnt; i++) {
                    if (registered[i] == fn) {
                        delete registered[i];
                        break;
                    }
                }
            }
        }
    }
});

