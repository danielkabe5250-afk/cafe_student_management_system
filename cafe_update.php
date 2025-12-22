<?php
require 'cafe_db.php';

// Create table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(20) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        department VARCHAR(50) NOT NULL,
        year_level ENUM('1st Year', '2nd Year', '3rd Year', '4th Year') NOT NULL,
        entry_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status ENUM('active', 'inactive') DEFAULT 'active'
    )");
} catch(PDOException $e) {
    die("Table creation failed: " . $e->getMessage());
}

$id = $_GET['id'] ?? 0;

// Get current student
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header('Location: cafe_retrieve.php?error=notfound');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $year_level = $_POST['year_level'];
    $status = $_POST['status'];
    
    try {
        $stmt = $pdo->prepare("UPDATE students SET student_id = ?, name = ?, email = ?, phone = ?, department = ?, year_level = ?, status = ? WHERE id = ?");
        $stmt->execute([$student_id, $name, $email, $phone, $department, $year_level, $status, $id]);
        header('Location: cafe_retrieve.php?msg=updated');
        exit;
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Student - Cafe Management</title>
    <link rel="stylesheet" href="cafe_style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✏️ Update Student</h1>
            <p>Edit student information - ID: <?= htmlspecialchars($student['student_id']) ?></p>
        </div>
        
        <div class="nav-buttons">
            <a href="cafe_index.php" class="btn btn-secondary">🏠 Home</a>
            <a href="cafe_retrieve.php" class="btn btn-primary">📋 View Students</a>
        </div>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Student ID:</label>
                        <input type="text" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Full Name:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Department:</label>
                        <select name="department" required>
                            <option value="Computer Science" <?= $student['department'] == 'Computer Science' ? 'selected' : '' ?>>Computer Science</option>
                            <option value="Engineering" <?= $student['department'] == 'Engineering' ? 'selected' : '' ?>>Engineering</option>
                            <option value="Business" <?= $student['department'] == 'Business' ? 'selected' : '' ?>>Business</option>
                            <option value="Medicine" <?= $student['department'] == 'Medicine' ? 'selected' : '' ?>>Medicine</option>
                            <option value="Arts" <?= $student['department'] == 'Arts' ? 'selected' : '' ?>>Arts</option>
                            <option value="Science" <?= $student['department'] == 'Science' ? 'selected' : '' ?>>Science</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Year Level:</label>
                        <select name="year_level" required>
                            <option value="1st Year" <?= $student['year_level'] == '1st Year' ? 'selected' : '' ?>>1st Year</option>
                            <option value="2nd Year" <?= $student['year_level'] == '2nd Year' ? 'selected' : '' ?>>2nd Year</option>
                            <option value="3rd Year" <?= $student['year_level'] == '3rd Year' ? 'selected' : '' ?>>3rd Year</option>
                            <option value="4th Year" <?= $student['year_level'] == '4th Year' ? 'selected' : '' ?>>4th Year</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="active" <?= $student['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $student['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Entry Time:</label>
                        <input type="text" value="<?= date('M j, Y g:i A', strtotime($student['entry_time'])) ?>" readonly style="background: #f8f9fa;">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-warning">💾 Update Student</button>
                    <a href="cafe_retrieve.php" class="btn btn-secondary">❌ Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>