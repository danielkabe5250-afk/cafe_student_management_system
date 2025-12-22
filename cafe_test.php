<?php
require 'cafe_db.php';

echo "<h2>Testing Database Connection</h2>";

// Test database connection
try {
    echo "✅ Database connected successfully<br>";
    
    // Create table
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
    echo "✅ Table created successfully<br>";
    
    // Test insert
    $stmt = $pdo->prepare("INSERT IGNORE INTO students (student_id, name, email, phone, department, year_level) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(['TEST-001', 'Test Student', 'test@university.edu', '123-456-7890', 'Computer Science', '1st Year']);
    echo "✅ Test student inserted<br>";
    
    // Test select
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM students");
    $count = $stmt->fetch()['count'];
    echo "✅ Total students: $count<br>";
    
    echo "<br><a href='cafe_index.php'>Go to Cafe System</a>";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>