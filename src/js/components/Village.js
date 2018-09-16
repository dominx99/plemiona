import Food from './Properties/Food';
import Gold from './Properties/Gold';
import BuildingTimings from './Properties/BuildingTimings';
import Upgrador from './Properties/Upgrador';

export default class Village {
    constructor() {
        this.id = this.getId();

        this.food = new Food();
        this.gold = new Gold();
        this.buildingTimings = new BuildingTimings();
        this.upgrador = new Upgrador();
        
        this.bind();
    }

    bind() {
        this.update();

        setInterval(() => this.update(), 5000);
    }

    update() {
        this.clearIntervals();

        this.getVillageData().then(res => {
            this.gold.set(res.data.village.gold);
            this.food.set(res.data.village.food);
            this.buildingTimings.set(res.data.village.building_timings);
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

    clearIntervals() {
        for (let i = 0; i < window.intervals.length; i++) {
            clearInterval(intervals[i]);
        }
    }
}