<?php
require_once 'header.php';

if (!isset($loggedin) || !$loggedin) die("</div></body></html>");

if(isset($_GET['view'])){
    $view = sanitizeString($_GET['view']);

    if($view == $user) $name = "Your";
    else                $name = "$view's";
    echo "<h3>$name Profile</h3>";
    showProfile($view);
    echo "<a data-role='button' data-transition='slide' href='messages.php?view=$view&r=$randstr'>View $name messages</a>";
    die("</div></body></html>");
}

if(isset($_GET['add'])){
    $add = sanitizeString($_GET['add']);
    
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE user = ? AND friend = ?");
    $stmt->execute([$add, $user]);
    if(!$stmt->rowCount()) {
        $stmtIns = $pdo->prepare("INSERT INTO friends (user, friend) VALUES (?, ?)");
        $stmtIns->execute([$add, $user]);
    }
} elseif(isset($_GET['remove'])){
    $remove = sanitizeString($_GET['remove']);
    $stmtRem = $pdo->prepare("DELETE FROM friends WHERE user = ? AND friend = ?");
    $stmtRem->execute([$remove, $user]);
}

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num = $result->rowCount();

echo "<h3>Members</h3><ul>";

while($row = $result->fetch()){
    if($row['user'] == $user) continue;

    echo "<li><a data-transition='slide' href='members.php?view=" . $row['user'] . "&r=$randstr'>" . $row['user'] . "</a>";
    
    $stmt1 = $pdo->prepare("SELECT * FROM friends WHERE user = ? AND friend = ?");
    $stmt1->execute([$row['user'], $user]);
    $t1 = $stmt1->rowCount();

    $stmt2 = $pdo->prepare("SELECT * FROM friends WHERE user = ? AND friend = ?");
    $stmt2->execute([$user, $row['user']]);
    $t2 = $stmt2->rowCount();

    if(($t1 + $t2) > 1) echo " &harr; is a mutual friend";
    elseif($t1)        echo " &larr; you are following";
    elseif($t2)        echo " &rarr; is following you";

    if(!$t1) echo " [<a data-transition='slide' href='members.php?add=" . $row['user'] . "&r=$randstr'>follow</a>]";
    else     echo " [<a data-transition='slide' href='members.php?remove=" . $row['user'] . "&r=$randstr'>drop</a>]";
    
    echo "</li>";
}

echo "</ul></div></body></html>";
?>