define([
    'jquery'
], function ($) {
    "use strict";

    return function () {
        var custom_text;
        $.validator.addMethod(
            'validate-custom-mob-email-rule',
            function (value) {
                var mob_regex = /^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$/;
                var email_regex = /^([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*@([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*\.(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]){2,})$/;
                if (!$.mage.isEmptyNoTrim(value))
                {
                    if(email_regex.test(value) && !mob_regex.test(value)){
                        return true;
                    } else if(mob_regex.test(value) && !email_regex.test(value)){
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            },
            $.mage.__('Your validation error message')
        );
    }
});