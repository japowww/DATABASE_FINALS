<?php
session_start();
include("connect.php");

// Optional: Check if admin is logged in (you can keep your admin session check here)
// if (!isset($_SESSION['adminId'])) {
//     header("Location: adminLogin.php");
//     exit();
// }

// Handle enrollment submission
if (isset($_POST['submit'])) {
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $course = $conn->real_escape_string($_POST['course']);
    $yearLevel = $conn->real_escape_string($_POST['yearLevel']);
    $address = $conn->real_escape_string($_POST['address']);
    $birthDate = $conn->real_escape_string($_POST['birthDate']);
    $religion = $conn->real_escape_string($_POST['religion']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $component = $conn->real_escape_string($_POST['component']);

    // Insert new student record (no userId now)
    $insert = "INSERT INTO students 
        (firstName, lastName, course, yearLevel, address, birthDate, religion, gender, component) 
        VALUES 
        ('$firstName', '$lastName', '$course', '$yearLevel', '$address', '$birthDate', '$religion', '$gender', '$component')";

    if ($conn->query($insert)) {
        header("Location: students.php?success=1&component=" . urlencode($component));
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Enrollment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            width: 300px;
            margin-top: 20px;
        }
        input, select, button {
            display: block;
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Enroll Student</h2>

    <?php if (isset($_GET['success']) && isset($_GET['component'])): ?>
        <p class="success-message">
            ✅ Student successfully enrolled in the <?= htmlspecialchars($_GET['component']) ?> component!
        </p>
    <?php endif; ?>

    <form method="POST" action="students.php">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>

        <select name="course" required>
            <option value="">Select Course</option>
            <option value="ICS">ICS</option>
            <option value="ITE">ITE</option>
            <option value="IBM">IBM</option>
        </select>

        <select name="yearLevel" required>
            <option value="">Select Year Level</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
        </select>

        <input type="text" name="address" placeholder="Address">
        <input type="date" name="birthDate" placeholder="Birthdate">
        <input type="text" name="religion" placeholder="Religion">

        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <select name="component" required>
            <option value="">Select Component</option>
            <option value="ROTC">ROTC</option>
            <option value="CWTS">CWTS</option>
        </select>

        <button type="submit" name="submit">Enroll Student</button>
    </form>
</body>
</html>
