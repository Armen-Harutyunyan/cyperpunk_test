import { onDomReady } from './dom-ready.js';

export const initSiteHeader = () => {
  onDomReady(() => {
    const header = document.querySelector('.cy-site-header');

    if (!(header instanceof HTMLElement)) {
      return;
    }

    const syncHeaderState = () => {
      header.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    syncHeaderState();

    window.addEventListener('scroll', syncHeaderState, { passive: true });
  });
};
