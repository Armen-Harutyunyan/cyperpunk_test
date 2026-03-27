import { registerRevealGroup } from '../common/reveal.js';

export const initTrySectionBlock = () => {
  registerRevealGroup({ selector: '.cy-try__media', variant: 'left' });

  registerRevealGroup({
    selector: '.cy-try__title, .cy-try__description, .cy-try__actions',
    variant: 'up',
    stagger: 100,
  });

  registerRevealGroup({
    selector: '.cy-try__list .cy-try__list-item',
    variant: 'up',
    stagger: 80,
  });
};
