export default class Upgrador {
    constructor() {
        this.buttons = '.upgrade-building'

        this.bind()
    }

    bind() {        
        $('body').on('click', this.buttons, this.upgradeBuilding)
    }

    upgradeBuilding() {
        let buildingId = $(this).data('building-id')
        let villageId = $(this).data('village-id')

        axios.post('/upgrade/building', {
            village_id: villageId,
            building_id: buildingId,
        }).then(res => {
            if (res.data.error) {
                console.log(res.data.error);
                village.alert.set(res.data.error, 'danger');
                return;
            }

            window.village.update();
        }).catch(res => {
            console.log(res)
        })
    }
}