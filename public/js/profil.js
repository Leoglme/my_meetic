$( window ).load(function(){

    /* Animation bas de la card */
    $('.card__footer').on('click',function(){
        let clicks = $(this).data('clicks');
        if (clicks) {
            $(".card__footer").removeClass("card__footer--active").css("transition", ".5s");
            $(".icon__disable, .profil__btn").css("opacity", "0").css("transition", ".2s");
            $('.fa-sort-up').css("transform", "none").css("transition", ".2s");
            $(".card__footer--name").css("align-items", "center");
            $(".rounded-circle").css("opacity", "1").css("transition", ".2s");
        } else {
            $(".card__footer").addClass("card__footer--active").css("transition", ".5s");
            $(".icon__disable, .profil__btn").css("opacity", "1").css("transition", ".5s");
            $('.fa-sort-up').css("transform", "rotate(180deg)").css("transition", ".2s");
            $(".card__footer--name").css("align-items", "first baseline");
            $(".rounded-circle").css("opacity", "0").css("transition", ".2s");
        }
        $(this).data("clicks", !clicks);

    })

    /* checkbox dans select */
    function OpenCloseSelect(cible , cible2){
        let open = false;
        cible.on('click',function(){
            if (!open) {
                cible2.css("display", "block")
                open = true;
            } else {
                cible2.css("display", "none")
                open = false;
            }
        })
    }

    OpenCloseSelect($(".select__gender") , $("#checkboxes__gender"));
    OpenCloseSelect($(".select__city"), $("#checkboxes__city"));
    OpenCloseSelect($(".select__hobbies"), $("#checkboxes__hobbies"));



});