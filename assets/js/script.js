document.addEventListener('DOMContentLoaded', function () {
  console.log('DOMContentLoaded a été déclenché')

  // Redirection du logo vers la page d'accueil
  document
    .querySelector('.custom-logo-link')
    .addEventListener('click', function (e) {
      e.preventDefault() // Annule l'action par défaut si nécessaire
      window.location.href = '/' // Redirige vers la page d'accueil
    })

  // Interaction pour le hamburger-menu
  const hamburgerMenu = document.getElementById('hamburger-menu')
  const menuToggle = document.getElementById('menu-toggle')
  const body = document.querySelector('body')

  // Lorsque le hamburger-menu est cliqué
  hamburgerMenu.addEventListener('click', function () {
    // Ajouter ou retirer la classe "open" pour afficher ou masquer le menu
    hamburgerMenu.classList.toggle('open')
    menuToggle.classList.toggle('open')
    body.classList.toggle('no-scroll') // Bloquer le défilement du body lorsque le menu est ouvert
  })

  // Script pour la modale
  var modal = document.getElementById('contactModal')
  console.log(modal) // Vérifie si l'élément est correctement sélectionné

  // Sélectionner les boutons CONTACT
  var btn1 = document.querySelector('#menu-item-59 > a')
  var btn2 = document.querySelector('#menu-toggle ul li:nth-child(3) a')
  var btn3 = document.getElementById('contactBtn')

  // Fonction pour ouvrir la modale
  function openModal(event) {
    event.preventDefault() // Empêche le comportement par défaut du lien
    event.stopPropagation() // Arrête la propagation de l'événement

    // Fermer le menu toggle si nécessaire
    if (menuToggle.classList.contains('open')) {
      hamburgerMenu.classList.remove('open')
      menuToggle.classList.remove('open')
      body.classList.remove('no-scroll')
    }

    // Ouvrir la modale avec la classe show
    if (modal) {
      modal.classList.add('show')
    }

    // Préremplir la référence de la photo dans le champ du formulaire de contact avec JQuery
    var photoRef = document.getElementById('photo-ref')?.value
    var referenceInput = document.querySelector('.wpcf7-form .reference')
    if (photoRef && referenceInput) {
      referenceInput.value = photoRef
    }
  }

  // Ajouter la fonction d'ouverture de la modale aux boutons
  if (btn1) btn1.addEventListener('click', openModal)
  if (btn2) btn2.addEventListener('click', openModal)
  if (btn3) btn3.addEventListener('click', openModal)

  // Fermer la modale si clic en dehors
  window.addEventListener('click', function (event) {
    if (event.target === modal) {
      modal.classList.remove('show')
    }
  })

  // Écouter l'événement de soumission réussie de CF7
  document.addEventListener(
    'wpcf7mailsent',
    function (event) {
      // Fermer la modale après 3 secondes
      setTimeout(function () {
        modal.classList.remove('show')
        // Rediriger vers la page d'accueil
        window.location.href = '/'
      }, 3000) // 3000 millisecondes = 3 secondes
    },
    false
  )

  // Script pour afficher les miniatures au survol des flèches de navigation
  const arrows = document.querySelectorAll('.arrow')

  arrows.forEach((arrow) => {
    arrow.addEventListener('mouseenter', function () {
      const thumbnailContainer = this.querySelector('.thumbnail-container')
      if (thumbnailContainer) {
        thumbnailContainer.style.display = 'block'
      }
    })

    arrow.addEventListener('mouseleave', function () {
      const thumbnailContainer = this.querySelector('.thumbnail-container')
      if (thumbnailContainer) {
        thumbnailContainer.style.display = 'none'
      }
    })
  })

  // Récupération et affichage de l'image aléatoire dans le hero-header
  const heroHeader = document.getElementById('hero-header')

  if (heroHeader) {
    fetch('/wp-admin/admin-ajax.php?action=get_random_photo')
      .then((response) => response.json())
      .then((data) => {
        if (data.success && data.image) {
          heroHeader.style.backgroundImage = 'url(' + data.image + ')'
          heroHeader.classList.remove('loading') // Supprime la classe loading une fois chargé
        }
      })
      .catch((error) =>
        console.error("Erreur de chargement de l'image:", error)
      )
  }

  jQuery(document).ready(function ($) {
    // Initialize Select2 with configuration to prevent closing
    function initializeSelect2() {
      $('.gallery-filters select')
        .select2({
          minimumResultsForSearch: -1, // Disable search
          width: '260px',
          dropdownAutoWidth: true,
          dropdownParent: $('.gallery-filters'),
          closeOnSelect: false // Empêche la fermeture après la sélection
        })
        .on('select2:select', function (e) {
          e.stopPropagation() // Empêche la propagation de l'événement
          $(this).focus() // Maintient le focus sur le select
        })
        .on('select2:open', function (e) {
          $(this).data('select2').$dropdown.addClass('select2-dropdown--below')
        })

      // Gestion manuelle de la fermeture
      $(document).on('click', function (e) {
        if (!$(e.target).closest('.select2-container').length) {
          $('.gallery-filters select').select2('close')
        }
      })
    }

    // Function to populate dropdowns dynamically
    function populateDropdowns() {
      $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: {
          action: 'get_gallery_filter_options'
        },
        success: function (response) {
          if (response.success) {
            // Populate Categories dropdown
            var $categoriesSelect = $('#gallery-categories')
            $categoriesSelect.empty()
            $categoriesSelect.append('<option value=""></option>') // Option vide
            $categoriesSelect.append('<option disabled>&nbsp;</option>') // Séparateur invisible

            response.data.categories.forEach(function (category) {
              $categoriesSelect.append(
                `<option value="${category.slug}">${category.name}</option>`
              )
            })

            // Populate Formats dropdown
            var $formatsSelect = $('#gallery-formats')
            $formatsSelect.empty()
            $formatsSelect.append('<option value=""></option>') // Option vide
            $formatsSelect.append('<option disabled>&nbsp;</option>') // Séparateur invisible

            response.data.formats.forEach(function (format) {
              $formatsSelect.append(
                `<option value="${format.slug}">${format.name}</option>`
              )
            })

            // Populate Sort dropdown
            var $sortSelect = $('#gallery-sort')
            $sortSelect.empty()
            $sortSelect.append('<option value=""></option>') // Option vide
            $sortSelect.append('<option disabled>&nbsp;</option>') // Séparateur invisible
            $sortSelect.append(
              '<option value="DESC">Photo la plus récente</option>'
            )
            $sortSelect.append(
              '<option value="ASC">Photo la plus ancienne</option>'
            )

            // Initialize Select2
            initializeSelect2()
          }
        }
      })
    }

    // Mise à jour de l'initialisation de Select2
    function initializeSelect2() {
      $('.gallery-filters select')
        .select2({
          minimumResultsForSearch: -1, // Disable search
          width: '260px',
          dropdownAutoWidth: true,
          dropdownParent: $('.gallery-filters'),
          closeOnSelect: true, // Ferme le dropdown après sélection
          dropdownPosition: 'below' // Force l'affichage vers le bas
        })
        .on('select2:select', function (e) {
          $(this).select2('close') // Force la fermeture après sélection
        })
        .on('select2:open', function () {
          // Supprimer tout highlight initial
          setTimeout(function () {
            $('.select2-results__option--highlighted').removeClass(
              'select2-results__option--highlighted'
            )
          }, 0)
        })
    }

    // Function to filter and sort photos
    function filterPhotos() {
      var category = $('#gallery-categories').val()
      var format = $('#gallery-formats').val()
      var sort = $('#gallery-sort').val()

      $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: {
          action: 'filter_and_sort_photos',
          category: category,
          format: format,
          sort: sort
        },
        success: function (response) {
          if (response.success) {
            $('.photo-gallery-container').html(response.data)
            // Déclencher l'événement de filtrage
            document.dispatchEvent(new Event('photosFiltered'))
            window.attachLightboxEventListeners()
          }
        }
      })
    }

    // Function to update lightbox data
    function updateLightboxData() {
      photos = []
      document
        .querySelectorAll('.overlay-link[data-photo-id]')
        .forEach((element) => {
          photos.push({
            id: element.getAttribute('data-photo-id'),
            url: element.getAttribute('data-photo-url'),
            title: element.getAttribute('data-photo-title'),
            category: element.getAttribute('data-photo-category')
          })
        })
    }

    // Populate dropdowns on page load
    populateDropdowns()

    // Add event listeners for filtering and sorting
    $('.gallery-filters select').on('change', function (e) {
      e.stopPropagation() // Empêche la propagation de l'événement
      filterPhotos()
    })

    // Add event listener for the "Charger plus" button
    $('#loadmoreBtn').on('click', function () {
      var page = parseInt($(this).data('page')) + 1
      $(this).data('page', page)

      $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: {
          action: 'load_more_photos',
          page: page
        },
        success: function (response) {
          if (response.trim() !== '') {
            $('.photo-gallery-container').append(response)
            updateLightboxData() // Mettre à jour les données des photos dans la lightbox
            window.attachLightboxEventListeners() // Re-attach event listeners
          } else {
            $('#loadmoreBtn').hide() // Masquer le bouton s'il n'y a plus de photos à charger
          }
        }
      })
    })

    // Initial load of photos
    updateLightboxData()
    window.attachLightboxEventListeners() // Initial attachment of event listeners
  })
})



