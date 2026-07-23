import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.hasMinLength = this.element.hasAttribute('minlength');
        this.hasMaxLength = this.element.hasAttribute('maxlength');

        this.container = this.element.parentElement;
        if (!this.container) {
            return;
        }

        this.container.classList.add('position-relative');
        this.element.classList.add('pe-5');

        this.counter = this.container.querySelector('[data-ic-counter]');

        if (!this.counter) {
            this.counter = document.createElement('div');
            this.counter.setAttribute('data-ic-counter', '');
            this.counter.classList.add(
                'position-absolute',
                'top-0',
                'end-0',
                'me-3',
                'pt-1',
                'pe-2',
                'small',
                'text-muted'
            );

            this.counter.style.pointerEvents = 'none';
            this.counter.setAttribute('aria-live', 'polite');
            this.container.appendChild(this.counter);
        }

        this.check();
    }

    check() {
        const minLength = () => parseInt(this.element.getAttribute('minlength'));
        const maxLength = () => parseInt(this.element.getAttribute('maxlength'));

        const isValidMaxLength = !this.hasMaxLength || this.element.value.length <= maxLength();
        const isValidMinLength = !this.hasMinLength || this.element.value.length >= minLength();

        this.counter.textContent = `${this.element.value.length}`

        if (this.hasMaxLength) {
            this.counter.textContent = this.counter.textContent + ` / ${maxLength()}`;
        }

        if (this.hasMinLength) {
            this.counter.textContent = this.counter.textContent + ` / ${minLength()}`;
        }

        if (isValidMaxLength && isValidMinLength) {
            this.counter.classList.add('text-success');
            this.counter.classList.remove('text-danger', 'text-muted');
        } else {
            this.counter.classList.add('text-danger');
            this.counter.classList.remove('text-success', 'text-muted');
        }
    }
}
