document.addEventListener('DOMContentLoaded', function () {
  console.log('DOMContentLoaded a été déclenché')

  // Variables pour contrôler le carrousel
  let swiper
  let isMenuOpen = false
  let isModalOpen = false

  // Initialisation du swiper si disponible
  if (typeof Swiper !== 'undefined') {
    swiper = new Swiper('.mySwiper', {
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      slidesPerView: 1,
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
          document.querySelectorAll('.swiper-slide').forEach((slide) => {
            slide.classList.remove('glowing')
          })
          const activeSlide = document.querySelector('.swiper-slide-active')
          if (activeSlide) activeSlide.classList.add('glowing')
        }
      }
    })
  }

  // Fonction pour éliminer le délai de 300ms sur les appareils tactiles
  function removeTouchDelay() {
    const isTouchDevice =
      'ontouchstart' in window || navigator.maxTouchPoints > 0

    if (isTouchDevice) {
      const clickableElements = document.querySelectorAll(
        'a, button, .wp-block-button__link, #contactBtn, .open-pdf-btn, .btn-404, .linkedin-button, .wpcf7-submit'
      )

      clickableElements.forEach((element) => {
        // Empêcher le comportement par défaut du toucher qui peut causer un délai
        element.addEventListener(
          'touchstart',
          function (e) {
            // Uniquement si ce n'est pas un élément qui nécessite le défilement
            if (!element.classList.contains('scrollable')) {
              e.preventDefault()
            }
          },
          { passive: false }
        )

        // Déclencher le clic manuellement
        element.addEventListener(
          'touchend',
          function (e) {
            // Uniquement si ce n'est pas un élément qui nécessite le défilement
            if (!element.classList.contains('scrollable')) {
              e.preventDefault()
              // Simuler un clic après le toucher
              const clickEvent = new MouseEvent('click', {
                bubbles: true,
                cancelable: true,
                view: window
              })
              element.dispatchEvent(clickEvent)
            }
          },
          { passive: false }
        )
      })
    }
  }

  // Appliquer les optimisations tactiles
  removeTouchDelay()

  // Redirection du logo vers la page d'accueil
  let logo = document.querySelector('.custom-logo-link')
  if (logo) {
    logo.addEventListener('click', function (e) {
      e.preventDefault() // Annule l'action par défaut
      window.location.href = '/' // Redirige vers la page d'accueil
    })
  }

  // Fonction pour désactiver les interactions du carrousel
  function disableCarouselInteractions() {
    const swiperEl = document.querySelector('.mySwiper')
    if (swiperEl) {
      // Désactiver les flèches de navigation
      const nextBtn = swiperEl.querySelector('.swiper-button-next')
      const prevBtn = swiperEl.querySelector('.swiper-button-prev')
      const pagination = swiperEl.querySelector('.swiper-pagination')

      if (nextBtn) nextBtn.style.pointerEvents = 'none'
      if (prevBtn) prevBtn.style.pointerEvents = 'none'
      if (pagination) pagination.style.pointerEvents = 'none'

      // Désactiver le swipe
      if (swiper) {
        swiper.allowTouchMove = false
      }
    }
  }

  // Fonction pour réactiver les interactions du carrousel
  function enableCarouselInteractions() {
    const swiperEl = document.querySelector('.mySwiper')
    if (swiperEl) {
      // Réactiver les flèches de navigation
      const nextBtn = swiperEl.querySelector('.swiper-button-next')
      const prevBtn = swiperEl.querySelector('.swiper-button-prev')
      const pagination = swiperEl.querySelector('.swiper-pagination')

      if (nextBtn) nextBtn.style.pointerEvents = ''
      if (prevBtn) prevBtn.style.pointerEvents = ''
      if (pagination) pagination.style.pointerEvents = ''

      // Réactiver le swipe
      if (swiper) {
        swiper.allowTouchMove = true
      }
    }
  }

  // Interaction pour le hamburger-menu
  const hamburgerMenu = document.getElementById('hamburger-menu')
  const menuToggle = document.getElementById('menu-toggle')
  const body = document.querySelector('body')

  if (hamburgerMenu && menuToggle) {
    // Utiliser touchstart pour les appareils tactiles pour une réponse plus rapide
    hamburgerMenu.addEventListener(
      'touchstart',
      function (e) {
        e.preventDefault()
        toggleMenu()
      },
      { passive: false }
    )

    // Conserver click pour les souris
    hamburgerMenu.addEventListener('click', function () {
      toggleMenu()
    })

    function toggleMenu() {
      hamburgerMenu.classList.toggle('open')
      menuToggle.classList.toggle('open')
      body.classList.toggle('no-scroll') // Bloque le défilement lorsque le menu est ouvert

      // Mettre à jour l'état du menu
      isMenuOpen = menuToggle.classList.contains('open')

      // Pause ou reprise du carrousel en fonction de l'état du menu
      if (isMenuOpen) {
        if (swiper && swiper.autoplay) {
          swiper.autoplay.stop()
        }
        // Désactiver les interactions du carrousel
        disableCarouselInteractions()
        // Fixer le fond
        body.style.position = 'fixed'
        body.style.width = '100%'
        body.style.height = '100%'
      } else {
        if (!isModalOpen && swiper && swiper.autoplay) {
          swiper.autoplay.start()
        }
        // Réactiver les interactions du carrousel si la modale n'est pas ouverte
        if (!isModalOpen) {
          enableCarouselInteractions()
        }
        // Restaurer le fond si la modale n'est pas ouverte
        if (!isModalOpen) {
          body.style.position = ''
          body.style.width = ''
          body.style.height = ''
        }
      }
    }
  }

  // Script pour la modale de contact
  const modal = document.getElementById('contactModal')

  // Sélectionner les boutons CONTACT
  const btn1 = document.querySelector('#menu-item-24 > a') // Bouton menu navigation
  const btn2 = document.querySelector('#menu-toggle ul li:nth-child(3) a')
  const btn3 = document.getElementById('contactBtn')

  // Sélectionner le formulaire de Contact Form 7
  const contactForm = modal ? modal.querySelector('form') : null

  function openModal(event) {
    event.preventDefault()
    event.stopPropagation()

    // Fermer le menu toggle si nécessaire
    if (menuToggle && menuToggle.classList.contains('open')) {
      hamburgerMenu.classList.remove('open')
      menuToggle.classList.remove('open')
      isMenuOpen = false
    }

    // Ouvrir la modale si elle existe
    if (modal) {
      modal.classList.add('show')
      isModalOpen = true
    }

    // Mettre en pause le carrousel
    if (swiper && swiper.autoplay) {
      swiper.autoplay.stop()
    }

    // Désactiver les interactions du carrousel
    disableCarouselInteractions()

    // Fixer le fond
    body.classList.add('no-scroll')
    body.style.position = 'fixed'
    body.style.width = '100%'
    body.style.height = '100%'
  }

  // Ajouter l'événement d'ouverture de la modale aux boutons s'ils existent
  if (btn1) {
    btn1.addEventListener('touchstart', openModal, { passive: false })
    btn1.addEventListener('click', openModal)
  }
  if (btn2) {
    btn2.addEventListener('touchstart', openModal, { passive: false })
    btn2.addEventListener('click', openModal)
  }
  if (btn3) {
    btn3.addEventListener('touchstart', openModal, { passive: false })
    btn3.addEventListener('click', openModal)
  }

  // Fonction pour fermer la modale et réinitialiser le formulaire
  function closeModal() {
    if (modal) {
      modal.classList.remove('show')
      isModalOpen = false
    }

    // Réinitialiser le formulaire de Contact Form 7
    if (contactForm) {
      contactForm.reset()
    }

    // Optionnel: Vider les messages d'erreur de CF7
    if (modal) {
      const errorMessages = modal.querySelectorAll('.wpcf7-not-valid-tip')
      errorMessages.forEach(function (message) {
        message.remove() // Supprimer les messages d'erreur
      })
    }

    // Reprendre le carrousel si le menu n'est pas ouvert
    if (!isMenuOpen && swiper && swiper.autoplay) {
      swiper.autoplay.start()
    }

    // Réactiver les interactions du carrousel si le menu n'est pas ouvert
    if (!isMenuOpen) {
      enableCarouselInteractions()
    }

    // Restaurer le fond si le menu n'est pas ouvert
    if (!isMenuOpen) {
      body.classList.remove('no-scroll')
      body.style.position = ''
      body.style.width = ''
      body.style.height = ''
    }
  }

  // Fermer la modale si clic en dehors
  if (modal) {
    window.addEventListener('click', function (event) {
      if (event.target === modal) {
        closeModal()
      }
    })

    // Support tactile pour fermer la modale
    window.addEventListener('touchend', function (event) {
      if (event.target === modal) {
        closeModal()
      }
    })
  }

  // Écouter l'événement de soumission réussie de CF7
  document.addEventListener(
    'wpcf7mailsent',
    function (event) {
      if (modal) {
        setTimeout(function () {
          closeModal()
          window.location.href = '/'
        }, 3000)
      }
    },
    false
  )

  // Gestion du Scroll Smooth
  if (window.location.hash) {
    let element = document.querySelector(window.location.hash)
    if (element) {
      setTimeout(() => {
        element.scrollIntoView({ behavior: 'smooth' })
      }, 500) // Ajoute un léger délai pour s'assurer que la page est chargée
    }
  }

  // Création des animations et stockage des références
  const animations = []

  if (typeof gsap !== 'undefined') {
    gsap.utils.toArray('.marquee').forEach((el, index) => {
      // Créer l'animation et la stocker dans le tableau
      const animation = gsap.to(el, {
        x: '-100%',
        duration: 20,
        repeat: -1,
        ease: 'linear',
        delay: index * 4
      })

      animations.push(animation)

      // Pause au survol sur desktop
      if (window.matchMedia('(hover: hover)').matches) {
        el.addEventListener('mouseenter', () => {
          animation.pause() // Pause l'animation spécifique
        })

        el.addEventListener('mouseleave', () => {
          animation.play() // Reprend l'animation spécifique
        })
      }

      // Pause au toucher sur mobile
      el.addEventListener('touchstart', () => {
        animation.pause() // Pause l'animation spécifique
      })

      el.addEventListener('touchend', () => {
        // Reprendre l'animation après un court délai
        setTimeout(() => {
          animation.play()
        }, 1000)
      })
    })
  }

  // Gestion de l'orientation de l'écran
  function handleOrientationChange() {
    if (window.matchMedia('(orientation: portrait)').matches) {
      // Mode portrait
      document.body.classList.add('portrait')
      document.body.classList.remove('landscape')
    } else if (window.matchMedia('(orientation: landscape)').matches) {
      // Mode paysage
      document.body.classList.add('landscape')
      document.body.classList.remove('portrait')
    }
  }

  // Ajouter un écouteur pour les changements d'orientation
  window.addEventListener('resize', handleOrientationChange)

  // Vérifier l'orientation initiale au chargement de la page
  handleOrientationChange()
})