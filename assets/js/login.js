$(document).ready(function(){
    $('form.signup-form').on('submit', function(e){
        e.preventDefault();
        // $.post('register/index', $('form.jsform').serialize(), function(data){
        //     console.log(data);
        // });
        var me = $(this);

        //perform ajax
        $.ajax({
            url: "login/createNewUser",
            type: 'post',
            data: me.serialize(),
            dataType: 'json',
            success: function(response){
               console.log(response);
               if(response.success == true){
                //redirect to the add profile page
                window.location.href = 'https://localhost/neplease_photo_competition/addProfilePic';
               } else {
                //display errors
                $.each(response.messages, function(key, value){
                    var element = $('#' + key); 
                    console.log(element);
                    element.html(value);
                });
               }  
            }
        });
    });

    $('form.forgot_pwd_email').on('submit', function(e){
        e.preventDefault();
        // $.post('register/index', $('form.jsform').serialize(), function(data){
        //     console.log(data);
        // });
        var me = $(this);

        //perform ajax
        $.ajax({
            url: "validate_new_password",
            type: 'post',
            data: me.serialize(),
            dataType: 'json',
            success: function(response){
               console.log(response);
                //display errors
                $.each(response.messages, function(key, value){
                    var element = $('#' + key);
                    element.html(value);
                });
            }
        });
    });

    $('form.change-pwd-form').on('submit', function(e){
        e.preventDefault();
        // $.post('register/index', $('form.jsform').serialize(), function(data){
        //     console.log(data);
        // });
        var me = $(this);

        //perform ajax
        $.ajax({
            url: "password_changed",
            type: 'post',
            data: me.serialize(),
            dataType: 'json',
            success: function(response){
               if(response.success != true){
                //display errors
                $.each(response.messages, function(key, value){
                    var element = $('#' + key);
                    element.html(value);
                });
               } else {
                console.log('D');
                  window.location.href = 'login?msg='+response.pass_ch;
               }
            }
        });
    });


    $('#confirm_password_text').on('keyup', function () {
      if ($('#password_text').val() != $('#confirm_password_text').val()) {
        $('#confirm_password').html('Please enter the matching password.').css('color', 'red', 'font-size', '12px;');
      }else{
        $('#confirm_password').html('Password matched.').css('color', 'green', 'font-size', '12px;');
      }
    });

    $('form.login-form').on('submit', function(e){
        e.preventDefault();
        // $.post('register/index', $('form.jsform').serialize(), function(data){
        //     console.log(data);
        // });
        var me = $(this);

        //perform ajax
        $.ajax({
            url: "login/authenticate",
            type: 'post',
            data: me.serialize(),
            dataType: 'json',
            success: function(response){
               if(response.success == true){
                    console.log(response);
                //redirect to the add profile page
                window.location.href = 'https://localhost/neplease_photo_competition/home';
               }else{
                //display errors 
                $('#userEmail').val('');
                $('#userPassword').val('');
                $('#email_sign_in').text(response.messages.email_sign_in);
               }  
            }
        });
    });
});