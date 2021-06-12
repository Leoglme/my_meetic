$('#filter_search').submit();
$(window).load(function () {
    /* Ajax formulaire d'inscription */
    $('#register-form').on('submit', function (e) {
        e.preventDefault();
        let postdata = $("#register-form").serialize();
        $.ajax({
            type: "POST",
            url: "../private/check_register.php",
            data: postdata,
            dataType: "json",
            context: document.body,
            success: function (result) {
                if (result["errorStatus"]) {
                    console.log(result);
                    $("#firstname + .input__error-msg").html(result["firstnameError"]);
                    $("#lastname + .input__error-msg").html(result["lastnameError"]);
                    $("#email + .input__error-msg").html(result["emailError"]);
                    $("#password + .input__error-msg").html(result["passwordError"]);
                    $("#Birth + .input__error-msg").html(result["birthError"]);
                    $("#gender + .input__error-msg").html(result["genderError"]);
                    $("#Hobbies + .input__error-msg").html(result["hobbiesError"]);
                    $("#city + .input__error-msg").html(result["cityError"]);
                    $(".form-group").css("margin-bottom", "2px");
                } else {
                    window.location.href = '../Connexion';
                }
            }
        })
    })

    /* Ajax formulaire de connexion */
    $('#connect-form').on('submit', function (e) {
        e.preventDefault();
        let postdata = $("#connect-form").serialize();
        $.ajax({
            type: "GET",
            url: "../private/check_login.php",
            data: postdata,
            dataType: "json",
            context: document.body,
            success: function (result) {
                console.log(result);
                if (result["errorStatus"]) {
                    $("#email + .input__error-msg").html(result["emailError"]);
                    $("#password + .input__error-msg").html(result["passwordError"]);
                    if (result["sameLogin"]) {
                        $(".link_forms").css("display", "none");
                        $(".alert-danger.same").attr("style", "position: relative").css("opacity", "1").css("transition", "1.5s");
                    }else if (result["disableAccount"]) {
                        $(".link_forms").attr("style", "display: none !important");
                        $(".alert-danger.same").attr("style", "position: absolute");
                        $(".alert-danger.disable__account").css("opacity", "1").css("transition", "1.5s");
                    }
                } else {
                    window.location.href = '../Profil?id=' + result["userID"];
                }
            }
        })
    })

    /* Ajax formulaire update du profil */
    $('#update-form').on('submit', function (e) {
        e.preventDefault();
        let postdata = $("#update-form").serialize();
        $.ajax({
            type: "POST",
            url: "../private/check_update.php",
            data: postdata,
            dataType: "json",
            context: document.body,
            success: function (result) {
                if (result["errorStatus"]) {
                    $("#email + .input__error-msg").html(result["emailError"]);
                } else {
                    let city = $("#city");
                    let firstname = $("#firstname");
                    let lastname = $("#lastname");
                    let bio = $("#description");

                    if (notEmpty(city)){
                        $(".user__location").html("<i class=\"fas fa-map-marker-alt\"></i> " + city.val());
                        $("#city + .input__error-msg").html("");
                        upMargin();
                    }else{
                        $("#city + .input__error-msg").html("Ce champ est vide !");
                        downMargin();
                    }

                    if (notEmpty(firstname)){
                        $(".welcome__titre").html("Hello " + firstname.val());
                        $("#firstname + .input__error-msg").html("");
                        upMargin();
                    }else{
                        $("#firstname + .input__error-msg").html("Ce champ est vide !");
                        downMargin();
                    }

                    if (notEmpty(lastname)){
                        $(".user__name.apercu, .profil__overlay--name").html(firstname.val() + " " + lastname.val());
                        $("#lastname + .input__error-msg").html("");
                        upMargin();
                    }else{
                        $("#lastname + .input__error-msg").html("Ce champ est vide !");
                        downMargin();
                    }

                    if (notEmpty(bio)){
                        $(".user__description").html(bio.val());
                        $("#description + .input__error-msg").html("");
                    }else{
                        $("#description + .input__error-msg").html("Ce champ est vide !");
                    }
                    

                    $(".user__mail").html("<i class=\"fas fa-envelope\"></i> Mon email : " + $("#email").val());
                }

                function notEmpty(inp){
                    return inp.val() !== "";
                }

                function downMargin(){
                    $(".line__info--profil").attr('style', 'margin-top: 0 !important');
                }

                function upMargin(){
                    $(".line__info--profil").attr('style', 'margin-top: 1.5rem !important');
                }


            }
        })
    })




    /* Ajax filtre recherche */
    $('#filter_search').on('submit', function (e) {
        e.preventDefault();
        let postdata = $("#filter_search").serialize();
        $.ajax({
            type: "POST",
            url: "private/filter.php",
            data: postdata,
            dataType: "json",
            context: document.body,
            success: function (result) {
                Pagination(result);
            }
        })
    })


   /* Modification en temp réel des infos utilisateurs*/
    function filterResult(retour, index){
            $(".result__name").html(retour[index.toString()]["firstname"] + " " + retour[index.toString()]["lastname"])
            $(".age").html(getAge(retour[index.toString()]["date_naissance"]) + " ANS");
            $(".result__city").html(retour[index.toString()]["ville"]);
            $(".mail").html(retour[index.toString()]["email"]);
            $(".result__gender").html(retour[index.toString()]["genre"]);
            $(".profil__btn").attr('href', "Profil?id=" + retour[index.toString()]["id"]);
            if(retour[index.toString()]["genre"] === "homme"){
                $(".card__profil").removeClass("women").addClass("men");
            }else if(retour[index.toString()]["genre"] === "femme"){
                $(".card__profil").removeClass("men").addClass("women");
            }else {
                $(".card__profil").removeClass("women").removeClass("men");
            }
      }


    /* conversion date de naissance en age */
    function getAge(birth){
        birth = new Date(birth);
        let today = new Date();
        return Math.floor((today - birth) / (365.25 * 24 * 60 * 60 * 1000)).toString();
    }

    /* pagination page suivante/précédente */
    function Pagination(result){
        let i = 0;
        let count = result.length - 1;
        let random = Math.floor(Math.random() * count);
        filterResult(result , random);
        $('.right').on('click', function(){
            if(i < count){
                i++;
            }
            filterResult(result , i);
        })
        $('.left').on('click', function(){
            if(i > 0){
                i--;
            }
            filterResult(result , i);
        })
    }

    /* défaut au lancement de la page => get all users */
    if ($("#filter_search").length === 1){
        let postdata = $("#filter_search").serialize();
        $.ajax({
            url: "private/filter.php",
            data: postdata,
            dataType: "json",
            context: document.body,
            success: function (result) {
                /* curent genre photo */
                if (result[result.length - 1]["0"]["genre"] === "homme"){
                    $(".rounded__img , .rounded-circle").attr("src", "public/assets/images/men_logo.png")
                }else if(result[result.length - 1]["0"]["genre"] === "femme"){
                    $(".rounded__img , .rounded-circle").attr("src", "public/assets/images/women_logo.png")
                }else{
                    $(".rounded__img , .rounded-circle").attr("src", "public/assets/images/other_logo.png")
                }
                Pagination(result);
            }
        })
    }



});