// بزرگ‌نمایی عکس‌های گالری
var galleryImages = document.querySelectorAll('.gallery .pic img');
var galleryView = document.getElementById('gallery-view');
var galleryLarge = document.getElementById('gallery-large');
var galleryCaption = document.getElementById('gallery-caption');
var galleryIndex = 0;

function showGalleryImage(index) {
  if (index < 0) {
    index = galleryImages.length - 1;
  }
  if (index >= galleryImages.length) {
    index = 0;
  }

  galleryIndex = index;
  galleryLarge.src = galleryImages[galleryIndex].src;
  galleryLarge.alt = galleryImages[galleryIndex].alt;
  galleryCaption.innerText = galleryImages[galleryIndex].alt;
}

function closeGallery() {
  galleryView.classList.remove('show');
  galleryView.setAttribute('aria-hidden', 'true');
}

for (var i = 0; i < galleryImages.length; i++) {
  galleryImages[i].addEventListener('click', function () {
    galleryView.classList.add('show');
    galleryView.setAttribute('aria-hidden', 'false');
    showGalleryImage(Array.prototype.indexOf.call(galleryImages, this));
  });
}

document.getElementById('gallery-close').addEventListener('click', closeGallery);
document.getElementById('gallery-prev').addEventListener('click', function () {
  showGalleryImage(galleryIndex - 1);
});
document.getElementById('gallery-next').addEventListener('click', function () {
  showGalleryImage(galleryIndex + 1);
});
galleryView.addEventListener('click', function (event) {
  if (event.target === galleryView) {
    closeGallery();
  }
});
document.addEventListener('keydown', function (event) {
  if (!galleryView.classList.contains('show')) {
    return;
  }
  if (event.key === 'Escape') {
    closeGallery();
  }
  if (event.key === 'ArrowRight') {
    showGalleryImage(galleryIndex - 1);
  }
  if (event.key === 'ArrowLeft') {
    showGalleryImage(galleryIndex + 1);
  }
});
