import Food from './Properties/Food';
import Gold from './Properties/Gold';
import Timings from './Properties/Timings';
import Upgrador from './Properties/Upgrador';
import Recruiter from './Properties/Recruiter';
import Expedition from './Expedition';

export default class Village {
    constructor() {
        this.id = this.getId();

        this.food = new Food();
        this.gold = new Gold();

        this.buildingTimings = new Timings('building');
        this.armyTimings = new Timings('army');

        this.upgrador = new Upgrador();
        this.recruiter = new Recruiter();
        
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
            this.armyTimings.set(res.data.village.army_timings);
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