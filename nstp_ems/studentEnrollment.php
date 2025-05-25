<?php
session_start();
include("connect.php");

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

// Check if student is already enrolled
$checkEnrollment = $conn->query("SELECT component FROM students WHERE userId = '$userId'");
$isEnrolled = $checkEnrollment->num_rows > 0;
$enrolledComponent = $isEnrolled ? $checkEnrollment->fetch_assoc()['component'] : null;

// Handle enrollment submission
if (isset($_POST['submit']) && !$isEnrolled) {
    $course = $_POST['course'];
    $yearLevel = $_POST['yearLevel'];
    $address = $_POST['address'];
    $birthDate = $_POST['birthDate'];
    $religion = $_POST['religion'];
    $gender = $_POST['gender'];
    $component = $_POST['component'];

    $insert = "INSERT INTO students (userId, course, yearLevel, address, birthDate, religion, gender, component) 
               VALUES ('$userId', '$course', '$yearLevel', '$address', '$birthDate', '$religion', '$gender', '$component')";

    if ($conn->query($insert)) {
        header("Location: studentEnrollment.php?success=1&component=" . urlencode($component));
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
        /* Reset and base */
        body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    max-width: 800px;
    padding: 20px;
    box-sizing: border-box;
}

.main-content {
    background-color: #f0f4f8;
    padding: 40px 50px;
    box-sizing: border-box;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 450px;
}

h2 {
    color: #002244;
    margin-bottom: 25px;
    font-weight: 700;
}

form {
    background: white;
    padding: 30px 25px;
    border-radius: 8px;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
}

select, input[type="text"], input[type="date"], button {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

select:focus, input[type="text"]:focus, input[type="date"]:focus {
    border-color: #002244;
    outline: none;
}

button {
    background-color: #002244;
    color: white;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border-radius: 6px;
}

button:hover {
    background-color: #014e7a;
}

.success-message {
    background-color: #dff0d8;
    border: 1px solid #b2dba1;
    padding: 15px 20px;
    color: #3c763d;
    border-radius: 6px;
    max-width: 450px;
    margin-bottom: 20px;
}

.info-message {
    background-color: #e2ffe2;
    border: 1px solid #b2ffb2;
    padding: 15px 20px;
    color: #444;
    border-radius: 6px;
    max-width: 450px;
    margin-bottom: 20px;
}

/* Logout button */
form.logout-form {
    margin-top: 30px;
    max-width: 450px;
}
form.logout-form button {
    background-color: #e74c3c;
}
form.logout-form button:hover {
    background-color: #c0392b;
}

    </style>
</head>
<body>
    <div class="container">
        
        <main class="main-content">
            <h2>Enroll in NSTP</h2>

            <?php if (isset($_GET['success']) && isset($_GET['component'])): ?>
                <div class="success-message">
                    ✅ You are successfully enrolled in the <strong><?= htmlspecialchars($_GET['component']) ?></strong> component!
                </div>
            <?php elseif ($isEnrolled): ?>
                <div class="info-message">
                    ✅ You are already enrolled in the <strong><?= htmlspecialchars($enrolledComponent) ?></strong> component.
                </div>
            <?php else: ?>
                <form method="POST">
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

                    <input type="text" name="address" placeholder="Address" required>
                    <input type="date" name="birthDate" placeholder="Birthdate" required>
                    <input type="text" name="religion" placeholder="Religion" required>

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

                    <button type="submit" name="submit">Enroll</button>
                </form>
            <?php endif; ?>

            <form action="logout.php" method="POST" class="logout-form">
                <button type="submit" name="logout">Log out</button>
            </form>
        </main>
    </div>
</body>
</html>
