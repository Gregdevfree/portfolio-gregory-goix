document.addEventListener('DOMContentLoaded', function () {
  const lightbox = document.getElementById('lightbox')
  const lightboxImage = document.getElementById('lightbox-image')
  const lightboxTitle = document.getElementById('lightbox-title')
  const lightboxCategory = document.getElementById('lightbox-category')
  const lightboxClose = document.getElementById('lightbox-close')
  const lightboxPrev = document.getElementById('lightbox-prev')
  const lightboxNext = document.getElementById('lightbox-next')
  let currentPhotoIndex = 0
  let photos = []
  let isLoading = false

  function attachEventListeners() {
    // Attacher les événements aux boutons plein écran
    document
      .querySelectorAll('.overlay-link-fullscreen')
      .forEach(function (link) {
        link.addEventListener('click', function (event) {
          event.preventDefault()
          const photoId = this.getAttribute('data-photo-id')
          openLightbox(photoId)
        })
      })
  }

  // Événements de navigation
  lightboxClose.addEventListener('click', function () {
    closeLightbox()
  })

  lightboxPrev.addEventListener('click', function (event) {
    event.preventDefault()
    navigateLightbox('prev')
  })

  lightboxNext.addEventListener('click', function (event) {
    event.preventDefault()
    navigateLightbox('next')
  })

  function updatePhotosArray() {
    // Récupérer toutes les photos visibles dans la galerie
    const photoElements = document.querySelectorAll('.overlay-link-fullscreen')
    photos = Array.from(photoElements).map((element) => ({
      id: element.getAttribute('data-photo-id'),
      url: element.getAttribute('data-photo-url'),
      title: element.getAttribute('data-photo-title'),
      category: element.getAttribute('data-photo-category')
    }))
  }

  function openLightbox(photoId) {
    // Mettre à jour le tableau des photos avant d'ouvrir la lightbox
    updatePhotosArray()

    // Trouver l'index de la photo actuelle
    currentPhotoIndex = photos.findIndex((photo) => photo.id === photoId)

    if (currentPhotoIndex !== -1) {
      const photoData = photos[currentPhotoIndex]
      lightboxImage.src = photoData.url
      lightboxImage.setAttribute('data-photo-id', photoData.id)
      lightboxTitle.textContent = photoData.title
      lightboxCategory.textContent = photoData.category
      lightbox.style.display = 'flex'

      // Mettre à jour la visibilité des boutons de navigation
      updateNavigationButtons()
    }
  }

  function closeLightbox() {
    lightbox.style.display = 'none'
  }

  function updateNavigationButtons() {
    // Afficher/masquer les boutons de navigation en fonction de la position actuelle
    lightboxPrev.style.visibility = currentPhotoIndex > 0 ? 'visible' : 'hidden'
    lightboxNext.style.visibility =
      currentPhotoIndex < photos.length - 1 ? 'visible' : 'hidden'
  }

  function navigateLightbox(direction) {
    if (isLoading) return

    const newIndex =
      direction === 'prev' ? currentPhotoIndex - 1 : currentPhotoIndex + 1

    if (newIndex >= 0 && newIndex < photos.length) {
      currentPhotoIndex = newIndex
      const photoData = photos[currentPhotoIndex]

      lightboxImage.src = photoData.url
      lightboxImage.setAttribute('data-photo-id', photoData.id)
      lightboxTitle.textContent = photoData.title
      lightboxCategory.textContent = photoData.category

      updateNavigationButtons()
    }
  }

  // Fonction pour charger plus de photos si nécessaire
  function loadMorePhotos() {
    if (isLoading) return
    isLoading = true

    const page = Math.ceil((photos.length + 1) / 8)

    fetch(`/wp-admin/admin-ajax.php?action=load_more_photos&page=${page}`)
      .then((response) => response.text())
      .then((html) => {
        const parser = new DOMParser()
        const doc = parser.parseFromString(html, 'text/html')

        // Ajouter les nouvelles photos au conteneur
        const photoGalleryContainer = document.querySelector(
          '.photo-gallery-container'
        )
        if (photoGalleryContainer) {
          photoGalleryContainer.insertAdjacentHTML('beforeend', html)
        }

        // Mettre à jour le tableau des photos
        updatePhotosArray()

        // Réattacher les événements
        attachEventListeners()

        isLoading = false
      })
      .catch((error) => {
        console.error('Error loading more photos:', error)
        isLoading = false
      })
  }

  // Écouter l'événement de filtrage des photos
  document.addEventListener('photosFiltered', function () {
    updatePhotosArray()
  })

  // Initialisation
  updatePhotosArray()
  attachEventListeners()

  // Exposer la fonction d'attachement des événements pour une utilisation externe
  window.attachLightboxEventListeners = attachEventListeners
})
