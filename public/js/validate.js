$(document).ready(function () {
    $('.frmLogin').validate({
        rules : {
            email : {
                required : true,
                email : true,
            },
            password : {
                required : true,
                minlength : 6,
            },
        },
    });
    $('.frmRegister').validate({
        rules : {
            email : {
                required : true,
                email : true,
            },
            password : {
                required : true,
                minlength : 6,
            },
            password_confirm : {
                equalTo : "#password",
                required : true,
            },
            name : {
                required : true,
            },
        },
    });
    $('.frmChangePassword').validate({
        rules : {
            password : {
                required : true,
                minlength : 6,
            },
            newPassword : {
                required : true,
                minlength : 6,
            },
            newPasswordConfirmation : {
                equalTo : "#new-password",
                required : true,
            },
        },
    });
    $('.frmUpdateUser').validate({
        rules : {
            avatar : {
                required : true,
                extension : "jpg|jpeg|png|gif|svg|bmp",
            },
            name : {
                maxlength : 100,
            },
        },
    });
});
