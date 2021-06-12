$( window ).load(function(){

    //menu overlay profil
    $('.profil__overlay').on('click',function(){
        let clicks = $(this).data('clicks');
        if (clicks){
            $(".dropdown-menu").css('opacity', "0");
        }else{
            $(".dropdown-menu").css('opacity', "1");
        }
        $(this).data("clicks", !clicks);
    })

    //conformation suppression du compte
    $(".disable__account").on("click",function(){
        $(".modal").fadeIn(200);
    })

    $(".close__modal").on("click",function(){
        $(".modal").fadeOut(200);
    })


   /* modifie la photo en fonction du genre*/
    let genre = $(".user__gender");
    if (genre.length > 0){
        if (genre.html().indexOf("homme") > 0){
            $(".rounded__img , .rounded-circle").attr("src", "../public/assets/images/men_logo.png")
        }else if(genre.html().indexOf("femme") > 0){
            $(".rounded__img , .rounded-circle").attr("src", "../public/assets/images/women_logo.png")
        }else{
            $(".rounded__img , .rounded-circle").attr("src", "../public/assets/images/other_logo.png")
        }
    }




});