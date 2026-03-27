import { onDomReady } from './dom-ready.js';

const scrollTriggerSelector = '[data-scroll-target]';

const getHeaderOffset = () => {
  const header = document.querySelector('.cy-site-header');

  if (!(header instanceof HTMLElement)) {
    return 24;
  }

  return header.offsetHeight + 24;
};

const scrollToTarget = (selector) => {
  if (typeof selector !== 'string' || selector.trim() === '') {
    return;
  }

  const target = document.querySelector(selector);

  if (!(target instanceof HTMLElement)) {
    return;
  }

  const top = target.getBoundingClientRect().top + window.scrollY - getHeaderOffset();

  window.scrollTo({
    top: Math.max(top, 0),
    behavior: 'smooth',
  });
};

const shouldHandleScrollTarget = (trigger, targetSelector, event) => {
  if (!(trigger instanceof HTMLElement)) {
    return false;
  }

  if (!(trigger instanceof HTMLAnchorElement)) {
    return true;
  }

  if (
    event.defaultPrevented ||
    event.button !== 0 ||
    event.metaKey ||
    event.ctrlKey ||
    event.shiftKey ||
    event.altKey
  ) {
    return false;
  }

  const href = trigger.getAttribute('href');

  if (typeof href !== 'string' || href.trim() === '' || href === '#') {
    return true;
  }

  if (!href.includes('#')) {
    return false;
  }

  const currentUrl = new URL(window.location.href);
  const targetUrl = new URL(href, window.location.href);
  const isSameDocument = (
    targetUrl.origin === currentUrl.origin &&
    targetUrl.pathname === currentUrl.pathname &&
    targetUrl.search === currentUrl.search
  );

  if (!isSameDocument) {
    return false;
  }

  return targetUrl.hash === targetSelector;
};

export const initScrollTargets = () => {
  onDomReady(() => {
    document.addEventListener('click', (event) => {
      const trigger = event.target instanceof Element
        ? event.target.closest(scrollTriggerSelector)
        : null;

      if (!(trigger instanceof HTMLElement)) {
        return;
      }

      const targetSelector = trigger.dataset.scrollTarget;

      if (typeof targetSelector !== 'string' || targetSelector.trim() === '') {
        return;
      }

      if (!shouldHandleScrollTarget(trigger, targetSelector, event)) {
        return;
      }

      event.preventDefault();
      scrollToTarget(targetSelector);
    });
  });
};
