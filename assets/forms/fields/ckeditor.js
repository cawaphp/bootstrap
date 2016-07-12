require([
    "jquery",
    "ckeditor",
    "modernizr",
    "cawaphp/cawa/assets/widget"
], function($, ckeditor, modernizr)
{
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
                    { name: 'links', items: [ 'Link', 'Unlink'] },
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

            if (element.attr('placeholder')) {
                options.placeholder = element.attr('placeholder');
            }

            if (self.options.disabledOnTouch === true && modernizr.touchevents) {
                removePlugins.push('toolbar');
            }

            options.removePlugins = removePlugins.join(',');
            options.extraPlugins = 'confighelper';

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
});


