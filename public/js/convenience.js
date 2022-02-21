(function($){

    var $dtpicker = $('.dtpicker');
    var lang = $('html').attr('lang');
    var setupDatetimePicker = null;

    var setupDatetimePicker = function(dtp) {
        if (dtp) {
            dtp.each(function(index) {
                $(this).datetimepicker({
                    locale: lang,
                    format: 'YYYY-MM-DD',
                    calendarWeeks: true
                });
            });
        }
    };

    $(document).ready(function() {
        setupDatetimePicker($dtpicker);
    });
})(jQuery);