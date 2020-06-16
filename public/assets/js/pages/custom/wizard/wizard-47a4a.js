"use strict";
var KTWizard4 = function () {
    var e, t, i, r = [];
    return {
        init: function () {
            e = KTUtil.getById("kt_wizard_v4"), t = KTUtil.getById("kt_form"), (i = new KTWizard(e, {
                startStep: 1,
                clickableSteps: !0
            })).on("beforeNext", function (e) {
                i.stop(), r[e.getStep() - 1].validate().then(function (e) {
                    "Valid" == e ? (i.goNext(), KTUtil.scrollTop()) : Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {confirmButton: "btn font-weight-bold btn-light"}
                    }).then(function () {
                        KTUtil.scrollTop()
                    })
                })
            }), i.on("change", function (e) {
                KTUtil.scrollTop()
            }), r.push(FormValidation.formValidation(t, {
                fields: {
                    fname: {validators: {notEmpty: {message: "First name is required"}}},
                    lname: {validators: {notEmpty: {message: "Last Name is required"}}},
                    phone: {validators: {notEmpty: {message: "Phone is required"}}},
                    email: {
                        validators: {
                            notEmpty: {message: "Email is required"},
                            emailAddress: {message: "The value is not a valid email address"}
                        }
                    }
                },
                plugins: {trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap}
            })), r.push(FormValidation.formValidation(t, {
                fields: {
                    address1: {validators: {notEmpty: {message: "Address is required"}}},
                    postcode: {validators: {notEmpty: {message: "Postcode is required"}}},
                    city: {validators: {notEmpty: {message: "City is required"}}},
                    state: {validators: {notEmpty: {message: "State is required"}}},
                    country: {validators: {notEmpty: {message: "Country is required"}}}
                },
                plugins: {trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap}
            })), r.push(FormValidation.formValidation(t, {
                fields: {
                    ccname: {validators: {notEmpty: {message: "Credit card name is required"}}},
                    ccnumber: {
                        validators: {
                            notEmpty: {message: "Credit card number is required"},
                            creditCard: {message: "The credit card number is not valid"}
                        }
                    },
                    ccmonth: {validators: {notEmpty: {message: "Credit card month is required"}}},
                    ccyear: {validators: {notEmpty: {message: "Credit card year is required"}}},
                    cccvv: {
                        validators: {
                            notEmpty: {message: "Credit card CVV is required"},
                            digits: {message: "The CVV value is not valid. Only numbers is allowed"}
                        }
                    }
                },
                plugins: {trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap}
            }))
        }
    }
}();
jQuery(document).ready(function () {
    KTWizard4.init()
});