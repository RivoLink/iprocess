<?php $token = trim(file_get_contents('private/token.txt')); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>iProcess | RivoLink</title>
    <meta name="description" content="OCR Image Processing."/>

    <meta property='og:title' content="iProcess"/>
    <meta property='og:description' content="OCR Image Processing." />

    <meta property='og:type' content="website"/>
    <meta property='og:site_name' content="iProcess"/>

    <link rel="canonical" href="https://iprocess.rivolink.mg"/>
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon"/>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" />

    <link rel="stylesheet" href="/assets/css/style.css"/>
</head>
<body data-theme="dark">
    <div class="presentation">
        <h1>OCR Image Processing</h1>
        <button class="theme-toggle">☀️ Light Mode</button>
    </div>
    <div class="upload-wrapper">
        <div class="notification-container" id="notification-container"></div>

        <div class="upload-container">
            <svg width="80px" height="80px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path 
                    stroke="#ebebeb" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                    d="M4.02693 18.329C4.18385 19.277 5.0075 20 6 20H18C19.1046 20 20 19.1046 20 18V14.1901M4.02693 18.329C4.00922 18.222 4 18.1121 4 18V6C4 4.89543 4.89543 4 6 4H18C19.1046 4 20 4.89543 20 6V14.1901M4.02693 18.329L7.84762 14.5083C8.52765 13.9133 9.52219 13.8482 10.274 14.3494L10.7832 14.6888C11.5078 15.1719 12.4619 15.1305 13.142 14.5865L15.7901 12.4679C16.4651 11.9279 17.4053 11.8856 18.1228 12.3484C18.2023 12.3997 18.2731 12.4632 18.34 12.5302L20 14.1901M11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9Z"
                />
            </svg>
            <h2>Drop, Upload or Paste Image</h2>
            <p>Supported formats: JPG, PNG / Max size: 1Mo</p>

            <div class="upload-buttons">
                <label for="file-upload" class="file-upload-btn">Browse</label>
                <input id="file-upload" type="file" accept=".jpeg,.jpg,.png">
                <button id="open-webcam-btn" type="button">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                        <path
                            stroke="#ebebeb" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            d="M21 13C21 10.3333 20.5 8 20 7.66667C19.6796 7.45303 18.1268 7.2394 16 7.11352C14.8083 7.04298 17 5 12 5C7 5 9.19168 7.04298 8 7.11352C5.87316 7.2394 4.32045 7.45303 4 7.66667C3.5 8 3 10.3333 3 13C3 15.6667 3.5 18 4 18.3333C4.5 18.6667 8 19 12 19C16 19 19.5 18.6667 20 18.3333C20.5 18 21 15.6667 21 13Z"
                        />
                        <path 
                            stroke="#ebebeb" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 16C13.6569 16 15 14.6569 15 13C15 11.3431 13.6569 10 12 10C10.3431 10 9 11.3431 9 13C9 14.6569 10.3431 16 12 16Z"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div id="card-container">
        <div id="card-template" class="card" style="display:none;">
            <div class="card-content">
                <div class="card-image">
                    <img src="/assets/img/logo.png" alt="Image"/>
                </div>
                <div class="card-infos">
                    <div class="dropdown">
                        <span class="dropdown-act dropdown-spn">Engine : </span>
                        <button class="dropdown-act dropdown-btn" data-value="tesseract">Tesseract</button>
                        <div class="dropdown-content">
                            <a href="#" data-value="tesseract">Tesseract</a>
                            <a href="#" data-value="paddleocr">Paddleocr</a>
                            <a href="#" data-value="mistral">Pixtral by Mistral</a>
                            <a href="#" data-value="google">Gemini by Google</a>
                        </div>
                        <span class="dropdown-act dropdown-icon">&#9998;</span>
                    </div>
                    <div class="description tesseract show">
                        Tesseract is an optical character recognition engine for various operating systems. 
                        It is free software, released under the Apache License. [Wikipedia]
                    </div>
                    <div class="description paddleocr">
                        PaddleOCR aims to create multilingual, awesome, leading, and practical OCR tools 
                        that help users train better models and apply them into practice. [PaddleOCR]
                    </div>
                    <div class="description mistral">
                        Pixtral is trained to understand both natural images and documents, 
                        achieving 52.5% on the MMMU reasoning benchmark, surpassing a number of larger models. [Mistral AI]
                    </div>
                    <div class="description google">
                        Gemini is an intelligent AI model, capable of reasoning through its thoughts before responding, 
                        resulting in enhanced performance and improved accuracy. [DeepMind]
                    </div>
                </div>
                <div class="card-controls">
                    <button class="run-btn">
                        <span class="icon show">
                            <svg width="16px" height="16px" viewBox="0 0 384 512">
                                <path fill="#ffffff" d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                            </svg>
                        </span>
                        <span class="loader"></span>
                    </button>
                </div>
            </div>
            <div class="card-footer">
                <div class="output collapsed">
                    <div class="output-toggle"></div>
                    <div class="output-text"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-image" class="modal">
        <div class="content">
            <div class="close">&times;</div>
            <img id="preview-img" src="/assets/img/logo.png" alt="Full Image">
            <div class="output expanded">
                <div class="output-toggle"></div>
                <div class="output-text"></div>
            </div>
        </div>
    </div>
    <div id="modal-webcam" class="modal">
        <div class="content webcam-content">
            <div class="video-container">
                <video id="webcam" autoplay playsinline></video>
            </div>
            <div class="webcam-preview" style="display:none;">
                <img id="captured-image" src="" alt="Captured"/>
            </div>
            <div class="webcam-buttons">
                <button id="webcam-cancel-btn" class="red">
                    <svg viewBox="0 0 330 330" fill="white" width="25px" height="25px">
                        <path d="M165,0C74.019,0,0,74.019,0,165s74.019,165,165,165c90.982,0,165-74.019,165-165S255.982,0,165,0z M165,300 c-74.439,0-135-60.561-135-135S90.561,30,165,30c74.439,0,135,60.561,135,135S239.439,300,165,300z"/>
                        <path d="M239.247,90.754c-5.857-5.858-15.355-5.858-21.213,0l-53.033,53.033l-53.033-53.033c-5.857-5.858-15.355-5.858-21.213,0 c-5.858,5.858-5.858,15.355,0,21.213L143.788,165l-53.033,53.033c-5.858,5.858-5.858,15.355,0,21.213 c2.929,2.929,6.768,4.394,10.606,4.394c3.839,0,7.678-1.464,10.606-4.394l53.033-53.033l53.033,53.033 c2.929,2.929,6.768,4.394,10.606,4.394c3.839,0,7.678-1.464,10.607-4.394c5.858-5.858,5.858-15.355,0-21.213L186.214,165 l53.033-53.033C245.105,106.109,245.105,96.612,239.247,90.754z"/>
                    </svg>
                </button>
                <button id="webcam-check-btn" class="green">
                    <svg viewBox="0 0 24 24" fill="none" width="31px" height="31px">
                        <path stroke="white" stroke-width="2" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"/>
                        <path stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12L10.6828 13.6828V13.6828C10.858 13.858 11.142 13.858 11.3172 13.6828V13.6828L15 10"/>
                    </svg>
                </button>
                <button id="webcam-retry-btn" class="blue hidden absolute">
                    <svg viewBox="0 0 16 16" width="21px" height="21px">
                        <path fill="white" d="M14.9547098,7.98576084 L15.0711,7.99552 C15.6179,8.07328 15.9981,8.57957 15.9204,9.12636 C15.6826,10.7983 14.9218,12.3522 13.747,13.5654 C12.5721,14.7785 11.0435,15.5888 9.37999,15.8801 C7.7165,16.1714 6.00349,15.9288 4.48631,15.187 C3.77335,14.8385 3.12082,14.3881 2.5472,13.8537 L1.70711,14.6938 C1.07714,15.3238 3.55271368e-15,14.8776 3.55271368e-15,13.9867 L3.55271368e-15,9.99998 L3.98673,9.99998 C4.87763,9.99998 5.3238,11.0771 4.69383,11.7071 L3.9626,12.4383 C4.38006,12.8181 4.85153,13.1394 5.36475,13.3903 C6.50264,13.9466 7.78739,14.1285 9.03501,13.9101 C10.2826,13.6916 11.4291,13.0839 12.3102,12.174 C13.1914,11.2641 13.762,10.0988 13.9403,8.84476 C14.0181,8.29798 14.5244,7.91776 15.0711,7.99552 L14.9547098,7.98576084 Z M11.5137,0.812976 C12.2279,1.16215 12.8814,1.61349 13.4558,2.14905 L14.2929,1.31193 C14.9229,0.681961 16,1.12813 16,2.01904 L16,6.00001 L12.019,6.00001 C11.1281,6.00001 10.6819,4.92287 11.3119,4.29291 L12.0404,3.56441 C11.6222,3.18346 11.1497,2.86125 10.6353,2.60973 C9.49736,2.05342 8.21261,1.87146 6.96499,2.08994 C5.71737,2.30841 4.57089,2.91611 3.68976,3.82599 C2.80862,4.73586 2.23802,5.90125 2.05969,7.15524 C1.98193,7.70202 1.47564,8.08224 0.928858,8.00448 C0.382075,7.92672 0.00185585,7.42043 0.0796146,6.87364 C0.31739,5.20166 1.07818,3.64782 2.25303,2.43465 C3.42788,1.22148 4.95652,0.411217 6.62001,0.119916 C8.2835,-0.171384 9.99651,0.0712178 11.5137,0.812976 Z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.rivolink.mg/fleet/1.1.2/fleet.min.js"></script>

    <script>
        window._token = '<?=$token?>';
    </script>

    <script src="/assets/js/script.js"></script>
</body>
</html>
