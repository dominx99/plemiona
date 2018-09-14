export default class Gold {
    constructor() {
        this.el = '#gold';
        this.value = 0;
    }

    set(value) {
        this.value = value;

        $(this.el).text(value);
    }
}