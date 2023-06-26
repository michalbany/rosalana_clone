//dark mode
    // načte předchozí režim z localStorage
    const darkMode = localStorage.getItem('darkMode');

    if (darkMode === 'enabled') {
        $(':root').addClass('dark-mode');
    }


$(document).ready(function(){
    initPageInteraction();
    initLoginFormInteraction();
    initResetPasswordFormInteraction();
    initVerificationFormInteraction();

    
    
    const loadContent = (url, callback) => {
            $.get(url, (data) => {
              const content = $(data).find(".card").html();
              const title = $(data).filter("title").text();
              document.title = title;
              $(".card").html(content);
              initPageInteraction();
              if (callback){
                callback();
              }
            });
          };
    
      $(document).on("click", "#create", function (e) {
        e.preventDefault();
        const targetUrl = $(this).attr("href");
        loadContent(targetUrl, initRegisterFormInteraction);
      });
    
      $(document).on("click", "#login", function (e) {
        e.preventDefault();
        const targetUrl = $(this).attr("href");
        loadContent(targetUrl, initLoginFormInteraction);
      });

      $(document).on("click", "#forgot", function (e) {
        e.preventDefault();
        const targetUrl = $(this).attr("href");
        loadContent(targetUrl, initForgotPasswordFormInteraction);
      });

      
      function initPageInteraction() {
    //zaškrtnutí checkboxu textem
    $('#checkboxText').on('click', function() {
        $('#remember').click();
    });

    //fix vraceni labelu na misto
    $('.input input').on('input', function() {
        if ($(this).val().length > 0) {
            $(this).next('label').css({
                'transform': 'translateY(-120%) scale(.9)',
                'background-color': 'var(--white)',
                'color': 'var(--purple)'
            });
        } else {
            $(this).next('label').css({
                'transform': '',
                'background-color': '',
                'color': ''
            });
        }
    });
    
    
    // zobrazeni hesla
    $('.eye').click(function() {
        var input = $(this).siblings('input');
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
            $(this).children().removeClass('fa-eye');
            $(this).children().addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            $(this).children().removeClass('fa-eye-slash');
            $(this).children().addClass('fa-eye');
        }
    });

}


    function initLoginFormInteraction(){
        $("#loginForm").off("submit").on("submit", function (event) {
            event.preventDefault();
            let submitButton = $("button[type='submit']");

            $.ajax({
                method: "POST",
                url: "/login",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    // Před odesláním požadavku odstraňte staré chybové hlášky
                    $("#emailError span").remove();
                    $("#emailError").removeClass('animate__animated animate__bounceIn');
                    // Přidejte třídu button__loading a nastavte visibility na hidden pro obsah tlačítka
                    submitButton.addClass("button__loading");
                    $(".button-content").css("visibility", "hidden");
                    $(".arrow").hide();
                
                },
                complete: function () {
                    // Odstraňte třídu button__loading a obnovte visibility na visible pro obsah tlačítka
                    submitButton.removeClass("button__loading");
                    $(".button-content").css("visibility", "visible");
                    $(".arrow").show();
                   
                },
                success: function (response) {
                    // Přesměrujte na úspěšnou stránku, pokud je přihlášení úspěšné
                    window.location.href = response.redirect;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Zobrazte chybové hlášky, pokud dojde k chybě
                    if (jqXHR.status === 422) {
                        let errors = jqXHR.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            let errorMsg = $("<span>").html(value[0]);
                            $("#" + key + "Error").append(errorMsg).addClass('animate__animated animate__bounceIn');
                        });

                    } else if (jqXHR.status === 429) {
                        let errorMsg = $("<span>").html("Příliš mnoho pokusů o přihlášení");
                        $("#emailError").append(errorMsg).addClass('animate__animated animate__bounceIn');

                    } else {
                        console.error('Error:', textStatus, errorThrown);
                    }
                },
            });
        });
    }

    function initRegisterFormInteraction() {
        $("#registerForm").off("submit").on("submit", function (event) {
            event.preventDefault();
            let submitButton = $("button[type='submit']");
    
            $.ajax({
                method: "POST",
                url: "/register",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $(".invalid-feedback").empty();
                    $(".invalid-feedback").removeClass('animate__animated animate__bounceIn');
                    submitButton.addClass("button__loading");
                    $(".button-content").css("visibility", "hidden");
                    $(".arrow").hide();
                },
                complete: function () {
                    submitButton.removeClass("button__loading");
                    $(".button-content").css("visibility", "visible");
                    $(".arrow").show();
                },
                success: function (response) {
                    // Vypis úspěšnou zprávu do #registerSuccess div
                    $("#registerSuccess").html(response.status).addClass('animate__animated animate__bounceIn');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        let errors = jqXHR.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            let errorMsg = $("<span>").html(value[0]);
                            $("#" + key + "Error").empty().append(errorMsg).addClass('animate__animated animate__bounceIn');
                        });
    
                    } else {
                        console.error('Error:', textStatus, errorThrown);
                    }
                },
            });
        });
    }
    
    
    function initForgotPasswordFormInteraction() {
        $("#forgotPasswordForm").off("submit").on("submit", function (event) {
            event.preventDefault();
            let submitButton = $("button[type='submit']");
    
            $.ajax({
                method: "POST",
                url: "/password/email",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#emailError").empty().removeClass('animate__animated animate__bounceIn');
                    $("#emailSuccess").empty().removeClass('animate__animated animate__bounceIn');
                    submitButton.addClass("button__loading");
                    $(".button-content").css("visibility", "hidden");
                    $(".arrow").hide();
                },
                complete: function () {
                    submitButton.removeClass("button__loading");
                    $(".button-content").css("visibility", "visible");
                    $(".arrow").show();
                },
                success: function (response) {
                    $("#emailSuccess").html(response.status).addClass('animate__animated animate__bounceIn');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        let response = jqXHR.responseJSON;
                        $("#emailError").html(response.emailError).addClass('animate__animated animate__bounceIn');
                    } else {
                        console.error('Error:', textStatus, errorThrown);
                    }
                },
                
            });
        });
    }



    function initResetPasswordFormInteraction() {
        $("#resetPasswordForm").off("submit").on("submit", function (event) {
            event.preventDefault();
            let submitButton = $("button[type='submit']");
    
            $.ajax({
                method: "POST",
                url: "/password/reset",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $(".invalid-feedback").empty();
                    $(".invalid-feedback").removeClass('animate__animated animate__bounceIn');
                    submitButton.addClass("button__loading");
                    $(".button-content").css("visibility", "hidden");
                    $(".arrow").hide();
                },
                complete: function () {
                    submitButton.removeClass("button__loading");
                    $(".button-content").css("visibility", "visible");
                    $(".arrow").show();
                },
                success: function (response) {
                    window.location.href = response.redirect;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        let errors = jqXHR.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            let errorMsg = $("<span>").html(value[0]);
                            $("#" + key + "Error").empty().append(errorMsg).addClass('animate__animated animate__bounceIn');
                        });
                    } else {
                        console.error('Error:', textStatus, errorThrown);
                    }
                },
            });
        });
    }
    
    function initVerificationFormInteraction(){
        $('#verifyLink').off('submit').on('submit', function(event){
            event.preventDefault();
            let submitButton = $("button[type='submit']");
            let form = $(this);
            let verificationUrl = form.attr('action');

            $.ajax({
                method: "POST",
                url: verificationUrl,
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#resendSuccess").empty().removeClass('animate__animated animate__bounceIn');
                    $("#resendError").empty().removeClass('animate__animated animate__bounceIn');
                    submitButton.addClass("button__loading");
                    $(".button-content").css("visibility", "hidden");
                    $(".arrow").hide();
                },
                complete: function () {
                    submitButton.removeClass("button__loading");
                    $(".button-content").css("visibility", "visible");
                    $(".arrow").show();
                },
                success: function (response) {
                    $("#resendSuccess").html(response.status).addClass('animate__animated animate__bounceIn');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) {
                        let response = jqXHR.responseJSON;
                        $("#resendError").html(response.status).addClass('animate__animated animate__bounceIn');
                    } else {
                        console.error('Error:', textStatus, errorThrown);
                    }
                },
            });
        });
    }

    });