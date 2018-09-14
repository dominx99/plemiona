import Food from './Properties/Food';
import Gold from './Properties/Gold';

export default class Village {
    constructor() {
        this.id = this.getId();

        this.food = new Food();
        this.gold = new Gold();
        
        this.bind();
    }

    bind() {
        setInterval(() => this.update(), 1000);
    }

    update() {
        this.getVillageData().then(res => {
            this.gold.set(res.data.village.gold);
            this.food.set(res.data.village.food);
        }).catch(e => {
            console.log(e);
        });
    }

    getVillageData() {
        return axios.post('/village', {
            id: this.id,
        });
    }

    getId() {
        return $('meta[name="village_id"]').attr('content');
    }
}