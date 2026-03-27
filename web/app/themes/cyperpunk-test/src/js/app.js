import { initRevealAnimations } from './common/reveal.js';
import { initSiteHeader } from './common/site-header.js';
import { initScrollTargets } from './common/scroll-targets.js';
import { initHeroBlock } from './blocks/hero.js';
import { initSearchCityBlock } from './blocks/search-city.js';
import { initTrySectionBlock } from './blocks/try-section.js';
import { initBuySectionBlock } from './blocks/buy-section.js';
import { initCtaSectionBlock } from './blocks/cta-section.js';

initHeroBlock();
initSearchCityBlock();
initTrySectionBlock();
initBuySectionBlock();
initCtaSectionBlock();

initSiteHeader();
initScrollTargets();
initRevealAnimations();
