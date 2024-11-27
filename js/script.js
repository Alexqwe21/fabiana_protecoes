$(document).ready(function () {

    // CARROSSEL DE SERVIÇOS DA PÁGINA INICIAL
    $('.carrossel').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });


    // CARROSSEL FEEDBACK DOS CLIENTES
    $('.clientes').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 4000,
        responsive: [
            {
                breakpoint: 481,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }]
    });

    // MENU HAMBURGUER

    const hambuguer = document.querySelector(".hambuguer");

    const nav = document.querySelector("nav");

    const fechar = document.querySelector(".fechar")

    hambuguer.addEventListener("click", () => {
        nav.classList.toggle("active")
    });

    fechar.addEventListener("click", () => {
        nav.classList.remove("active")
    });


    // BOTÃO MUSICA FABI TEMA

    const audio = document.getElementById('meuAudio');
    const playButton = document.querySelector('#play-button');
    let isPlaying = true;

    $(playButton).on("click", function () {
        if (isPlaying) {
            audio.play();  
            $(playButton).css("background-image", "url('img/iconPause.png')");
        } else {
            audio.pause();
            $(playButton).css("background-image", "url('img/iconPlay.png')");
        } isPlaying = !isPlaying;
    });

    $(audio).on('ended', function(){
        $(playButton).css("background-image", "url('img/iconPlay.png')");
        isPlaying = false;
    });

});









