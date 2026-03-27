import { registerRevealGroup } from '../common/reveal.js';

export const initSearchCityBlock = () => {
  registerRevealGroup({
    selector: '.cy-city__title, .cy-city__description',
    variant: 'fade',
    stagger: 100,
  });

  registerRevealGroup({
    selector: '.cy-city__gallery .cy-city__image',
    variant: 'soft-scale',
    stagger: 120,
  });
};
