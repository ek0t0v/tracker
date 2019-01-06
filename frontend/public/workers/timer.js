onmessage = e => {
    switch (e.data.action) {
        case 'start':
            start();

            break;
        case 'stop':
            stop();

            break;
    }
};

function start() {
    let start = new Date().getTime();
    let time = 0;
    let elapsed = '0.0';

    function instance() {
        time += 100;

        elapsed = Math.floor(time / 100) / 10;

        if ((elapsed ^ 0) === elapsed) {
            postMessage(elapsed);
        }

        let diff = (new Date().getTime() - start) - time;

        setTimeout(instance, (100 - diff));
    }

    setTimeout(instance, 100);
}

function stop() {
    close();
}