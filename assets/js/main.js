/* ===================================================================
    Author          : ModinaTheme
    Version         : 1.0
* ================================================================= */

(function($) {
    "use strict";

    $(document).ready( function() {

      //>> Mobile Menu Js Start <<//
      $('#mobile-menu').meanmenu({
          meanMenuContainer: '.mobile-menu',
          meanScreenWidth: "991",
          meanExpand: ['<i class="far fa-plus"></i>'],
      });

      //>> Sidebar Toggle Js Start <<//
      $(".offcanvas__close,.offcanvas__overlay").on("click", function() {
          $(".offcanvas__info").removeClass("info-open");
          $(".offcanvas__overlay").removeClass("overlay-open");
      });
      $(".sidebar__toggle").on("click", function() {
          $(".offcanvas__info").addClass("info-open");
          $(".offcanvas__overlay").addClass("overlay-open");
      });

      //>> Body Overlay Js Start <<//
      $(".body-overlay").on("click", function() {
          $(".offcanvas__area").removeClass("offcanvas-opened");
          $(".df-search-area").removeClass("opened");;
          $(".body-overlay").removeClass("opened");
      });

      //>> Sticky Header Js Start <<//

      $(window).scroll(function() {
          if ($(this).scrollTop() > 250) {
              $("#header-sticky").addClass("sticky");
          } else {
              $("#header-sticky").removeClass("sticky");
          }
      });


      //>> Text Animation Gsap Js Start <<//
      if ($('.title-anim').length > 0) {
        let splitTitleLines = gsap.utils.toArray(".title-anim");
        splitTitleLines.forEach(splitTextLine => {
          const tl = gsap.timeline({
          scrollTrigger: {
            trigger: splitTextLine,
            start: 'top 90%',
            end: 'bottom 60%',
            scrub: false,
            markers: false,
            toggleActions: 'play none none none'
          }
          });

          const itemSplitted = new SplitText(splitTextLine, { type: "words, lines" });
          gsap.set(splitTextLine, { perspective: 300});
          itemSplitted.split({ type: "lines" })
          tl.from(itemSplitted.lines, { duration: 1, delay: 0.3, opacity: 0, rotationX: -50, force3D: true, transformOrigin: "top center -50", stagger: 0.2 });
        });	
      }

       //>> Hero-1 Slider Start <<//
       const sliderActive2 = ".hero-slider";
       const sliderInit2 = new Swiper(sliderActive2, {
           loop: true,
           slidesPerView: 1,
           effect: "fade",
           speed: 3000,
           autoplay: {
               delay: 7000,
               disableOnInteraction: false,
           },
           pagination: {
            el: ".dot",
            clickable: true,
        },
       });
       function animated_swiper(selector, init) {
           const animated = function animated() {
               $(selector + " [data-animation]").each(function () {
                   let anim = $(this).data("animation");
                   let delay = $(this).data("delay");
                   let duration = $(this).data("duration");
                   $(this)
                       .removeClass("anim" + anim)
                       .addClass(anim + " animated")
                       .css({
                           webkitAnimationDelay: delay,
                           animationDelay: delay,
                           webkitAnimationDuration: duration,
                           animationDuration: duration,
                       })
                       .one("animationend", function () {
                           $(this).removeClass(anim + " animated");
                       });
               });
           };
           animated();
           init.on("slideChange", function () {
               $(sliderActive2 + " [data-animation]").removeClass("animated");
           });
           init.on("slideChange", animated);
       }
       animated_swiper(sliderActive2, sliderInit2);
       //>> Banner Animation <<//

      // Init slick slider + animation

      $('.hero-3 .hero-slider-active-2').slick({
        autoplay: true,
        speed: 1500,
        lazyLoad: 'progressive',
        arrows: true,
        fade: true,
        dots: false,
        prevArrow: $('.hero-nav-prev'),
        nextArrow: $('.hero-nav-next'),
      }).slickAnimation();
        
      //>> Hero-4 Slider Start <<//
      const sliderActive1 = ".hero-slider-4";
      const sliderInit1 = new Swiper(sliderActive1, {
          loop: true,
          slidesPerView: 1,
          effect: "fade",
          speed: 2000,
          autoplay: {
          delay: 4000,
          disableOnInteraction: false,
          },
          pagination: {
              el: ".dot",
              clickable: true,
          },
          navigation: {
            nextEl: ".array-prev",
            prevEl: ".array-next",
        },
      });
      // content animation when active start here
      function animated_swiper(selector, init) {
           let animated = function animated() {
               $(selector + " [data-animation]").each(function () {
                   let anim = $(this).data("animation");
                   let delay = $(this).data("delay");
                   let duration = $(this).data("duration");
                   $(this)
                       .removeClass("anim" + anim)
                       .addClass(anim + " animated")
                       .css({
                           webkitAnimationDelay: delay,
                           animationDelay: delay,
                           webkitAnimationDuration: duration,
                           animationDuration: duration,
                       })
                       .one("animationend", function () {
                           $(this).removeClass(anim + " animated");
                       });
               });
           };
           animated();
           init.on("slideChange", function () {
               $(sliderActive1 + " [data-animation]").removeClass("animated");
           });
           init.on("slideChange", animated);
      }
      animated_swiper(sliderActive1, sliderInit1);

      //>> Video Popup Start <<//
      $(".img-popup").magnificPopup({
          type: "image",
          gallery: {
              enabled: true,
          },
      });

      $('.video-popup').magnificPopup({
          type: 'iframe',
          callbacks: {
          }
      });
      
      //>> Counterup Start <<//
      $(".count").counterUp({
          delay: 15,
          time: 4000,
      });

      //>> Wow Animation Start <<//
      new WOW().init();

      //>> Nice Select Start <<//
      $('select').niceSelect();

      //>> Service Carousel Start <<//
      

      //>> Brand Carousel Start <<//
      if($('.brand-carousel-active').length > 0) {
          $('.brand-carousel-active').slick({
              autoplay: true,
              autoplaySpeed: 2000,
              //centerMode: true,
              speed: 500,
              arrows: false,
              slidesToShow: 6,
              slidesToScroll: 1, 
              dots: false,
              dotsClass: 'slide-dots',
              responsive: [
                  {
                    breakpoint: 1199,
                    settings: {
                      slidesToShow: 5,
                    }
                  },
                  {
                      breakpoint: 991,
                      settings: {
                        slidesToShow: 4,
                      }
                    },
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 3,
                      center: true,
                    }
                  },
                  {
                    breakpoint: 575,
                    settings: {
                      slidesToShow: 2,
                    }
                  }
              ],

          });
      }

      if($('.brand-carousel-active-2').length > 0) {
          $('.brand-carousel-active-2').slick({
              autoplay: true,
              autoplaySpeed: 2000,
              //centerMode: true,
              speed: 500,
              arrows: false,
              slidesToShow: 5,
              slidesToScroll: 1, 
              dots: false,
              dotsClass: 'slide-dots',
              responsive: [
                  {
                    breakpoint: 1199,
                    settings: {
                      slidesToShow: 5,
                    }
                  },
                  {
                      breakpoint: 991,
                      settings: {
                        slidesToShow: 4,
                      }
                    },
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 3,
                      center: true,
                    }
                  },
                  {
                    breakpoint: 575,
                    settings: {
                      slidesToShow: 2,
                    }
                  }
              ],

          });
      }
        
      //>> Testimonial Carousel Start <<//
      if($('.testimonial-carousel-active').length > 0) {
          $('.testimonial-carousel-active').slick({
              autoplay: true,
              autoplaySpeed: 2000,
              speed: 500,
              arrows: false,
              slidesToShow: 3,
              slidesToScroll: 1, 
              dots: true,
              dotsClass: 'slide-dots',
              responsive: [
                  {
                    breakpoint: 1399,
                    settings: {
                      slidesToShow: 3,
                    }
                  },
                  {
                    breakpoint: 1191,
                    settings: {
                      slidesToShow: 2,
                    }
                  },
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 1,
                      center: true,
                    }
                  },
                  {
                    breakpoint: 480,
                    settings: {
                      slidesToShow: 1
                    }
                  }
              ],

          });
      }

      if($('.testimonial-carousel-active-2').length > 0) {
        $('.testimonial-carousel-active-2').slick({
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 500,
            arrows: false,
            slidesToShow: 3,
            slidesToScroll: 1, 
            dots: true,
            dotsClass: 'slide-dots',
            responsive: [
                {
                  breakpoint: 1399,
                  settings: {
                    slidesToShow: 3,
                  }
                },
                {
                  breakpoint: 1191,
                  settings: {
                    slidesToShow: 2,
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 1,
                    center: true,
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1
                  }
                }
            ],

        });
      }

      if($('.testimonial-carousel-active-3').length > 0) {
        $('.testimonial-carousel-active-3').slick({
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1, 
            arrows: true,
            dots: false,
            prevArrow: $('.testimonial-nav-prev'),
            nextArrow: $('.testimonial-nav-next'),
        });
      }

      if($('.testimonial-carousel-active-5').length > 0) {
        $('.testimonial-carousel-active-5').slick({
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 500,
            arrows: false,
            slidesToShow: 2,
            slidesToScroll: 1, 
            dots: true,
            dotsClass: 'slide-dots',
            responsive: [
              {
                breakpoint: 1191,
                settings: {
                  slidesToShow: 2,
                }
              },
              {
                breakpoint: 991,
                settings: {
                  slidesToShow: 1,
                  center: true,
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1
                }
              }
          ],
        });
      }

      if($('.testimonial-carousel-active-4').length > 0) {
        $('.testimonial-carousel-active-4').slick({
            autoplay: true,
            autoplaySpeed: 1500,
            speed: 800,
            slidesToShow: 1,
            slidesToScroll: 1, 
            arrows: true,
            dots: false,
            prevArrow: $('.testimonial-nav-prev'),
            nextArrow: $('.testimonial-nav-next'),
        });
      }

      //>> Flag Slider Start <<//
      if($('.flag-slider').length > 0) {
        const flagSlider = new Swiper(".flag-slider", {
            spaceBetween: 30,
            speed: 2000,
            loop: true,
            centeredSlides: true,
            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
            },
            breakpoints: {
                1199: {
                    slidesPerView: 4,
                },
                991: {
                    slidesPerView: 3,
                },
                767: {
                    slidesPerView: 2,
                },
                575: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
    }

      //>> Search Popup Start <<//
      const $searchWrap = $(".search-wrap");
      const $navSearch = $(".nav-search");
      const $searchClose = $("#search-close");

      $(".search-trigger").on("click", function (e) {
          e.preventDefault();
          $searchWrap.animate({ opacity: "toggle" }, 500);
          $navSearch.add($searchClose).addClass("open");
      });

      $(".search-close").on("click", function (e) {
          e.preventDefault();
          $searchWrap.animate({ opacity: "toggle" }, 500);
          $navSearch.add($searchClose).removeClass("open");
      });

      function closeSearch() {
          $searchWrap.fadeOut(200);
          $navSearch.add($searchClose).removeClass("open");
      }

      $(document.body).on("click", function (e) {
          closeSearch();
      });

      $(".search-trigger, .main-search-input").on("click", function (e) {
          e.stopPropagation();
      });

      //>> Scroll Js Start <<//
      const scrollPath = document.querySelector(".scroll-up path");
      const pathLength = scrollPath.getTotalLength();
      scrollPath.style.transition = scrollPath.style.WebkitTransition = "none";
      scrollPath.style.strokeDasharray = pathLength + " " + pathLength;
      scrollPath.style.strokeDashoffset = pathLength;
      scrollPath.getBoundingClientRect();
      scrollPath.style.transition = scrollPath.style.WebkitTransition = "stroke-dashoffset 10ms linear";

      const updatescroll = function() {
          let scrolltotal = $(window).scrollTop();
          let height = $(document).height() - $(window).height();
          let scrolltotalheight = pathLength - (scrolltotal * pathLength) / height;
          scrollPath.style.strokeDashoffset = scrolltotalheight;
      };
      updatescroll();

      $(window).scroll(updatescroll);
      const offset = 50;
      const duration = 950;

      $(window).on("scroll", function() {
          if (jQuery(this).scrollTop() > offset) {
              jQuery(".scroll-up").addClass("active-scroll");
          } else {
              jQuery(".scroll-up").removeClass("active-scroll");
          }
      });

      $(".scroll-up").on("click", function(event) {
          event.preventDefault();
          jQuery("html, body").animate({
                  scrollTop: 0,
              },
              duration
          );
          return false;
      });

      //>> Mouse Cursor Start <<//
      function mousecursor() {
          if ($("body")) {
              const e = document.querySelector(".cursor-inner"),
                  t = document.querySelector(".cursor-outer");
              let n,
                  i = 0,
                  o = !1;
              (window.onmousemove = function(s) {
                  o ||
                      (t.style.transform =
                          "translate(" + s.clientX + "px, " + s.clientY + "px)"),
                      (e.style.transform =
                          "translate(" + s.clientX + "px, " + s.clientY + "px)"),
                      (n = s.clientY),
                      (i = s.clientX);
              }),
              $("body").on("mouseenter", "a, .cursor-pointer", function() {
                      e.classList.add("cursor-hover"), t.classList.add("cursor-hover");
                  }),
                  $("body").on("mouseleave", "a, .cursor-pointer", function() {
                      ($(this).is("a") && $(this).closest(".cursor-pointer").length) ||
                      (e.classList.remove("cursor-hover"),
                          t.classList.remove("cursor-hover"));
                  }),
                  (e.style.visibility = "visible"),
                  (t.style.visibility = "visible");
          }
      }
      $(function() {
          mousecursor();
      });
    

      // circle-progress
      $(".circle-bar").loading();


    }); // End Document Ready Function

    $.fn.loading = function() {
        const DEFAULTS = {
            backgroundColor: '#b3cef6',
            progressColor: '#4b86db',
            percent: 75,
            duration: 2000
        };

        $(this).each(function() {
            const $target = $(this);

            const opts = {
                backgroundColor: $target.data('color') ? $target.data('color').split(',')[0] : DEFAULTS.backgroundColor,
                progressColor: $target.data('color') ? $target.data('color').split(',')[1] : DEFAULTS.progressColor,
                percent: $target.data('percent') ? $target.data('percent') : DEFAULTS.percent,
                duration: $target.data('duration') ? $target.data('duration') : DEFAULTS.duration
            };
            // console.log(opts);

            $target.append('<div class="background"></div><div class="rotate"></div><div class="left"></div><div class="right"></div><div class=""><span>' + opts.percent + '%</span></div>');

            $target.find('.background').css('background-color', opts.backgroundColor);
            $target.find('.left').css('background-color', opts.backgroundColor);
            $target.find('.rotate').css('background-color', opts.progressColor);
            $target.find('.right').css('background-color', opts.progressColor);

            const $rotate = $target.find('.rotate');
            setTimeout(function() {
                $rotate.css({
                    'transition': 'transform ' + opts.duration + 'ms linear',
                    'transform': 'rotate(' + opts.percent * 3.6 + 'deg)'
                });
            }, 1);

            if (opts.percent > 50) {
                let animationRight = 'toggle ' + (opts.duration / opts.percent * 50) + 'ms step-end';
                let animationLeft = 'toggle ' + (opts.duration / opts.percent * 50) + 'ms step-start';
                $target.find('.right').css({
                    animation: animationRight,
                    opacity: 1
                });
                $target.find('.left').css({
                    animation: animationLeft,
                    opacity: 0
                });
            }
        });
    }

    function loader() {
      $(window).on('load', function() {
          // Animate loader off screen
          $(".preloader").addClass('loaded');
          $(".preloader").delay(600).fadeOut();
      });
  }
  loader();
    

})(jQuery); // End jQuery

