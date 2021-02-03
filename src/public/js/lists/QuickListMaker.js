import {QuickListPosition} from "../templates/QuickListPosition.js";

export class QuickListMaker {
    constructor(count) {
        this.count = count;
    }

    addPosition(selector) {
        let position = new QuickListPosition(this.count);
        selector.before(position.show());
        this.count++;
    }
}