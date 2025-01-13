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
                </div>
                <div class="card-controls">
                    <button class="run-btn">
                        <span class="icon show">&#9658;</span>
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
                <div class="output-text">
                    PaddleOCR aims to create multilingual, awesome, leading, and practical OCR tools 
                    that help users train better models and apply them into practice. [PaddleOCR]
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.rivolink.mg/fleet/1.0.0/fleet.min.js"></script>

    <script>
        window._token = '<?=$token?>';
    </script>

    <script src="/assets/js/script.js"></script>
</body>
</html>
