var $ = require("jquery");
var ckeditor = require("ckeditor");
var modernizr = require("modernizr");

$.widget("cawa.fields-ckeditor", $.cawa.widget, {

    options: {
        disabledOnTouch: true,
        removePlugins: [
            'elementspath'
        ],
        plugin : {
            customConfig: false,
            stylesSet: false,
            defaultLanguage: $.locale(),
            language: $.locale(),
            toolbar: [
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList'] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'tools', items: [ 'Undo', 'Redo'] }
            ]
        }
    },

    _create: function() {
        var self = this;
        var element = $(this.element);
        var options = self.options.plugin;
        var removePlugins = self.options.removePlugins;

        options.readOnly = !!element.attr('readonly') || !!element.attr('disabled');

        if (self.options.disabledOnTouch === true && modernizr.touchevents) {
            removePlugins.push('toolbar');
        }

        options.removePlugins = removePlugins.join(',');

        var instance;
        if (element[0].isContentEditable || element.attr('contenteditable') != undefined) {
            instance = ckeditor.inline(self.element.get(0), options);
        }
        else {
            instance = ckeditor.replace(element[0], options);
        }

        instance.on("blur", instance.updateElement);
        instance.on("change", instance.updateElement);
        instance.on("paste", instance.updateElement);
    }
});
