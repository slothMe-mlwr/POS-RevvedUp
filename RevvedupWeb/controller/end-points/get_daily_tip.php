<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db   = 'revvedupDB';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get total tips
    $stmt = $pdo->query("SELECT COUNT(*) AS count FROM daily_tips");
    $totalTips = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

    if ($totalTips > 0) {
        // Calculate tip index based on day of year
        $dayOfYear = date('z'); // 0–365
        $tipIndex = $dayOfYear % $totalTips;

        // Fetch tip at calculated index
        $stmt = $pdo->prepare("SELECT tip_text FROM daily_tips LIMIT 1 OFFSET ?");
        $stmt->bindValue(1, $tipIndex, PDO::PARAM_INT);
        $stmt->execute();
        $tip = $stmt->fetchColumn();

        echo json_encode(['success' => true, 'tip' => $tip]);
    } else {
        echo json_encode(['success' => false, 'tip' => 'No tips available']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'tip' => 'Database error: ' . $e->getMessage()]);
}
?>
