export default class Alert {
    constructor() {
        this.alerts = $('.alerts');
    }

    set(message, type = 'danger') {
        let alert = this.buildAlert(message, type);
        this.alerts.html(alert);

        setTimeout(() => alert.remove(), 3000);    
    }

    buildAlert(message, type) {
        return $('<div></div>')
            .addClass('alert mb-3 alert-' + type)
            .text(message);
    }
}