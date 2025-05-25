<?php
session_start();
include("connect.php");

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$course = $_GET['course'] ?? '';
$component = $_GET['component'] ?? '';
$gender = $_GET['gender'] ?? '';

$query = "
    SELECT s.*, u.firstName, u.lastName 
    FROM students s 
    JOIN users u ON s.userId = u.userId 
    WHERE 1
";

if (!empty($course)) {
    $query .= " AND s.course = '" . $conn->real_escape_string($course) . "'";
}
if (!empty($component)) {
    $query .= " AND s.component = '" . $conn->real_escape_string($component) . "'";
}
if (!empty($gender)) {
    $query .= " AND s.gender = '" . $conn->real_escape_string($gender) . "'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Filter Students</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .container {
            display: flex;
        }

        .sidebar {
  width: 20%; /* Fluid width instead of fixed */
  min-width: 200px; /* Prevent it from becoming too small */
  max-width: 250px; /* Optional: cap maximum width */
  background-color: #002244;
  color: #fff;
  padding: 20px;
  box-sizing: border-box;
  height: 100vh;
  float: left;
  
}

.sidebar h2 {
  font-size: 24px;
  margin-bottom: 20px;
}

.sidebar ul {
  list-style: none;
}

.sidebar ul li {
  margin: 35px 0;
}

.sidebar ul li a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
}

.sidebar ul li a:hover {
  text-decoration: underline;
}
/* Main content styling */
.main-content {
  flex-grow: 1;
  background-color: #f0f4f8;
  padding: 30px;
}

       .main-content header {
  margin-bottom: 20px;
}

/* Table styling */
table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
}

table th, table td {
  padding: 12px 15px;
  border: 1px solid #ccc;
  text-align: left;
}

table th {
  background-color: #e9ecef;
}

.btn {
  margin-right: 5px;
}


        form {
            margin-bottom: 20px;
            max-width: 400px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        select, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background-color: #eee;
        }

        .logout-form {
            margin-top: 30px;
        }

        .logout-form button {
            background: #e74c3c;
        }
    </style>
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
        <h2>Filter Enrolled Students</h2>

        <form method="GET">
            <select name="course">
                <option value="">Select Course</option>
                <option value="ICS" <?= $course === 'ICS' ? 'selected' : '' ?>>ICS</option>
                <option value="ITE" <?= $course === 'ITE' ? 'selected' : '' ?>>ITE</option>
                <option value="IBM" <?= $course === 'IBM' ? 'selected' : '' ?>>IBM</option>
            </select>

            <select name="component">
                <option value="">Select Component</option>
                <option value="ROTC" <?= $component === 'ROTC' ? 'selected' : '' ?>>ROTC</option>
                <option value="CWTS" <?= $component === 'CWTS' ? 'selected' : '' ?>>CWTS</option>
            </select>

            <select name="gender">
                <option value="">Select Gender</option>
                <option value="Male" <?= $gender === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $gender === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>

            <button type="submit">Filter</button>
        </form>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Component</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Religion</th>
                        <th>Birth Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) ?></td>
                            <td><?= htmlspecialchars($row['course']) ?></td>
                            <td><?= htmlspecialchars($row['yearLevel']) ?></td>
                            <td><?= htmlspecialchars($row['component']) ?></td>
                            <td><?= htmlspecialchars($row['gender']) ?></td>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td><?= htmlspecialchars($row['religion']) ?></td>
                            <td><?= htmlspecialchars($row['birthDate']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students found with the selected filters.</p>
        <?php endif; ?>
<!-- <a href="addstudent.php" style="
  display: inline-block; 
  margin-bottom: 10px; 
  padding: 10px 20px; 
  background-color: #4CAF50; 
  color: white; 
  text-decoration: none; 
  border-radius: 5px;
">+ Add Student</a> -->
       
    </main>
</div>

</body>
</html>
