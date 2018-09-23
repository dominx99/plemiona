export default class Fortress {
    set(buildings) {
        buildings.map(building => {
            this.buildRow(building);
        });
    }

    buildRow(building) {
        let row = $('#building_' + building.id);

        let level = building.pivot.building_level;
        let cost = building.cost_upgrade;
        let time = building.time;

        $(row).find('.level').text(level);
        $(row).find('.cost').text(cost);
        $(row).find('.time').text(time);

        let requirementsEl = $(row).find('.requirements');
        let els = this.buildRequirements(building.requirements_by_level);
        requirementsEl.html(els);
    }

    buildRequirements(requirements) {
        let els = [];

        requirements.map(requirement => {
            let el = $('<p></p>');
            el.addClass('secondary small my-2');

            el.text(requirement.building.name + ' ' + requirement.building_cost.level);
            els.push(el);
        });

        return els;
    }
}