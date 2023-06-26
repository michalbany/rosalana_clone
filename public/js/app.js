// načte předchozí režim z localStorage
const darkMode = localStorage.getItem('darkMode');

if (darkMode === 'enabled') {
    $(':root').addClass('dark-mode');
}

$(document).ready(function(){


    //Dark mode
     if(darkMode === 'enabled') {
        $('#dark-mode i').removeClass('fa-moon').addClass('fa-sun');
    }
 
     $('#dark-mode').click(function() {
         if ($(':root').hasClass('dark-mode')) {
             // odstraní dark-mode třídu
             $(':root').removeClass('dark-mode');
             // změní ikonu na měsíc
             $('#dark-mode i').removeClass('fa-sun').addClass('fa-moon');
             // uloží režim do localStorage
             localStorage.setItem('darkMode', null);
         } else {
             // přidá dark-mode třídu
             $(':root').addClass('dark-mode');
             // změní ikonu na slunce
             $('#dark-mode i').removeClass('fa-moon').addClass('fa-sun');
             // uloží režim do localStorage
             localStorage.setItem('darkMode', 'enabled');
         }
     });


     //notifikace
     function getNotifications() {
        const notificationUrl = $('meta[name="notifications-url"]').attr('content');
        let unread = false;

        $.ajax({
            url: notificationUrl,
            type: 'GET',
            success: function(response){
                $('.notification-list').empty();

                if (response.notifications.length > 0) {
                    response.notifications.forEach(notification => {
                        $('.notification-list').append(`
                            <div class="notification-item" data-url="${notification.location}" data-read=${notification.read} data-id="${notification.id}">
                            <div class="photo" style="background-image: url('/profile_images/${notification.notification_photo}');"><div class="animate__animated animate__rubberBand dot"></div></div>
                                <p>${notification.message}</p>
                                <span class="time">${notification.created_at}</span>
                            </div>
                        `);
                    if (notification.read === false){
                        unread = true;
                    }
                    
                });
                    if (unread === true) {
                        $('.notification .dot').show();
                    }

                } else {
                    console.log('žádné notifikace');
                    $('.notification-list').append(`
                        
                            <p style="font-size: .8rem;">Žádné nové notifikace</p>
                        
                    `);
                }
            },
            error: function() {
                console.log('chyba v ajaxu');
            },

            
        });
    }

    getNotifications();

    $('.notification').on('click', function() {

        $(this).toggleClass('active');
        $('.notification-dropdown').slideToggle('fast');

    });


    //presunutí na stránku po kliknutí na notifikaci

    $('.notification-list').on('click', '.notification-item', function() {
        let notificationLocation = $(this).data('url');
        let notificationId = $(this).data('id');

        $.ajax({
            url: `/notifications/mark-as-read/${notificationId}`, // URL ke kontrolové akci
            type: 'POST', // Metoda HTTP
            data: { _token: $('meta[name="csrf-token"]').attr('content') }, // CSRF token
            beforeSend: function() {
                window.location.href = notificationLocation; // Přesměrování na URL oznámení
            },
            error: function() {
                console.log('Nepodařilo se označit oznámení jako přečtené');
            }
        });
    });


    // otevreni modal okna write post
    $('.create-post').on('click', function() {
        $('body').addClass('modal-open');
        $('#postModal').fadeToggle();
    });

    // zavreni modal okna write post
    $('.close_post').on('click', function() {
        $('body').removeClass('modal-open');
        $('#postModal').fadeOut();
        $('#postModal button[type="submit"]').removeClass("button__loading");
        $('#postModal button[type="submit"]').find(".button-content").css("visibility", "visible");
        $('#postModal button[type="submit"]').find(".arrow").show();
    });

    $('#postModal button[type="submit"]').on('click', function() {
        $(this).addClass("button__loading");
        $(this).find(".button-content").css("visibility", "hidden");
        $(this).find(".arrow").hide();
    });


    //change share-type
    //CHANGE: nyní nastavujeme default pro veřejné
    $('#shareTypeInput').val('public');

    $('#share-type').click(function() {
        $('.share-dropdown').slideToggle('fast');
        $(this).find('.dart').toggleClass('rotate');
        $(this).toggleClass('active');
    });

    $('#public').click(function() {
        $('#share-type').html('<i class="fa-solid fa-earth-africa"></i>Veřejně<i class="dart fa-solid fa-chevron-down"></i>');
        $('#shareTypeInput').val('public');
        $('.share-dropdown').slideToggle('fast');
        $('#share-type').removeClass('active');
    });

    $('#private').click(function() {
        $('#share-type').html('<i class="fa-solid fa-lock"></i>Soukromě<i class="dart fa-solid fa-chevron-down"></i>');
        $('#shareTypeInput').val('private');
        $('.share-dropdown').slideToggle('fast');
        $('#share-type').removeClass('active');
    });

    $('#friends').click(function() {
        $('#share-type').html('<i class="fa-solid fa-user-friends"></i>Přátelé<i class="dart fa-solid fa-chevron-down"></i>');
        $('#shareTypeInput').val('friends');
        $('.share-dropdown').slideToggle('fast');
        $('#share-type').removeClass('active');
    });


    //nastaveni sbirky
    $('#collection-type').click(function() {
        $('.collection-dropdown').slideToggle('fast');
        $(this).find('.dart').toggleClass('rotate');
        $(this).toggleClass('active');
    });


    //nastaveni ceny prispevku
    $('#price-switch input').change(function() {
        if(this.checked) {
            $('#price').prop('disabled', false);
            $('#price').focus();
            $('.price-text').css('opacity', '1');
            $('.free-text').css('opacity', '0.5');
        } else {
            $('#price').prop('disabled', true);
            $('.price-text').css('opacity', '0.5');
            $('.free-text').css('opacity', '1');
        }
    });
    



    var quill = new Quill('#quill-editor', {
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                ['link'], //image 
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'color': [] }],
                ['clean']
            ]
        },

        placeholder: 'Napiš svůj kousek ráje...',
        theme: 'snow'  // This will activate the "snow" theme
    });

    // Odeslání formuláře
    $('.write').on('submit', function(e) {
        console.log('submit');
        var content = quill.root.innerHTML;
    
        // Validace, zda byl obsah editoru vyplněn
        if(content === "") {
        e.preventDefault();
        alert('Prosím, vyplňte pole obsahu.');
        return false;
        }else{
            // Pokud je vše v pořádku, nastavíme obsah editoru do skrytého textového pole
            $('<input>').attr({
                type: 'hidden',
                id: 'content',
                name: 'content',
                value: content
              }).appendTo('.write');
        }
    
    });
    

    //zavření modal okna rank a poslani dat do databaze
    $('.die_rank').on('click', function() {
        $('#rankModal').fadeOut();

        $.ajax({
            url: '/closeRankModal',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                console.log(response);
            },
            error:function(){
                console.log('chyba v ajaxu');
            }
            
        });
    });

    //zmena textu na tlacitku follow/unfollow
    $(".unfollow-btn").on("mouseenter", function () {
        $(this).text("Nesledovat");
      });
  
      $(".unfollow-btn").on("mouseleave", function () {
        $(this).text("Sleduji");
      });


    //po klinutí na LOGO se vrátíme na domovskou stránku
    $('.logo').on('click', function() {
        window.location.href = '/home';
      });


      // kod pro search
        const searchInput = $("#search-input");
        const searchResults = $("#search-results");
        const searchUrl = $('meta[name="search-url"]').attr('content');
        let timeout = null;  // Přidán řádek pro časovač

        searchInput.on("input", function() {
            clearTimeout(timeout);  // Zruší předchozí časovač, pokud existuje
            const query = $(this).val();

            if (query.length > 0) {
                $(".spinner").show();
                timeout = setTimeout(function() {  // Zpoždění hledání
                    $.ajax({
                        url: searchUrl,
                        type: "GET",
                        data: {
                            search: query
                        },
                        success: function(response) {
                            $(".spinner").hide();
                            searchResults.empty();
                            searchResults.show();

                            response.users.forEach(user => {
                                searchResults.append(`
                                                    <div class="result">
                                                        <a href="/user/${user.id}">
                                                            <div class="names animate__animated animate__fadeIn">${user.name}</div>
                                                            <div class="type-user animate__animated animate__bounceInLeft">uživatel</div>
                                                        </a>
                                                    </div>
                                                `);
                            });

                            response.posts.forEach(post => {
                                searchResults.append(`
                                                    <div class="result">
                                                        <a href="/posts/${post.id}">
                                                            <div class="names animate__animated animate__fadeIn">${post.title}</div>
                                                            <div class="type-post animate__animated animate__bounceInLeft">příspěvek</div>
                                                        </a>
                                                    </div>
                                                `);
                            });
                        }
                    });
                }, 500);  // 500 milisekundové zpoždění
            } else {
                searchResults.hide();
                $(".spinner").hide();
            }
        });

        $(document).click(function(event) {
            if (!$(event.target).closest('.search').length) {
                searchResults.hide();
            }
        });




});