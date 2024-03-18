$(document).ready(function() {

    //Date picker
    $('.start-date-picker').datepicker({
        autoclose: true,
        endDate: 'today',
    });

    $('form#business_register_form').validate({
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.hasClass('input-icheck') && element.parent().hasClass('icheckbox_square-blue')) {
                error.insertAfter(element.parent().parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            name: 'required',
            email: {
                email: true,
                remote: {
                    url: '/business/register/check-email',
                    type: 'post',
                    data: {
                        email: function() {
                            return $('#email').val();
                        },
                    },
                },
            },
            password: {
                required: true,
                minlength: 5,
            },
            confirm_password: {
                equalTo: '#password',
            },
            username: {
                required: true,
                minlength: 4,
                remote: {
                    url: '/business/register/check-username',
                    type: 'post',
                    data: {
                        username: function() {
                            return $('#username').val();
                        },
                    },
                },
            },
            website: {
                url: true,
            },
        },
        messages: {
            name: LANG.specify_business_name,
            password: {
                minlength: LANG.password_min_length,
            },
            confirm_password: {
                equalTo: LANG.password_mismatch,
            },
            username: {
                remote: LANG.invalid_username,
            },
            email: {
                remote: LANG.email_taken,
            },
        },
    });

    $('#business_logo').fileinput({
        showUpload: false,
        showPreview: false,
        browseLabel: LANG.file_browse_label,
        removeLabel: LANG.remove,
    });
});
