<?php
require_once 'functions.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action === 'get_messages') {
    $recipient = sanitizeString($_GET['view'] ?? '');
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE recip = ? ORDER BY time DESC");
    $stmt->execute([$recipient]);
    echo json_encode($stmt->fetchAll());
    exit;
}

if ($action === 'post_message' && isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $recip = sanitizeString($_POST['recip'] ?? $user);
    $text = sanitizeString($_POST['text'] ?? '');
    $pm = substr(sanitizeString($_POST['pm'] ?? '0'), 0, 1);
    
    if (!empty($text)) {
        $time = time();
        $stmt = $pdo->prepare("INSERT INTO messages (auth, recip, pm, time, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user, $recip, $pm, $time, $text]);
        echo json_encode(['status' => 'success']);
        exit;
    }
    echo json_encode(['status' => 'error', 'message' => 'Empty message']);
    exit;
}