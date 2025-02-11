/* global fleet */ // eslint config

document.addEventListener('DOMContentLoaded', () => {
    fleet.global = {};

    const isLight = (localStorage.getItem('iprocess-theme') == 'light');
    
    fleet.setData(document.body, {theme: isLight ? 'light' : 'dark'});
    fleet.setText('.theme-toggle', isLight ? '🌙 Dark Mode' : '☀️ Light Mode');

    fleet.select('.theme-toggle').addEventListener('click', (e) => {
        const isDark = (fleet.getData(document.body, 'theme') === 'dark');
    
        fleet.setData(document.body, {theme: isDark ? 'light' : 'dark'});
        fleet.setText(e.target, isDark ? '🌙 Dark Mode' : '☀️ Light Mode');
        
        localStorage.setItem('iprocess-theme', isDark ? 'light' : 'dark');
    });
    
    fleet.find('modal-image').addEventListener('click', (e) => {
        const close = () => {
            fleet.removeClass('#modal-image', 'show');
            fleet.setAttr('#preview-img', {src: ''});
        };
    
        if (e.target === fleet.find('modal-image')) {
            close();
        } else if (fleet.hasClass(e.target, 'close')) {
            close();
        }
    });
    
    fleet.select('.upload-container').addEventListener('drop', (e) => {
        handleFiles(Array.from(e.dataTransfer.files));
    });
    
    fleet.find('file-upload').addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    Array.from(['dragenter', 'dragover', 'dragleave', 'drop']).forEach(event => {
        fleet.addEvent('.upload-container', event, e => e.preventDefault());
        fleet.addEvent('.upload-container', event, e => e.stopPropagation());
    });

    fleet.find('open-webcam-btn').addEventListener('click', () => {
        startWebcam();
    });

    fleet.find('webcam-cancel-btn').addEventListener('click', () => {
        closeWebcamModal();
    });

    fleet.find('webcam-check-btn').addEventListener('click', () => {
        var retryBtn = fleet.find('webcam-retry-btn');

        const captureImage = () => {
            const webcam = fleet.find('webcam');
            const canvas = fleet.create('canvas');

            canvas.width = webcam.videoWidth;
            canvas.height = webcam.videoHeight;
            canvas.getContext('2d').drawImage(webcam, 0, 0, canvas.width, canvas.height);

            fleet.find('captured-image').src = canvas.toDataURL('image/png');

            fleet.setCSS('.webcam-preview', {display: 'flex'});
            fleet.setCSS('.video-container', {display: 'none'});
        };

        const saveImage = () => {
            const base64 = fleet.getAttr('#captured-image', 'src');
            const file = base64ToFile(base64, 'webcam.png');

            closeWebcamModal();
            handleFiles([file]);
        };

        if (fleet.hasClass(retryBtn, 'hidden')) {
            captureImage();

            fleet.removeClass(retryBtn, 'absolute');
            fleet.removeClass(retryBtn, 'hidden');
            fleet.addClass(retryBtn, 'visible');
        } else {
            saveImage();
        }

        stopWebcam();
    });

    fleet.find('webcam-retry-btn').addEventListener('click', () => {
        var retryBtn = fleet.find('webcam-retry-btn');

        if (!fleet.hasClass(retryBtn, 'hidden')) {
            fleet.removeClass(retryBtn, 'visible');
            fleet.addClass(retryBtn, 'hidden');
            setTimeout(() => fleet.addClass(retryBtn, 'absolute'), 200);
        }

        startWebcam();
    });
});

document.addEventListener('paste', (e) => {
    const files = Array.from(e.clipboardData.items)
        .filter(item => item.kind === 'file')
        .map(item => item.getAsFile());

    handleFiles(files);
});

function showNotif(type, message) {
    const notif = fleet.create('div');

    fleet.setText(notif, message);
    fleet.addClass(notif, ['notification', 'show', type]);

    if (window.innerWidth <= 800) {
        fleet.append('#notification-container', notif);
    } else {
        fleet.prepend('#notification-container', notif);
    }

    setTimeout(() => {
        notif.classList.remove('show');
        setTimeout(() => notif.remove(), 500);
    }, 3500);
}

