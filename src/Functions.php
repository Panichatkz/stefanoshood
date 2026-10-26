<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Simple environment loader if .env exists
if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
    $host = $env['DB_HOST'] ?? 'localhost';
    $data = $env['DB_NAME'] ?? 'stefanoshood';
    $user = $env['DB_USER'] ?? 'root';
    $pass = $env['DB_PASS'] ?? '';
} else {
    $host = 'localhost';
    $data = 'stefanoshood';
    $user = 'root';
    $pass = 'allblack***8';
}

$chrs = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";
$opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

function createTable($name, $query) {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query) {
    global $pdo;
    return $pdo->query($query);
}

function destroySession() {
    $_SESSION = array();
    if (session_id() != "" || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 259200, '/');
    }
    session_destroy();
}

function sanitizeString($var) {
    global $pdo;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $result = $pdo->quote($var);
    return str_replace("'", "", $result);
}

function showProfile($user) {
    global $pdo;
    if (file_exists("uploads/$user.jpg")) {
        echo "<img src='uploads/$user.jpg' style='float:left;'>";
    }

    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user = ?");
    $stmt->execute([$user]);

    if ($row = $stmt->fetch()) {
        echo stripslashes($row['text'])."<br style='clear:left;'><br>";
        return;
    }
    echo "<p>Nothing to see here, yet</p><br>";
}
?>