    <?php
    session_start();
    include("connect.php");

    // Handle delete
    if (isset($_GET['delete'])) {
        $studentId = (int)$_GET['delete'];

        $stmt = $conn->prepare("DELETE FROM students WHERE studentId = ?");
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        $stmt->close();

        header("Location: enrollments.php?deleted=1");
        exit();
    }

    // Fetch students
    $students = $conn->query("
    SELECT s.*, u.firstName, u.lastName 
    FROM students s 
    INNER JOIN users u ON s.userId = u.userId
    ");
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Enrolled Students Dashboard</title>
    <link rel="stylesheet" href="adminstyle.css">
    </head>
    <body>
    <div class="container">
        <aside class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
        <li><a href="enrollments.php">Enrollments</a></li>
        <li><a href="students.php">Students</a></li>
        <li><a href="reports.php">Reports</a></li>
        <li><a href="logout.php">Log Out</a></li>
        </ul>
        </aside>

        <main class="main-content">
        <header><h1>Enrolled Students</h1></header>

        <?php if (isset($_GET['deleted'])): ?>
            <p style="color: red;">Student record deleted.</p>
        <?php elseif (isset($_GET['updated'])): ?>
            <p style="color: green;">Student record updated successfully.</p>
        <?php endif; ?>

        <table class="students-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Component</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Birth Date</th>
                <th>Religion</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while($row = $students->fetch_assoc()): ?>
                <tr>
                <td><?= $row['studentId'] ?></td>
                <td><?= htmlspecialchars($row['firstName']) ?></td>
                <td><?= htmlspecialchars($row['lastName']) ?></td>
                <td><?= htmlspecialchars($row['course']) ?></td>
                <td><?= htmlspecialchars($row['yearLevel']) ?></td>
                <td><?= htmlspecialchars($row['component']) ?></td>
                <td><?= htmlspecialchars($row['gender']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['birthDate']) ?></td>
                <td><?= htmlspecialchars($row['religion']) ?></td>
                <td>
                    <a href="editstudent.php?id=<?= $row['studentId'] ?>">Edit</a>
                    <a href="enrollments.php?delete=<?= $row['studentId'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </main>
    </div>
    </body>
    </html>
