import { Controller } from 'stimulus';
import { Modal } from 'bootstrap';

export default class extends Controller {
    static targets = ['modal', 'modalBody'];

    static values = {
        formUrl: String,
    }
    async openModal(event) {
        this.modalBodyTarget.innerHTML = 'Loading...';
    }

    async submitForm() {
        const $form = $(this.modalBodyTarget).find('form');
        this.modalBodyTarget.innerHTML = await $.ajax({
            url: $form.prop('action'),
            method: $form.prop('method'),
            data: $form.serialize(),
        });
    }
}