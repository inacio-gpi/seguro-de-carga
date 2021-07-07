AOS.init({
    duration: 800,
    easing: "ease",
    once: true,
    offset: -100,
});

jQuery(function ($) {
    "use strict";
    loader();
    onePageNavigation();
    floatingLabel();
    counter();
    jarallaxPlugin();
    animateReveal();
    contactForm();
});

var loader = function () {
    setTimeout(function () {
        TweenMax.to(".site-loader-wrap", 1, {
            marginTop: 50,
            autoAlpha: 0,
            ease: Power4.easeInOut,
        });
    }, 10);
    $(".site-loader-wrap").delay(200).fadeOut("slow");
    $("#overlayer").delay(200).fadeOut("slow");
};

var contactForm = function () {
    if ($("#contactForm").length > 0) {
        $("#contactForm").validate({
            rules: {
                nome: "required",
                email: {
                    required: true,
                    email: true,
                },
                telefone: {
                    required: true,
                    minlength: 14,
                    maxlength: 16,
                },
                cnpj: {
                    required: true,
                    minlength: 18,
                    maxlength: 18,
                },
            },
            messages: {
                nome: "Por favor, escreva seu nome",
                email: "Por favor, adicione um email válido",
                telefone: "Por favor, adicione um telefone válido",
                cnpj: "Por favor, adicione um CNPJ válido",
            },
            errorElement: "span",
            errorLabelContainer: ".form-error",
            /* submit via ajax */
            submitHandler: function (form) {
                var $submit = $(".enviando"),
                    waitText = "Enviando...";

                $.ajax({
                    type: "POST",
                    url: "static/php/send-email.php",
                    data: $(form).serialize(),

                    beforeSend: function () {
                        $submit.css("display", "block").text(waitText);
                    },
                    success: function (msg) {
                        console.log(msg);
                        if (msg == "OK") {
                            $("#form-message-warning").hide();
                            setTimeout(function () {
                                $("#contactForm").fadeOut();
                            }, 1000);
                            setTimeout(function () {
                                $("#form-message-success").fadeIn();
                            }, 1400);
                        } else {
                            $("#form-message-warning").html(msg);
                            $("#form-message-warning").fadeIn();
                            $submit.css("display", "none");
                        }
                    },
                    error: function () {
                        console.log("Erro");
                        $("#form-message-warning").html(
                            "Algo deu errado. Por favor tente novamente."
                        );
                        $("#form-message-warning").fadeIn();
                        $submit.css("display", "none");
                    },
                });
            },
        });
    }
};

var floatingLabel = function () {
    $(".form-control").on("input", function () {
        var $field = $(this).closest(".form-group");
        if (this.value) {
            $field.addClass("field--not-empty");
        } else {
            $field.removeClass("field--not-empty");
        }
    });
};

var counter = function () {
    $(".section-counter").waypoint(
        function (direction) {
            if (
                direction === "down" &&
                !$(this.element).hasClass("ftco-animated")
            ) {
                var comma_separator_number_step =
                    $.animateNumber.numberStepFactories.separator(".");
                $(this.element)
                    .find(".number-counter")
                    .each(function () {
                        var $this = $(this),
                            num = $this.data("number");
                        // console.log(num);
                        $this.animateNumber(
                            {
                                number: num,
                                numberStep: comma_separator_number_step,
                            },
                            {
                                easing: "swing",
                                duration: 3000,
                            }
                        );
                    });
            }
        },
        { offset: "95%" }
    );
};

var jarallaxPlugin = function () {
    $(".jarallax").jarallax({
        speed: 0.2,
    });
};

// input mask
$("#cnpj").mask("99.999.999/9999-99");
$("#telefone").mask("(00) 0000-00000");
$("#telefone").blur(function (event) {
    // console.log('teste');
    // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
    if ($(this).val().length == 15) {
        $("#telefone").mask("(00) 00000-0000");
    } else {
        $("#telefone").mask("(00) 0000-00000");
    }
});

