export default class Expedition {
    constructor() {
        this.attackButtons = '.attackVillage';
        this.activeVillage = '.active-village';

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
                alert(res.data.error);
            }
        }).catch(e => {
            console.log(e);
        });
    }

    update() {
        axios.post('/user/expeditions').then(res => {
            if (res.data.error) {
                console.log(res.data.error);
                alert(res.data.error);
            }

            this.buildVillages(res.data);
        });
    }

    buildVillages(data) {
        data.user.villages.forEach((village, index) => {
            this.buildVillage(village);
        });
    }
}