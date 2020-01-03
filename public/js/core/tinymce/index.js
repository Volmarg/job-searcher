var tinyMce = {
    attributes: {
        data: {
            isTinyMce: "data-is-tinymce"
        }
    },
    init: function(){
        let selector = "[" + this.attributes.data.isTinyMce + "]";

        // need to remove or will not be reinitialized on ajax load
        tinymce.remove(selector);
        tinymce.init({
            selector: selector,
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
    },
};

$(document).ready( () => {
    tinyMce.init();
});