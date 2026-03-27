import { onDomReady } from './dom-ready.js';

const revealGroups = [];

export const registerRevealGroup = (group) => {
  if (!group || typeof group.selector !== 'string' || group.selector.trim() === '') {
    return;
  }

  revealGroups.push(group);
};

export const initRevealAnimations = () => {
  onDomReady(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      return;
    }

    document.body.classList.add('js-motion');

    revealGroups.forEach(({ selector, variant, stagger = 0 }) => {
      document.querySelectorAll(selector).forEach((element, index) => {
        if (!(element instanceof HTMLElement) || element.dataset.revealReady === 'true') {
          return;
        }

        element.classList.add('js-reveal');

        if (typeof variant === 'string' && variant !== '') {
          element.classList.add(`js-reveal--${variant}`);
        }

        if (stagger > 0) {
          element.style.transitionDelay = `${index * stagger}ms`;
        }

        element.dataset.revealReady = 'true';
      });
    });

    const revealTargets = Array.from(document.querySelectorAll('.js-reveal'));

    if (revealTargets.length === 0) {
      return;
    }

    const observer = new IntersectionObserver(
      (entries, revealObserver) => {
        entries.forEach((entry) => {
          if (!(entry.target instanceof HTMLElement) || !entry.isIntersecting) {
            return;
          }

          entry.target.classList.add('is-visible');
          revealObserver.unobserve(entry.target);
        });
      },
      {
        threshold: 0.18,
        rootMargin: '0px 0px -8% 0px',
      },
    );

    revealTargets.forEach((target) => {
      if (target instanceof HTMLElement) {
        observer.observe(target);
      }
    });
  });
};
