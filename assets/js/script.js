document.addEventListener('DOMContentLoaded', function () {
  console.log('DOMContentLoaded a été déclenché')

  // Redirection du logo vers la page d'accueil
  let logo = document.querySelector('.custom-logo-link')
  if (logo) {
    logo.addEventListener('click', function (e) {
      e.preventDefault() // Annule l'action par défaut
      window.location.href = '/' // Redirige vers la page d'accueil
    })
  }

  // Interaction pour le hamburger-menu
  const hamburgerMenu = document.getElementById('hamburger-menu')
  const menuToggle = document.getElementById('menu-toggle')
  const body = document.querySelector('body')

  if (hamburgerMenu && menuToggle) {
    hamburgerMenu.addEventListener('click', function () {
      hamburgerMenu.classList.toggle('open')
      menuToggle.classList.toggle('open')
      body.classList.toggle('no-scroll') // Bloque le défilement lorsque le menu est ouvert
    })
  }

  // Script pour la modale
  const modal = document.getElementById('contactModal')
  console.log(modal ? 'Modale trouvée' : 'Modale non trouvée')

  // Sélectionner les boutons CONTACT
  const btn1 = document.querySelector('#menu-item-24 > a') // Bouton menu navigation
  const btn2 = document.querySelector('#menu-toggle ul li:nth-child(3) a')
  const btn3 = document.getElementById('contactBtn')

  function openModal(event) {
    event.preventDefault()
    event.stopPropagation()

    // Fermer le menu toggle si nécessaire
    if (menuToggle && menuToggle.classList.contains('open')) {
      hamburgerMenu.classList.remove('open')
      menuToggle.classList.remove('open')
      body.classList.remove('no-scroll')
    }

    // Ouvrir la modale si elle existe
    if (modal) {
      modal.classList.add('show')
    }
  }

  // Ajouter l'événement d'ouverture de la modale aux boutons s'ils existent
  if (btn1) btn1.addEventListener('click', openModal)
  if (btn2) btn2.addEventListener('click', openModal)
  if (btn3) btn3.addEventListener('click', openModal)

  // Fermer la modale si clic en dehors
  if (modal) {
    window.addEventListener('click', function (event) {
      if (event.target === modal) {
        modal.classList.remove('show')
      }
    })
  }

  // Écouter l'événement de soumission réussie de CF7
  document.addEventListener(
    'wpcf7mailsent',
    function (event) {
      if (modal) {
        setTimeout(function () {
          modal.classList.remove('show')
          window.location.href = '/'
        }, 3000)
      }
    },
    false
  )
})
// Gestion du Scroll Smooth
document.addEventListener('DOMContentLoaded', function () {
  if (window.location.hash) {
    let element = document.querySelector(window.location.hash)
    if (element) {
      setTimeout(() => {
        element.scrollIntoView({ behavior: 'smooth' })
      }, 500) // Ajoute un léger délai pour s'assurer que la page est chargée
    }
  }
})
document.addEventListener('DOMContentLoaded', function () {
  // Création des animations et stockage des références
  const animations = []

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

    // Pause au survol
    el.addEventListener('mouseenter', () => {
      animation.pause() // Pause l'animation spécifique
    })

    el.addEventListener('mouseleave', () => {
      animation.play() // Reprend l'animation spécifique
    })
  })
})