function handleFiles(files = []) {
    const hasValidType = (file) => {
        const validTypes = ['image/jpeg', 'image/png'];
        return file && validTypes.includes(file.type);
    };

    const hasValidSize = (file) => {
        const maxSize = 1 * 1024 * 1024;
        return file && (file.size <= maxSize);
    };

    if (hasValidType(files[0]) && hasValidSize(files[0])) {
        const reader = new FileReader();
        reader.onload = () => {
            const newCard = fleet.create('div');

            fleet.addClass(newCard, 'card');
            fleet.setCSS(newCard, {'z-index': fleet.count('.card')});
            fleet.setHTML(newCard, fleet.getHTML('#card-template'));
            fleet.setAttr(fleet.child(newCard, 'img'), {src: reader.result});
            fleet.prepend('#card-container', newCard);

            setupEvents(newCard);
        };
        reader.readAsDataURL(files[0]);
    }
    else if(!hasValidType(files[0])) {
        showNotif('error', 'Error: Image type is note valid.');
    }
    else if(!hasValidSize(files[0])) {
        showNotif('error', 'Error: Image size exceeds limit.');
    }
}

function setupEvents(card) {
    dropdownEngineEvent(card);
    toggleOutputEvent(card);
    previewImageEvent(card);
    runProcessEvent(card);
}

function dropdownEngineEvent(parent) {
    const card = fleet.init(parent);

    const dropdownBtn = card.select('.dropdown-btn');
    const dropdownContent = card.select('.dropdown-content');

    card.addEvent('.dropdown-act', 'click', () => {
        card.toggleClass(dropdownContent, 'show');
    });

    card.addEvent('.dropdown-content a', 'click', (e) => {
        e.preventDefault();

        const engine = card.getData(e.target, 'value');
        card.setData(dropdownBtn, {value: engine});
        card.setText(dropdownBtn, card.getText(e.target));
        card.removeClass(dropdownContent, 'show');

        card.removeClass('.description', 'show');
        card.addClass('.description.'+engine, 'show');
    });
}

function toggleOutputEvent(parent) {
    const card = fleet.init(parent);

    card.addEvent('.output-toggle', 'click', () => {
        const output = card.select('.output');
        const isExpanded = card.hasClass(output, 'expanded');

        card.removeClass(output, 'collapsed');
        card.toggleClass(output, 'collapsing', isExpanded);
        card.toggleClass(output, 'expanded', !isExpanded);

        if (isExpanded) {
            setTimeout(() => {
                card.removeClass(output, 'collapsing');
                card.addClass(output, 'collapsed');
            }, 300);
        }
    });
}

function previewImageEvent(parent) {
    const card = fleet.init(parent);
    const modal = fleet.init('#modal-image');

    card.addEvent('img', 'click', (e) => {
        const show = card.hasClass('.output', 'show');
        const output = card.getHTML('.output');

        modal.addClass('.output', 'collapsed');
        modal.removeClass('.output', 'expanded');

        modal.setHTML('.output', output);
        modal.toggleClass('.output', 'show', show);

        fleet.setAttr('#preview-img', {src: e.target.src});
        fleet.addClass('#modal-image', 'show');

        toggleOutputEvent(fleet.find('modal-image'));
    });
}

