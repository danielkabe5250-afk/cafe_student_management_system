<?php
require 'cafe_db.php';

$id = $_GET['id'] ?? 0;

// Get student data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header('Location: cafe_retrieve.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Student Details</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .info { background: #f9f9f9; padding: 20px; border-radius: 5px; margin: 10px 0; }
        .btn { padding: 10px 20px; background: gray; color: white; text-decoration: none; margin: 5px; }
        .btn-blue { background: blue; }
        .btn-orange { background: orange; }
    </style>
</head>
<body>
    <h1>Student Details</h1>
    
    <div class="info">
        <h3>Student Information</h3>
        <p><strong>ID:</strong> <?= $student['id'] ?></p>
        <p><strong>Student ID:</strong> <?= $student['student_id'] ?></p>
        <p><strong>Name:</strong> <?= $student['name'] ?></p>
        <p><strong>Email:</strong> <?= $student['email'] ?></p>
        <p><strong>Phone:</strong> <?= $student['phone'] ?></p>
        <p><strong>Department:</strong> <?= $student['department'] ?></p>
        <p><strong>Year Level:</strong> <?= $student['year_level'] ?></p>
        <p><strong>Entry Time:</strong> <?= $student['entry_time'] ?></p>
        <p><strong>Status:</strong> <?= $student['status'] ?></p>
    </div>
    
    <a href="cafe_retrieve.php" class="btn">Back to List</a>
    <a href="cafe_update.php?id=<?= $student['id'] ?>" class="btn btn-orange">Update This Student</a>
    <a href="cafe_index.php" class="btn btn-blue">Home</a>
</body>
</html>