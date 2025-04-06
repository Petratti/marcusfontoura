// use a script tag or an external JS file
document.addEventListener("DOMContentLoaded", (event) => {
    // Registre o plugin ScrollTrigger no GSAP
    gsap.registerPlugin(ScrollTrigger);

    // Animação de entrada de elementos com classe .fade-up com opcao de replay
    gsap.utils.toArray('.card:not(.-card-default, .-card-highlight-small, .-card-highlight-medium, .-card-highlight-large), header:not(#hero header, #header, .block-social-newsletter header, #footer header, .card header), li:not(#footer li), p:not(header p, .card p, .copyright p, #header p, .block-social-newsletter p, #footer p), img:not(.carousel img, header img, .card img, .copyright img, #header img, #hero img, .block-social-newsletter img, #footer img, .perspectivas-bar img), .-destaque-abertura').forEach(element => {
        gsap.from(element, {
            y: 50,
            opacity: 0,
            duration: .8,
            ease: 'circ.out',
            scrollTrigger: {
                trigger: element,
                start: 'top 90%',
                //toggleActions: 'play none none none'
            }
        });
    });

    // Animação de entrada de elementos com classe card com opcao de replay e que não tiver classe .-card-timeline
    /* gsap.utils.toArray('.card:not(.-card-timeline-simple,.-card-timeline-complete)').forEach(element => {
        gsap.from(element, {
            y: 100,
            opacity: 0,
            duration: .8,
            ease: 'circ.out',
            scrollTrigger: {
                trigger: element,
                start: 'top 90%',
                toggleActions: 'play none none none'
            }
        });
    }); */

    // Animação de entrada de elementos com classe btn  que NÃO estiver dentro de card
    gsap.utils.toArray('.btn:not(.card .btn, #submenu .btn, #top, #header .btn, .block-social-newsletter .btn, .btn, #footer .btn), button:not(.card button, #submenu button, #top, #header button, .block-social-newsletter button, #footer button)').forEach(element => {
        gsap.from(element, {
            y: 50,
            opacity: 0,
            duration: .5,
            ease: 'circ.out',
            scrollTrigger: {
                trigger: element,
                start: 'top 90%',
                toggleActions: 'play none none none'
            }
        });
    });

    //efeito parallax no elemento #hero header ao scrollar a página
    /* gsap.set('.single #hero header, .single-resource #hero .-buttons, .single #hero footer, .single #hero .-mini',{y: 0})
    gsap.to('.single #hero header, .single-resource #hero .-buttons, .single #hero footer, .single #hero .-mini', {
        y: -200,
        ease: 'none',
        scrollTrigger: {
            trigger: '#hero',
            start: 'top 10%',
            scrub: true,
            onRefresh: self => self.progress && self.animation.progress(0) && self.refresh(),
            //onRefresh: self => self.progress && self.animation.progress(0) && alert(1),
            //once: 1
        }
    }); */


    const zoomBgs = gsap.utils.toArray('.-zoom-bg');
    zoomBgs.forEach(zoomBg => {
        gsap.to(zoomBg, {
            scale: 1.3,
            ease: 'none',
            scrollTrigger: {
                trigger: zoomBg,
                start: 'top 50%',
                end: 'bottom 0%',
                scrub: true,
                onRefresh: self => self.progress && self.animation.progress(0) && self.refresh(),
                //onRefresh: self => self.progress && self.animation.progress(0) && alert(1),
                //once: 1
                //onRefresh: ({progress, direction, isActive}) => console.log(progress, direction, isActive)

            }
        })
    });

    
    const leftRightBgs = gsap.utils.toArray('.-left-right-bg');
    leftRightBgs.forEach(leftRightBg => {
        gsap.to(leftRightBg, {
            x: "+=10%",
            ease: 'none',
            scrollTrigger: {
                trigger: leftRightBg,
                start: 'top 90%',
                end: 'bottom 0%',
                scrub: true,
                onRefresh: self => self.progress && self.animation.progress(0) && self.refresh(),
                //onRefresh: self => self.progress && self.animation.progress(0) && alert(1),
                //once: 1
                //onRefresh: ({progress, direction, isActive}) => console.log(progress, direction, isActive)

            }
        })
    });

    //dar zoom em elemento com classe .-zoom ao scrollar a página
    /* gsap.utils.toArray('.-zoom').forEach(element => {
        gsap.from(element, {
            scale: .7,
            ease: 'none',
            scrollTrigger: {
                trigger: element,
                start: 'top 60%',
                scrub: true,
                onRefresh: self => self.progress && self.animation.progress(0) && self.refresh(),
            }
        });
    }); */

    /* gsap.utils.toArray('#destaques, .-zoom-bg .-banner').forEach(element => {
        gsap.fromTo(element, {
            backgroundSize: "100%"
        }, {
            backgroundSize: "120%",
            ease: 'none',
            scrollTrigger: {
                trigger: element,
                start: 'top 60%',
                scrub: true
            }
        });
    }
    ); */


    document.querySelectorAll(".perspectivas-bar").forEach((bar) => {
    let img = bar.querySelector("img"); // Seleciona a imagem dentro da barra
    let span = bar.querySelector("span"); // Seleciona o span dentro da barra
    
    gsap.timeline({
        scrollTrigger: {
        trigger: bar,
        start: "top 85%",
        end: "bottom 65%",
        scrub: true,
        onRefresh: self => self.progress && self.animation.progress(0) && self.refresh(),
        //markers: true // Remova depois de testar
        }
    })
    .from(bar, { width: "0%", duration: 2, ease: 'circ.out' }) // Expande a barra
    //.to(bar, { backgroundColor: "#ff5733", duration: 0.5, "+=1" }) // Muda a cor
    .from([img, span], { opacity: 0, duration: 2, ease: 'circ.out' }, "+=.1") // Mostra a imagem após 1s
    });


});