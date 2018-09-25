import Alert from './Alert';

export default class Expedition {
    constructor() {
        this.attackButtons = '.attackVillage';
        this.activeVillage = '.active-village';
        
        this.alert = new Alert();

        this.bind();
    }

    bind() {
        $('body').on('click', this.attackButtons, (e) => this.startExpedition(e));

        this.update();
    }

    startExpedition(e) {
        let that = $(e.target);
        let receiver = that.data('receiver');
        let type = that.data('type');

        let activeVillage = $(this.activeVillage);
        let sender = activeVillage.data('sender');
        
        let inputs = $(this.activeVillage + ' .army-amount');
        let armies = {};

        inputs.map((index, army) => {
            let id = $(army).data('army');
            let amount = $(army).val();

            armies[id] = amount;
        });

        axios.post('/expedition', {
            receiver_id: receiver,
            sender_id: sender,
            type: type,
            armies: armies,
        }).then(res => {
            if (res.data.error) {
                console.log(res.data.error);
                this.alert.set(res.data.error, 'danger');
            }

            this.update();
        }).catch(e => {
            console.log(e);
        });
    }

    update() {
        axios.post('/user/expeditions').then(res => {
            if (res.data.error) {
                console.log(res.data.error);
                this.alert.set(res.data.error, 'danger');
            }

            this.buildVillages(res.data);
            this.updateArmy(res.data.user.villages);
        });
    }

    buildVillages(data) {
        data.user.villages.map((village) => {
            this.buildVillage(village);
        });
    }

    buildVillage(village) {
        let timings = $('.sidebar #village_' + village.id);
        let expeditions = this.buildExpeditions(village.expeditions);

        timings.html(expeditions);
    }

    buildExpeditions(expeditions) {
        let timings = [];

        expeditions.map(expedition => {
            let timing = $('<timing class="timing"></timing>');
            let name = $('<div class="name"></div>').text(expedition.receiver.name);
            let destination = $('<div class="destination"></div>').text(expedition.destination);

            let reachAt = new Date(Date.parse(expedition.reach_at)).toLocaleTimeString('pl-PL');
            let time = $('<div class="time"></div>').text(reachAt);

            name.append(destination);

            timing.append(name);
            timing.append(time);
            timings.push(timing);
        });

        return timings;
    }

    updateArmy(villages) {
        villages.map(village => {
            village.armies.map(army => {
                $('#village_' + village.id + ' ' + '#army_' + army.id).text(army.pivot.amount);
                console.log(army.pivot.amount, '#village_' + village.id + ' ' + '#army_' + army.id);
            });
        });
    }
}