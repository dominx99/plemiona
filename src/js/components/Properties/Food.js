export default class Food {
    constructor() {
        this.el = '#food';
        this.value = 0;
    }

    set(value) {
        this.value = value;

        $(this.el).text(value);
    }
}