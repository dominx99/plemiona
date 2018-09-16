export default class Timings {
    constructor(type) {
        this.type = type;
    }

    set(timings) {
        this.buildTimings(timings);
    }

    buildTimings(timings) {
        let list = $('#' + this.type);
        list.html('');

        timings.map(timing => {
            let el = this.buildTiming(timing);

            list.append(el);
        });
    }

    buildTiming(timing) {
        let el = $('<div></div>').addClass('timing');

        let fullName = timing[this.type].name;
        fullName = this.appendLevel(fullName, timing.level);
        fullName = this.appendAmount(fullName, timing.amount);

        let name = $('<div></div>').addClass('name').text(fullName);
        let time = $('<div></div>').addClass('time');
        let seconds = 0;

        if (timing.active) {
            let now = new Date();
            let timingTime = new Date(timing.done_at);

            seconds = Math.ceil((timingTime - now) / 1000);
            time.attr('id', 'time_' + timing.id).text(seconds);
        }

        if (!timing.active) {
            seconds = timing.time;
            time.text(seconds);
        }

        el.append(name);
        el.append(time);

        if (timing.active) {
            this.decreaseTime(timing.id, seconds);
        }

        return el;
    }

    decreaseTime(id) {
        id = '#time_' + id;
        
        let interval = setInterval(() => {
            let number = this.getNumberFromEl(id);

            if (number === false) {
                clearInterval(interval);
                return;
            }

            $(id).text(number);
        }, 1000);

        window.intervals.push(interval);
    }

    getNumberFromEl(id) {
        let el = $(id);
        let number = parseInt(el.text());

        if (isNaN(number) || number <= 0) {
            village.update();
            return false;
        }

        return --number;
    }

    appendAmount(name, amount) {
        if (amount) {
            return name + ' x ' + amount;
        }
        
        return name;
    }

    appendLevel(name, level) {
        if (level) {
            return name + ' lv.' + level;
        }

        return name;
    }
}