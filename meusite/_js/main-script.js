let menuMobile = document.getElementById("menu-mobile");
let menuDesktop = document.getElementById("menu-desktop");
let iconMenu = document.querySelector(".menu");
let menuCheck = document.querySelector("#menu-hamburguer");
let arrowUp = document.querySelector("#arrow-up");
let arrowDown = document.querySelector("header .arrow");


clickAction(iconMenu,menuMobile);

//MOSTRAR E OCULTAR COM SLIDE TOGGLE
function clickAction (a,b) {
    $(a).click(() => {  
        $(b).slideToggle(); 
    })
}
//DETECTAR LARGURA

$(window).resize(() => {
    if ($(window).width() > 650) {
        $(menuMobile).hide();
        menuCheck.checked = false;   
    }
    
})

let altura = window.innerHeight;

window.addEventListener("scroll", (e) => {
    if (window.scrollY > altura) {
        arrowUp.style.display = "block";
    } else if ( window.scrollY < altura-100 ){
        arrowUp.style.display = "none";
    }
})

function arrow (btn,goto) {
    btn.addEventListener("click", () => {
        $('html,body').animate({scrollTop:$(goto).offset().top}, 1000);
    })
}

arrow(arrowUp,'html');
arrow(arrowDown,'.skillsbox');


var posicaoAtual = $(window).scrollTop();
var documentSize = $(document).height();
var sizeWindow = $(window).height();

$(window).scroll(function () {
    posicaoAtual = $(window).scrollTop();
if ( posicaoAtual >= (documentSize - (sizeWindow+200) ) ) {
        $('.social').fadeOut(1000);
    } else {
        $('.social').fadeIn(1000);
    }
});

$(window).resize(function() {
    posicaoAtual = $(window).scrollTop();
    documentSize = $(document).height();
    sizeWindow = $(window).height();
});


//let formEl = document.getElementById("form-user");
//
//formEl.addEventListener("submit", event => {
//    event.preventDefault();
//})