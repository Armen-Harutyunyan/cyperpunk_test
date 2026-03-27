import { registerRevealGroup } from '../common/reveal.js';

export const initBuySectionBlock = () => {
  registerRevealGroup({ selector: '.cy-buy__media', variant: 'left' });

  registerRevealGroup({
    selector: '.cy-buy__title, .cy-buy__subtitle, .cy-buy__platforms',
    variant: 'up',
    stagger: 100,
  });

  registerRevealGroup({
    selector: '.cy-buy__list .cy-buy__list-item',
    variant: 'up',
    stagger: 70,
  });
};
