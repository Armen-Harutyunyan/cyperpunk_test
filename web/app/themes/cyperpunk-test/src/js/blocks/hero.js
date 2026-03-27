import { onDomReady } from '../common/dom-ready.js';
const heroSelector = '.cyperpunk-hero__slides';
const slideSelector = '.cyperpunk-hero__slide';
const slideInterval = 6000;

const initHeroSlider = (slider) => {
  if (!(slider instanceof HTMLElement) || slider.dataset.sliderReady === 'true') {
    return;
  }

  const slides = Array.from(slider.querySelectorAll(slideSelector));

  if (slides.length <= 1) {
    if (slides[0] instanceof HTMLElement) {
      slides[0].classList.add('is-active');
    }

    slider.dataset.sliderReady = 'true';
    return;
  }

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    slides[0].classList.add('is-active');
    slider.dataset.sliderReady = 'true';
    return;
  }

  let activeIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));

  if (activeIndex < 0) {
    activeIndex = 0;
    slides[0].classList.add('is-active');
  }

  window.setInterval(() => {
    slides[activeIndex].classList.remove('is-active');
    activeIndex = (activeIndex + 1) % slides.length;
    slides[activeIndex].classList.add('is-active');
  }, slideInterval);

  slider.dataset.sliderReady = 'true';
};

export const initHeroBlock = () => {
  onDomReady(() => {
    document.querySelectorAll(heroSelector).forEach(initHeroSlider);
  });
};
