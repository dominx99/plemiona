export default class BuildingTimings {
    constructor() {
        
    }

    set(timings) {
        this.buildTimings(timings);
    }

    buildTimings(timings) {
        let list = $('.timings');
        list.html('');

        timings.map(timing => {
            let el = this.buildTiming(timing);

            list.append(el);
        });
    }

    buildTiming(timing) {
        console.log(timing);
        let el = $('<div></div>').addClass('timing');
        let name = $('<div></div>').addClass('name').text(timing.building.name + ' lv.' + timing.level);

        let time = $('<div></div>').addClass('time');
        let seconds = 0;

        if (timing.active) {
            let now = new Date();
            let buildingTime = new Date(timing.done_at);

            seconds = Math.ceil((buildingTime - now) / 1000);
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
}