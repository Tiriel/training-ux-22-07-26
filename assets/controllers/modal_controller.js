import {Controller} from "@hotwired/stimulus";
import {Modal} from "bootstrap";

export default class extends Controller {
    static targets = ['modal'];

    show() {
        new Modal(this.modalTarget).show();
    }
}