// initial effect on letters
var animateReveal = function () {
    // gsap reveal hero
    $(".gsap-reveal-hero").each(function () {
        var html = $(this).html();
        $(this).html(
            '<span class="reveal-wrap"><span class="cover"></span><span class="reveal-content">' +
                html +
                "</span></span>"
        );
    });
    var grevealhero = $(".gsap-reveal-hero");

    if (grevealhero.length) {
        var heroNum = 0;
        grevealhero.each(function () {
            var cover = $(this).find(".cover"),
                revealContent = $(this).find(".reveal-content");

            var tl2 = new TimelineMax();

            setTimeout(function () {
                tl2.to(cover, 1, {
                    marginLeft: "0",
                    ease: Expo.easeInOut,
                    onComplete() {
                        tl2.set(revealContent, { x: 0 });
                        tl2.to(cover, 1, {
                            marginLeft: "102%",
                            ease: Expo.easeInOut,
                        });
                    },
                });
            }, heroNum * 0);

            heroNum++;
        });
    }
};

// header
const onscroll = (el, listener) => {
    el.addEventListener("scroll", listener);
};
const select = (el, all = false) => {
    el = el.trim();
    if (all) {
        return [...document.querySelectorAll(el)];
    } else {
        return document.querySelector(el);
    }
};

let selectHeader = select("#header");
if (selectHeader) {
    const headerScrolled = () => {
        if (window.scrollY > 100) {
            selectHeader.classList.add("header-scrolled");
        } else {
            selectHeader.classList.remove("header-scrolled");
        }
    };
    window.addEventListener("load", headerScrolled);
    onscroll(document, headerScrolled);
}

// First Carousel
$(".popular-slider").owlCarousel({
    items: 1,
    autoplay: true,
    autoplayTimeout: 5000,
    smartSpeed: 400,
    animateIn: "fadeIn",
    animateOut: "fadeOut",
    autoplayHoverPause: true,
    loop: true,
    nav: true,
    merge: true,
    dots: false,
    navText: [
        '<span class="icon-caret-left"></span>',
        '<span class="icon-caret-right"></span>',
    ],
    responsive: {
        0: {
            items: 1,
        },
        300: {
            items: 1,
        },
        320: {
            items: 3,
        },
        768: {
            items: 5,
        },
        1170: {
            items: 6,
        },
    },
});

// Carousel 2
$(".popular-slider-2").owlCarousel({
    items: 1,
    autoplay: true,
    autoplayTimeout: 5000,
    smartSpeed: 400,
    animateIn: "fadeIn",
    animateOut: "fadeOut",
    autoplayHoverPause: true,
    loop: true,
    nav: true,
    merge: true,
    dots: false,
    navText: [
        '<span class="icon-caret-left"></span>',
        '<span class="icon-caret-right"></span>',
    ],
    responsive: {
        0: {
            items: 1,
        },
        300: {
            items: 1,
        },
        380: {
            items: 1,
        },
        1150: {
            items: 2,
        },
        1750: {
            items: 2,
        },
        1800: {
            items: 3,
        },
    },
});

// popula accordion
$(".accordion_tab").click(function () {
    $(this).parent().toggleClass("active");
    $(this).toggleClass("active");
});

// navigation
var onePageNavigation = function () {
    // var navToggler = $(".site-menu-toggle");
    $("a[href^='#']:not([href='#'])").click(function (e) {
        e.preventDefault();

        var $body = $("body");
        if ($body.hasClass("offcanvas")) {
            $body.removeClass("offcanvas");
            $("body").find(".js-burger-toggle-menu").removeClass("open");
        }

        var hash = this.hash;

        $("html, body").animate(
            {
                scrollTop: $(hash).offset().top - 30,
            },
            1000,
            "easeInOutExpo"
        );
    });
};
