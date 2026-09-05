function initPosSwiper() {
  if (typeof Swiper === 'undefined') return;
  if (window.posSwiper && typeof window.posSwiper.destroy === 'function') {
    window.posSwiper.destroy(true, true);
  }
  window.posSwiper = new Swiper(".swiper-container", {
    slidesPerView: 6, // Desktop strictly 6 cards
    spaceBetween: 8,
    loop: false,
    observer: true,
    observeParents: true,
    navigation: {
      nextEl: "#brandSlideNext",
      prevEl: "#brandSlidePrev",
    },
    breakpoints: {
      320: {
        slidesPerView: 2,
        spaceBetween: 6,
      },
      480: {
        slidesPerView: 3,
        spaceBetween: 6,
      },
      640: {
        slidesPerView: 4,
        spaceBetween: 8,
      },
      768: {
        slidesPerView: 5,
        spaceBetween: 8,
      },
      992: {
        slidesPerView: 4,
        spaceBetween: 8,
      },
      1200: {
        slidesPerView: 4,
        spaceBetween: 8,
      },
      1440: {
        slidesPerView: 4,
        spaceBetween: 8,
      },
      1920: {
        slidesPerView: 6,
        spaceBetween: 8,
      },
    },
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initPosSwiper();
});

window.initPosSwiper = initPosSwiper;