function runProcessEvent(parent) {
    const card = fleet.init(parent);

    card.addEvent('.run-btn', 'click', () => {
        toggleLoader(true);

        const url = 'https://api.rivolink.mg/api/image/ocr/v1/process';
        const data = {
            base64: card.getAttr('img', 'src'),
            engine: card.getData('.dropdown-btn', 'value'),
        };

        fleet.ajaxPost(url, window._token, data, onSuccess, onError);
    });

    const onSuccess = (result = {}, params = {}) => {
        if (result.process_id) {
            checkOutput(result.process_id, params);
        } else {
            toggleLoader(false);
            showError(result.message, params);
        }
    };

    const checkOutput = (process_id, params, maxLoops = 10, currLoop = 1) => setTimeout(() => {
        const url = 'https://api.rivolink.mg/api/image/ocr/v1/check/' + process_id;

        fleet.ajaxGet(url, window._token, (result = {}) => {
            if (result.code == 'PENDING') {
                if (currLoop < maxLoops) {
                    checkOutput(process_id, params, maxLoops, currLoop + 1);
                } else {
                    onError(params);
                }
            } else if (result.code == 'SUCCESS') {
                toggleLoader(false);
                showOutput(result.output, params);
            } else {
                toggleLoader(false);
                showError(result.message, params);
            }
        }, onError);
    }, 1000 + 500 * currLoop);

    const getEngineName = (code) => {
        return fleet.getText(`[data-value='${code}']`);
    };

    const onError = (params) => {
        toggleLoader(false);
        showError(null, params);
    };

    const toggleLoader = (show) => {
        if (show) {
            card.removeClass('span', 'show');
            card.addClass('span.loader', 'show');
        } else {
            card.removeClass('span', 'show');
            card.addClass('span.icon', 'show');
        }
    };

    const showOutput = (output, params = {}) => {
        const html = card.getHTML('.output-text');
        const span = card.$tag('span', '', output || '--');

        const engineName = getEngineName(params.engine);
        const engineSpan = card.$tag('span', 'engine', `[${engineName}] `);

        if (html) {
            card.setHTML('.output-text', `${engineSpan}${span}<hr>${html}`);
            card.addClass('.output-text', 'multiple');
        } else {
            card.setHTML('.output-text', `${engineSpan}${span}`);
            card.addClass('.output', 'show');
        }
    };

    const showError = (error, params = {}) => {
        const html = card.getHTML('.output-text');
        const span = card.$tag('span', 'error', error || 'An error occured, please try again.');

        const engineName = getEngineName(params.engine);
        const engineSpan = card.$tag('span', 'engine', `[${engineName}] `);

        if (html) {
            card.setHTML('.output-text', `${engineSpan}${span}<hr>${html}`);
            card.addClass('.output-text', 'multiple');
        } else {
            card.setHTML('.output-text', `${engineSpan}${span}`);
            card.addClass('.output', 'show');
        }
    };
}

function saveWebcamSize() {
    if (fleet.global.savedSize) {
        return;
    }

    fleet.global.savedSize = true;

    const rect = fleet
        .select('.webcam-content video')
        .getBoundingClientRect();

    fleet.setCSS('.webcam-content', {
        width: rect.width + 'px',
        height: rect.height + 'px',
    });
}

function startWebcam() {
    navigator.mediaDevices.getUserMedia({
        video: {facingMode: {exact: 'environment'}}
    }).catch(() => {
        return navigator.mediaDevices.getUserMedia({video: true});
    }).then((stream) => {
        fleet.global.stream = stream;

        fleet.setCSS('.webcam-preview', {display: 'none'});
        fleet.setCSS('.video-container', {display: 'flex'});

        fleet.find('webcam').srcObject = stream;
        fleet.addClass('#modal-webcam', 'show');

        setTimeout(saveWebcamSize, 500);
    }).catch(() => {
        showNotif('error', 'Error: Webcam authorization failed.');
    });
}

function stopWebcam() {
    if (fleet.global.stream) {
        fleet.global.stream
            .getTracks()
            .forEach(track => track.stop());
    }

    fleet.global.stream = null;
    fleet.find('webcam').srcObject = null;
}

function closeWebcamModal() {
    fleet.removeClass('#modal-webcam', 'show');
    fleet.removeClass('#webcam-retry-btn', 'visible');

    fleet.addClass('#webcam-retry-btn', 'hidden');
    fleet.addClass('#webcam-retry-btn', 'absolute');

    stopWebcam();
}

function base64ToFile(base64, fileName) {
    const [metadata, data] = base64.split(',');
    const contentType = metadata.match(/:(.*?);/)[1];
    const binaryData = atob(data);

    const arrayBuffer = new Uint8Array(binaryData.length);
    for (var i = 0; i < binaryData.length; i++) {
        arrayBuffer[i] = binaryData.charCodeAt(i);
    }

    return new File([arrayBuffer], fileName, {type: contentType});
}
