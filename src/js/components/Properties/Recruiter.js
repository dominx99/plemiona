export default class Recruiter {
    constructor() {
        this.buttons = '.recruit-button'
        this.inputs = '.recruitment input'

        this.bind()
    }

    bind() {
        $('body').on('click', this.buttons, this.recruit)
        $('body').on('change keyup', this.inputs, e => this.calculate(e));
    }

    recruit() {
        let armyId = $(this).data('army-id')
        let villageId = $(this).data('village-id')
        let amount = $('#input-' + armyId).val();

        axios.post('/recruit', {
            village_id: villageId,
            army_id: armyId,
            amount: amount,
        }).then(res => {
            if (res.data.error) {
                console.log(res.data.error);
                alert(res.data.error);
                return;
            }

            window.village.update();
        }).catch(res => {
            console.log(res)
        })
    }

    calculate(e) {
        let that = $(e.target);
        let armyId = parseInt(that.data('army-id'));
        let cost = parseInt(that.data('cost'));
        let time = parseInt(that.data('time'));
        let amount = that.val();

        $('#army-cost-' + armyId).text(cost * amount);
        $('#army-time-' + armyId).text(time * amount);
    }
}