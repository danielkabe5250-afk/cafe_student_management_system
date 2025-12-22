<?php
require 'cafe_db.php';

// Create table
$pdo->exec("CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    department VARCHAR(50) NOT NULL,
    year_level VARCHAR(20) NOT NULL,
    entry_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'active'
)");

// Get all students
$stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Students</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1400px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h1 { color: #333; text-align: center; }
        .top-buttons { text-align: center; margin-bottom: 20px; }
        .alert { padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background: #007bff; 
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) { background: #f8f9fa; }
        tr:hover { background: #e9ecef; }
        
        .btn { 
            padding: 8px 15px; 
            margin: 2px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            min-width: 70px;
        }
        .btn-success { background: #28a745; color: white; }
        .btn-primary { background: #007bff; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        
        .actions-cell {
            width: 250px;
            text-align: center;
            vertical-align: middle;
            padding: 15px 5px;
        }
        
        .action-buttons-horizontal {
            line-height: 2.5;
        }
        
        .btn-small {
            padding: 6px 10px;
            margin: 3px 0;
            font-size: 11px;
            display: inline-block;
            width: 90px;
            text-align: center;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 All Students</h1>
        
        <div class="top-buttons">
            <a href="cafe_create.php" class="btn btn-success">➕ Add New Student</a>
            <a href="cafe_index.php" class="btn btn-secondary">🏠 Home</a>
        </div>
        
        <?php if(isset($_GET['msg'])): ?>
            <div class="alert">
                ✅ Student <?= htmlspecialchars($_GET['msg']) ?> successfully!
            </div>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Entry Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($students)): ?>
                    <tr>
                        <td colspan="9" class="no-data">
                            No students found. <a href="cafe_create.php">Add the first student</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($students as $student): ?>
                    <tr>
                        <td><?= $student['id'] ?></td>
                        <td><strong><?= htmlspecialchars($student['student_id']) ?></strong></td>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= htmlspecialchars($student['phone']) ?></td>
                        <td><?= htmlspecialchars($student['department']) ?></td>
                        <td><?= htmlspecialchars($student['year_level']) ?></td>
                        <td><?= date('M j, Y g:i A', strtotime($student['entry_time'])) ?></td>
                        <td class="actions-cell">
                            <div class="action-buttons-horizontal">
                                <a href="cafe_view.php?id=<?= $student['id'] ?>" class="btn btn-primary btn-small">📄 Retrieve</a><br>
                                <a href="cafe_update.php?id=<?= $student['id'] ?>" class="btn btn-warning btn-small">✏️ Update</a><br>
                                <a href="cafe_delete.php?id=<?= $student['id'] ?>" class="btn btn-danger btn-small" 
                                   onclick="return confirm('Are you sure you want to delete this student?')">🗑️ Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>