export default class Event {
    constructor(componentEvent, eventsToEmit) {
        this.componentEvent = componentEvent;
        this.eventsToEmit = eventsToEmit;
    }
}