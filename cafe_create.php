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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $year_level = $_POST['year_level'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO students (student_id, name, email, phone, department, year_level) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$student_id, $name, $email, $phone, $department, $year_level]);
        header('Location: cafe_retrieve.php?msg=created');
        exit;
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Student - Cafe Management</title>
    <link rel="stylesheet" href="cafe_style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>➕ Add New Student</h1>
            <p>Register a new student entry to the cafe</p>
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
                        <input type="text" name="student_id" placeholder="e.g., 2024-001" required>
                    </div>
                    <div class="form-group">
                        <label>Full Name:</label>
                        <input type="text" name="name" placeholder="Enter full name" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" placeholder="student@university.edu" required>
                    </div>
                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" name="phone" placeholder="123-456-7890" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Department:</label>
                        <select name="department" required>
                            <option value="">Select Department</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Business">Business</option>
                            <option value="Medicine">Medicine</option>
                            <option value="Arts">Arts</option>
                            <option value="Science">Science</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Year Level:</label>
                        <select name="year_level" required>
                            <option value="">Select Year</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">✅ Add Student</button>
                    <a href="cafe_retrieve.php" class="btn btn-secondary">❌ Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>