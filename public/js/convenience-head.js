(function($){

    var initTinymce = null;

    initTinymce = function() {
        tinymce.init({
            selector: 'textarea',  // change this value according to your HTML
            menubar: false,
            toolbar: 'undo redo | styleselect | bold italic',
            height: '100',
            // keep the values of hidden textareas in sync as changes are made via TinyMCE editors:
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
    };

    initTinymce();

    window.initTinymce = initTinymce;

})(tinymce);

