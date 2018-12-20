const httpRetryQueue = {
    queue: [],
    onItemAddedCallbacks: [],
    push(retryItem) {
        this.queue.push(retryItem);
        this.onItemAddedCallbacks.forEach(callback => callback(retryItem));
    },
    pushRetryFn({ reason, retryFn }) {
        return new Promise((resolve, reject) => {
            const retryItem = {
                reason,
                retry() {
                    return Promise.resolve(retryFn())
                        .then((value) => resolve(value), (value) => reject(value))
                },
                cancel() {
                    return reject()
                },
            };

            this.push(retryItem);
        });
    },
    hasRequestsInQueue() {
        return this.queue.length > 0;
    },
    retryAll() {
        return new Promise(resolve => {
            while (this.hasRequestsInQueue()) {
                this.queue.shift().retry();
            }

            resolve();
        });
    },
    cancelAll() {
        while (this.hasRequestsInQueue()) {
            this.queue.shift().cancel();
        }
    },
    clearAll () {
        this.queue = [];
    },
};

export default httpRetryQueue;