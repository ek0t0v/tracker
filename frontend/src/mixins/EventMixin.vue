<script>
    const EventMixin = {
        methods: {
            emitEventsByComponentEvent(componentEvent, payload) {
                let currentEvent = this.events.filter(e => {
                    return e.componentEvent === componentEvent;
                });

                currentEvent[0].eventsToEmit.forEach(e => {
                    this.$bus.emit(e, payload);
                });
            }
        },
    };

    export default EventMixin;
</script>