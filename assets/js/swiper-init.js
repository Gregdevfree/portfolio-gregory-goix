// Swiper Projects
document.addEventListener('DOMContentLoaded', function () {
  // Vérifier que Swiper est défini
  if (typeof Swiper !== 'undefined') {
    var swiper = new Swiper('.mySwiper', {
      effect: 'fade', // Ajoute l'effet de transition en fondu
      fadeEffect: {
        crossFade: true // Permet une transition fluide entre les slides
      },
      slidesPerView: 1, // Une seule slide à la fois à cause du fade
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      on: {
        slideChangeTransitionStart: function () {
          // Ajoute la classe glowing à la slide active
          document.querySelectorAll('.swiper-slide').forEach((slide) => {
            slide.classList.remove('glowing')
          })
          document
            .querySelector('.swiper-slide-active')
            ?.classList.add('glowing')
        }
      }
    })
  }
})

