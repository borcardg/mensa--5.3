(function($){

    var $modals = $('#modal-menu-create-edit, #modal-notice-create-edit');
    var $modalMenu = $('#modal-menu-create-edit');
    var $modalNotice = $('#modal-notice-create-edit');
    var siteId = $('h1.page-header').data('site');

    var prepareCreateMenuForm = null;
    var prepareEditMenuForm = null;
    var prepareCreateNoticeForm = null;
    var prepareEditNoticeForm = null;
    var loadLabels = null;
    var loadSites = null;

    /**
     * Load the list of labels
     * @param {Object} $form The form to adapt
     * @param {number} labelId The label ID to preselect
     */
    loadLabels = function($form, labelId) {
        // Get the list of labels
        $.get('http://apps.uni/mensa/public/api/v1/labels').done(function( data ) {
            var $labelSelect = $form.find('select[name="label_id"]');
            $.each(data.labels, function(index, label) {
                $labelSelect.append('<option value="'+ label.id +'">' + label.name + ' (CHF ' + label.price + ')</option>');
            });

            if (labelId != null) {
                // preselect the good option
                $labelSelect.find('option[value="' + labelId + '"]').prop('selected', true);
            }
        });
    };

    /**
     * Load the list of sites
     * @param {Object} $form The form to adapt
     * @param {number} siteId The site ID to preselect
     */
    loadSites = function($form, siteId) {
        // Get the list of sites
        $.get('http://apps.uni/mensa/public/api/v1/sites').done(function( data ) {
            var $siteSelect = $form.find('select[name="site_id"]');
            $.each(data.sites, function(index, site) {
                $siteSelect.append('<option value="'+ site.id +'">' + site.name + '</option>');
            });
            
            if (siteId != null) {
                // preselect the good option
                $siteSelect.find('option[value="' + siteId + '"]').prop('selected', true);
            }
        });
    };

    /**
     * Prepare the create form for Menu
     * @param {Object} $form The form to adapt
     * @param {Object} $btn The button that was clicked on which data are attached
     */
    prepareCreateMenuForm = function($form, $btn) {

        var isNoon = $btn.data('noon');
        var day = $btn.data('day');

        // preffilled form with these data and show it to user

        // Is it a menu at noon ?
        if (isNoon === true) {
            $form.find('input:checkbox[name="period"]').prop('checked', true);
        }

        // Setup date based on the weekly-from date and where we clicked
        var dateText = getWeeklyFrom(day);
        $form.find('input[name="date_start"]').val(dateText);
        $form.find('input[name="date_end"]').val(dateText);

        // Get the list of sites and labels
        loadSites($form, siteId);
        loadLabels($form, null);

        // Update modal title
        $modalMenu.find('.modal-header .title-create').show();
        $modalMenu.find('.modal-header .title-edit').hide();
    };

    /**
     * Prepare the edit form for Menu
     * @param {number} id The menu ID to edit
     * @param {Object} $form The form to adapt
     */
    prepareEditMenuForm = function(id, $form) {

        // get menu data corresponding to id
        $.get('/menus/' + id + '/edit').done(function(data) {
            console.log(data);
            var menu = data.menu;
            // Get the list of sites and labels
            loadSites($form, menu.site_id);
            loadLabels($form, menu.label_id);

            // Fill form with corresponding data
            $form.find('input[name="date_start"]').val(menu.date_start);
            $form.find('input[name="date_end"]').val(menu.date_end);
            // $form.find('select[name="site_id"]').val(menu.site_id);
            $form.find('input:checkbox[name="period"]').prop('checked', menu.period);
            $form.find('input:checkbox[name="isMain"]').prop('checked', menu.isMain);
            // $form.find('select[name="label_id"]').val(menu.site_id);
            $form.find('#fr\\[title\\]').val(menu.title);
            $form.find('#fr\\[accompaniment\\]').append(menu.accompaniment);
            
            // Set the content in tinymce editor:
            tinymce.get('fr[accompaniment]').setContent(menu.accompaniment);

            // Update modal title
            $modalMenu.find('.modal-header .title-create').hide();
            $modalMenu.find('.modal-header .title-edit > small').text(menu.title);
            $modalMenu.find('.modal-header .title-edit').show();
        });

    };

    /**
     * Prepare the create form for Notice
     * @param {Object} $form The form to adapt
     * @param {Object} $btn The button that was clicked on which data are attached
     */
    prepareCreateNoticeForm = function($form, $btn) {

        var isImportant = $btn.data('important');
        var day = $btn.data('day');

        // preffilled form with these data and show it to user

        // Is it a menu at noon ?
        if (isImportant === true) {
            $form.find('input:checkbox[name="isImportant"]').prop('checked', true);
        }

        // Setup date based on the weekly-from date and where we clicked
        var dateText = getWeeklyFrom(day);
        $form.find('input[name="date_start"]').val(dateText);
        $form.find('input[name="date_end"]').val(dateText);

        // Get the list of sites
        loadSites($form, siteId);

        // Update modal title
        $modalNotice.find('.modal-header .title-create').show();
        $modalNotice.find('.modal-header .title-edit').hide();
    };

    /**
     * Prepare the edit form for Notice
     * @param {number} id The notice ID to edit
     * @param {Object} $form The form to adapt
     */
    prepareEditNoticeForm = function(id, $form) {

        // get menu data corresponding to id
        $.get('/notices/' + id + '/edit').done(function(data) {
            console.log(data);
            var notice = data.notice;
            // Get the list of sites and labels
            loadSites($form, notice.site_id);

            // Fill form with corresponding data
            $form.find('input[name="date_start"]').val(notice.date_start);
            $form.find('input[name="date_end"]').val(notice.date_end);
            $form.find('input:checkbox[name="isImportant"]').prop('checked', notice.isImportant);
            $form.find('#fr\\[title\\]').val(notice.title);
            $form.find('#fr\\[content\\]').append(notice.content);
            
            // Set the content in tinymce editor:
            tinymce.get('fr[content]').setContent(notice.content);

            // Update modal title
            $modalNotice.find('.modal-header .title-create').hide();
            $modalNotice.find('.modal-header .title-edit > small').text(notice.title);
            $modalNotice.find('.modal-header .title-edit').show();
        });
    };

    /**
     * Returns the date in the format YYYY-MM-DD
     * If x is null, it means that we are not on a weekly view, so we have to take the current date.
     * @param {number} x The number corresponding to the day of week (monday = 0)
     * @return {string}
     */
    var getWeeklyFrom = function(x) {
        var dateStart = null;
        var dateText = '';

        if (x === null) {
            dateStart = moment(); // get current date object
        } else {
            dateStart = $('#weekly-from').text();
            dateStart = moment(dateStart, "DD.MM.YYYY"); // create a moment object based on the string
            dateStart.add(x, 'days');
        }
        
        dateText = dateStart.format("YYYY-MM-DD");
        return dateText;
    };

    $(document).ready(function() {

        // ----------------- Menu/Notice ----------------- //
        // on modal show
        $modals.on('show.bs.modal', function(event) {

            var $btn = $(event.relatedTarget);
            var $form = $(this).find('form');

            switch($btn.data('action-type')) {
                case 'create':
                    // Hide delete and update button, but show create button
                    $(this).find('.modal-footer button.btn-delete').hide();
                    $(this).find('.modal-footer button.btn-update').hide();
                    $(this).find('.modal-footer button.btn-create').show();
                    if ($btn.data('item-type') == 'menu') {
                        prepareCreateMenuForm($form, $btn);
                    } else if ($btn.data('item-type') == 'notice') {
                        prepareCreateNoticeForm($form, $btn);
                    }
                    
                    break;

                case 'edit':
                    // Show delete and update button, but hide create button
                    $(this).find('.modal-footer button.btn-delete').show();
                    $(this).find('.modal-footer button.btn-update').show();
                    $(this).find('.modal-footer button.btn-create').hide();

                    if ($btn.data('item-type') == 'menu') {
                        prepareEditMenuForm($btn.data('id'), $form);
                    } else if ($btn.data('item-type') == 'notice') {
                        prepareEditNoticeForm($btn.data('id'), $form);
                    }
                    break;
                default:
                    break;
            }

            // on button save/update
            $(this).find('.modal-footer').on('click', 'button.btn-create, button.btn-update, button.btn-delete', function() {

                var methodType = 'POST';
                var methodUrl = '';
                if ($btn.data('item-type') == 'menu') {
                    methodUrl = '/menus';
                } else if ($btn.data('item-type') == 'notice') {
                    methodUrl = '/notices';
                }

                if ($(this).hasClass('btn-update')) {
                    methodType = 'PUT';
                    methodUrl = methodUrl + '/' + $btn.data('id');
                    console.log(methodUrl);
                }

                if ($(this).hasClass('btn-delete')) {
                    methodType = 'DELETE';
                    methodUrl = methodUrl + '/' + $btn.data('id');
                    console.log(methodUrl);
                }
                
                var payload = {
                    url: methodUrl,
                    data: $form.serializeArray(),
                    type: methodType
                    
                    // {
                    //     '_token': $('input[name=_token]').val(),
                    //     'date_start': $form.find('input[name="date_start"]').val(),
                    //     'date_end': $form.find('input[name="date_end"]').val(),
                    //     'period': $form.find('input:checkbox[name="period"]').val(),
                    //     'isMain': $form.find('input:checkbox[name="isMain"]').val(),
                    //     'label_id': $form.find('select[name="label_id"]').val(),
                    //     'site_id': $form.find('select[name="site_id"]').val(),
                    //     'fr': $form.find('*[name="fr"]').val(),
                    //     'de': $form.find('*[name="de"]').val()
                    // }
                };

                $.ajax(payload).done(function(data) {
                    if ($btn.data('item-type') == 'menu') {
                        $modalMenu.modal('hide');
                    } else if ($btn.data('item-type') == 'notice') {
                        $modalNotice.modal('hide');
                    }

                    // refresh weekly table
                    $.post({
                        url: '/sites/' + siteId + '/weekly',
                        data: {
                            "sites": siteId,
                            "selected_date": getWeeklyFrom(0),
                            "_token": $form.find('input[name="_token"]').val()
                        },
                    }).done(function(data) {
                        // get table body and remove it
                        $('#weekly-body').empty();
                        $(data).appendTo($('#weekly-body'));
                        // update date from/to in title
                        $('#weekly-from').html(data.from);
                        $('#weekly-to').html(data.to);
                        console.log('weekly table has been updated!');

                    }).fail(function(data) {
                        $('#weekly-body').empty();
                        var error_message = '\
                            <tr class="danger">\
                                <td colspan="7">An error occured</td>\
                            </tr>';
                        $(error_message).appendTo($('#weekly-body'));
                        console.error(data);
                    });
                });
            });
        });
    
        // on modal hide
        $modalMenu.on('hide.bs.modal', function() {
            $(this).find('form').trigger('reset');
        });

    });
})(jQuery, moment, tinymce);