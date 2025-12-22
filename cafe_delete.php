<?php
require 'cafe_db.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
$stmt->execute([$id]);

header('Location: cafe_retrieve.php?msg=deleted');
?>