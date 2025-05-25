<?php
session_start();
include("connect.php");

if (!isset($_GET['id'])) {
    header("Location: enrollments.php");
    exit();
}

$studentId = $_GET['id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course = $_POST['course'];
    $yearLevel = $_POST['yearLevel'];
    $component = $_POST['component'];
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("UPDATE students SET course=?, yearLevel=?, component=?, gender=? WHERE studentId=?");
    $stmt->bind_param("ssssi", $course, $yearLevel, $component, $gender, $studentId);
    $stmt->execute();
    $stmt->close();

    header("Location: enrollments.php?updated=1");
    exit();
}

// Fetch current student data
$stmt = $conn->prepare("SELECT s.*, u.firstName, u.lastName FROM students s INNER JOIN users u ON s.userId = u.userId WHERE s.studentId = ?");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Student</title>
  <style>
    body, html {
  margin: 0; 
  padding: 0;
  font-family: Arial, sans-serif;
  height: 100vh;
  background-color: #f4f4f4;
}

.container {
  display: flex;
  height: 100vh;
}

.sidebar {
  width: 220px;
  background-color: #002244;
  color: #fff;
  padding: 20px;
  box-sizing: border-box;
}

.sidebar h2 {
  font-size: 24px;
  margin-bottom: 20px;
  font-weight: bold;
}

.sidebar ul {
  list-style: none;
  padding-left: 0;
}

.sidebar ul li {
  margin: 30px 0;
}

.sidebar ul li a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  display: block;
}

.sidebar ul li a:hover {
  text-decoration: underline;
}

.main-content {
  flex-grow: 1;
  background-color: #f0f4f8;

  display: flex;
  flex-direction: column;
  justify-content: center;  /* vertical centering */
  align-items: center;      /* horizontal centering */

  padding: 0 50px;
  box-sizing: border-box;
  height: 100vh;
}

h1 {
  color: #002244;
  font-weight: 700;
  margin-bottom: 40px;
  text-align: center;
  width: 100%;
  max-width: 480px;
}

form {
  background: white;
  width: 100%;
  max-width: 480px;
  padding: 30px 30px 40px 30px;
  border-radius: 8px;
  box-shadow: 0 0 12px rgba(0,0,0,0.1);
  box-sizing: border-box;
}

/* Form inputs */
label {
  display: block;
  margin-bottom: 6px;
  font-weight: 600;
  color: #002244;
}

input[type="text"],
input[type="date"],
select {
  width: 100%;
  padding: 10px 12px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 15px;
  box-sizing: border-box;
  transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="date"]:focus,
select:focus {
  border-color: #002244;
  outline: none;
}

button {
  background-color: #002244;
  color: white;
  font-weight: 600;
  border: none;
  padding: 12px 25px;
  cursor: pointer;
  border-radius: 6px;
  font-size: 16px;
  margin-right: 10px;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #014e7a;
}

a.cancel-link {
  color: #002244;
  font-weight: 600;
  text-decoration: none;
  font-size: 16px;
  line-height: 36px;
}

a.cancel-link:hover {
  text-decoration: underline;
}

p.student-name {
  font-size: 18px;
  margin-bottom: 20px;
  font-weight: 600;
  color: #333;
}

  </style>
</head>
<body>
  <div class="container">
    

    <main class="main-content">
      <h2>Edit Student</h2>

      <form method="POST">
  <p class="student-name"><strong>Student:</strong> <?= htmlspecialchars($student['firstName'] . ' ' . $student['lastName']) ?></p>

  <label for="course">Course:</label>
  <select name="course" id="course" required>
    <option value="">Select Course</option>
    <option value="ICS" <?= ($student['course'] == 'ICS') ? 'selected' : '' ?>>ICS</option>
    <option value="ITE" <?= ($student['course'] == 'ITE') ? 'selected' : '' ?>>ITE</option>
    <option value="IBM" <?= ($student['course'] == 'IBM') ? 'selected' : '' ?>>IBM</option>
  </select>

  <label for="yearLevel">Year Level:</label>
  <select name="yearLevel" id="yearLevel" required>
    <option value="">Select Year Level</option>
    <option value="1st Year" <?= ($student['yearLevel'] == '1st Year') ? 'selected' : '' ?>>1st Year</option>
    <option value="2nd Year" <?= ($student['yearLevel'] == '2nd Year') ? 'selected' : '' ?>>2nd Year</option>
    <option value="3rd Year" <?= ($student['yearLevel'] == '3rd Year') ? 'selected' : '' ?>>3rd Year</option>
    <option value="4th Year" <?= ($student['yearLevel'] == '4th Year') ? 'selected' : '' ?>>4th Year</option>
  </select>

  <label for="address">Address:</label>
  <input type="text" id="address" name="address" value="<?= htmlspecialchars($student['address'] ?? '') ?>" placeholder="Address" required>

  <label for="birthDate">Birthdate:</label>
  <input type="date" id="birthDate" name="birthDate" value="<?= htmlspecialchars($student['birthDate'] ?? '') ?>" placeholder="Birthdate" required>

  <label for="religion">Religion:</label>
  <input type="text" id="religion" name="religion" value="<?= htmlspecialchars($student['religion'] ?? '') ?>" placeholder="Religion" required>

  <label for="gender">Gender:</label>
  <select name="gender" id="gender" required>
    <option value="">Select Gender</option>
    <option value="Male" <?= ($student['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
    <option value="Female" <?= ($student['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
  </select>

  <label for="component">Component:</label>
  <select name="component" id="component" required>
    <option value="">Select Component</option>
    <option value="ROTC" <?= ($student['component'] == 'ROTC') ? 'selected' : '' ?>>ROTC</option>
    <option value="CWTS" <?= ($student['component'] == 'CWTS') ? 'selected' : '' ?>>CWTS</option>
  </select>

  <button type="submit">Update</button>
  <a href="enrollments.php" class="cancel-link">Cancel</a>
</form>

    </main>
  </div>
</body>
</html>
