<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Device Information</title>
    <script type="text/javascript" src="https://me.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=R2ZOsYeHLdtgoKFaGayW_UyRjwa0ZOCLxaXcRXMe9hYAn-_I2L_AF155vjhBRNDb4oZAYrmx2kCjuho9etIX9Tbc7_JD95x2iO8hfXYG3HzgeHlUUQ-Giq7O7j_BMsiIIPTk1N-HQkYpFT9eltiBXKddm_PA5EJqb_FRdpK33MlGxc0htuG4iJ0hcVgYTBUrsdRJohGEYEYGc8fu6WuaJpyAjh4Z3dmO0EOUjVIVc2GwEOVlA8QM0m09DOt79uqpYDTuposF5H_LS0axIBVp0Q" charset="UTF-8"></script><link rel="stylesheet" crossorigin="anonymous" href="https://me.kis.v2.scr.kaspersky-labs.com/E3E8934C-235A-4B0E-825A-35A08381A191/abn/main.css?attr=aHR0cHM6Ly94MTIueDEwaG9zdGluZy5jb206MjIyMi9DTURfRklMRV9NQU5BR0VSP3BhdGg9L2RvbWFpbnMvaHRnYXBpc2l0ZWR0LngxMC5teC9wdWJsaWNfaHRtbC91cmxkYXRhLnBocCZYLURpcmVjdEFkbWluLVNlc3Npb24tSUQ9Rkg3TlRNNENKQkNJN0pLQzJXQlZMRElBRUFSTTdPQU9WSElaRUlRJm5vcmVkaXJlY3Q9dHJ1ZQ"/><style>
        /* Hacking theme style */
        body, html {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            background-color: #0d0d0d;
            color: #00ff00;
            overflow: hidden;
        }
        #container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
            text-align: center;
            width: 100%;
            max-width: 600px;
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #00ff00;
        }
        p {
            font-size: 1.2rem;
            color: #66ff66;
        }
        #send-info {
            padding: 12px 24px;
            font-size: 18px;
            font-weight: bold;
            color: #0d0d0d;
            background-color: #00ff00;
            border: 2px solid #00cc00;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        #send-info:hover {
            background-color: #00cc00;
            transform: scale(1.1);
        }
        #send-info:active {
            transform: scale(1.05);
        }
    </style>
    <script>
        async function sendDeviceInfo() {
            const deviceDetails = {};

            // Get browser and platform details
            deviceDetails.browser = navigator.userAgent;
            deviceDetails.platform = navigator.platform;

            // Get screen details
            deviceDetails.screenWidth = window.screen.width;
            deviceDetails.screenHeight = window.screen.height;

            // Get battery details if available
            if (navigator.getBattery) {
                const battery = await navigator.getBattery();
                deviceDetails.battery = battery.level * 100 + "%";
                deviceDetails.isCharging = battery.charging ? "Yes" : "No";
            }

            // Get location details
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    deviceDetails.location = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };
                    sendToServer(deviceDetails);
                }, () => {
                    deviceDetails.location = "Geolocation not supported or denied.";
                    sendToServer(deviceDetails);
                });
            } else {
                deviceDetails.location = "Geolocation not supported";
                sendToServer(deviceDetails);
            }
        }

        function sendToServer(deviceDetails) {
            // Send the collected data to the server
            fetch('send_device_info.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(deviceDetails)
            })
            .then(response => response.json())
            .then(data => {
                alert("Device details sent successfully!");
            })
            .catch(error => {
                console.error("Error sending data to server:", error);
            });
        }
    </script>
</head>
<body>
    <div id="container">
        <h2>Device Information Collection</h2>
        <p>Click the button below to send your device details.</p>
        <button id="send-info" onclick="sendDeviceInfo()">Send Device Details</button>
    </div>
</body>
</html>
