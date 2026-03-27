import { onDomReady } from '../common/dom-ready.js';
import { registerRevealGroup } from '../common/reveal.js';

const fileFieldSelector = '.cy-cta .cy-form__field--file';
const floatingFieldSelector = '.cy-cta .cy-form__field:not(.cy-form__field--file)';
const controlSelector = '.cy-form__input, textarea, select';

const syncFileFieldState = (field) => {
  if (!(field instanceof HTMLElement)) {
    return;
  }

  const input = field.querySelector('input[type="file"]');
  const label = field.querySelector('.cy-form__file-label');

  if (!(input instanceof HTMLInputElement) || !(label instanceof HTMLElement)) {
    return;
  }

  if (typeof label.dataset.defaultText !== 'string' || label.dataset.defaultText === '') {
    label.dataset.defaultText = label.textContent ? label.textContent.trim() : '';
  }

  const fileName = input.files && input.files[0] ? input.files[0].name : '';

  label.textContent = fileName || label.dataset.defaultText;
  field.classList.toggle('has-file', fileName !== '');
};

const initFileField = (field) => {
  if (!(field instanceof HTMLElement) || field.dataset.fileReady === 'true') {
    return;
  }

  const input = field.querySelector('input[type="file"]');

  if (!(input instanceof HTMLInputElement)) {
    return;
  }

  input.addEventListener('change', () => {
    syncFileFieldState(field);
  });

  syncFileFieldState(field);
  field.dataset.fileReady = 'true';
};

const hasValue = (control) => {
  if (!(control instanceof HTMLElement)) {
    return false;
  }

  if (control instanceof HTMLSelectElement) {
    return control.value.trim() !== '';
  }

  if (
    control instanceof HTMLInputElement ||
    control instanceof HTMLTextAreaElement
  ) {
    return control.value.trim() !== '';
  }

  return false;
};

const syncFloatingFieldState = (field, control) => {
  if (!(field instanceof HTMLElement) || !(control instanceof HTMLElement)) {
    return;
  }

  field.classList.toggle('is-active', hasValue(control) || control === document.activeElement);
};

const initFloatingField = (field) => {
  if (!(field instanceof HTMLElement) || field.dataset.floatingReady === 'true') {
    return;
  }

  const label = field.querySelector('.cy-form__label');
  const control = field.querySelector(controlSelector);

  if (!(label instanceof HTMLElement) || !(control instanceof HTMLElement)) {
    return;
  }

  field.classList.add('cy-form__field--floating');

  const syncState = () => syncFloatingFieldState(field, control);

  label.addEventListener('click', () => {
    control.focus();
  });

  field.addEventListener('click', (event) => {
    if (event.target === field || event.target === label) {
      control.focus();
    }
  });

  control.addEventListener('focus', syncState);
  control.addEventListener('blur', syncState);
  control.addEventListener('input', syncState);
  control.addEventListener('change', syncState);

  syncState();
  field.dataset.floatingReady = 'true';
};

const initFloatingLabels = (scope = document) => {
  scope.querySelectorAll(floatingFieldSelector).forEach(initFloatingField);
};

const initFileFields = (scope = document) => {
  scope.querySelectorAll(fileFieldSelector).forEach(initFileField);
};

export const initCtaSectionBlock = () => {
  registerRevealGroup({ selector: '.cy-cta__promo', variant: 'scale' });

  registerRevealGroup({
    selector: '.cy-cta__title, .cy-cta__description, .cy-cta__form-wrap',
    variant: 'up',
    stagger: 100,
  });

  registerRevealGroup({
    selector: '.cy-cta__media-item, .cy-cta__media-layer',
    variant: 'right',
    stagger: 120,
  });

  onDomReady(() => {
    initFileFields();
    initFloatingLabels();

    document.addEventListener('wpcf7reset', (event) => {
      const form = event.target;

      if (!(form instanceof HTMLElement)) {
        return;
      }

      initFileFields(form);
      initFloatingLabels(form);

      window.requestAnimationFrame(() => {
        form.querySelectorAll(fileFieldSelector).forEach((field) => {
          syncFileFieldState(field);
        });

        form.querySelectorAll(floatingFieldSelector).forEach((field) => {
          const control = field.querySelector(controlSelector);

          if (control instanceof HTMLElement) {
            syncFloatingFieldState(field, control);
          }
        });
      });
    });
  });
};
