<?php
session_start();
include("connect.php");

// Get counts by course
$courseCounts = [];
$courseQuery = "SELECT course, COUNT(*) as count FROM students GROUP BY course";
$result = $conn->query($courseQuery);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $courseCounts[$row['course']] = $row['count'];
    }
}

// Get counts by year level
$yearCounts = [];
$yearQuery = "SELECT yearLevel, COUNT(*) as count FROM students GROUP BY yearLevel";
$result = $conn->query($yearQuery);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $yearCounts[$row['yearLevel']] = $row['count'];
    }
}

// Optional: counts by component (if you want)
$componentCounts = [];
$componentQuery = "SELECT component, COUNT(*) as count FROM students GROUP BY component";
$result = $conn->query($componentQuery);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $componentCounts[$row['component']] = $row['count'];
    }
}

$genderCounts = [];
$genderQuery = "SELECT gender, COUNT(*) as count FROM students GROUP BY gender";
$result = $conn->query($genderQuery);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $genderCounts[$row['gender']] = $row['count'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reports - Admin Panel</title>
  <link rel="stylesheet" href="adminstyle.css" />
  <style>
    main.main-content {
      padding: 20px 50px;
      background-color: #f0f4f8;
      min-height: 100vh;
    }
    h1 {
      color: #002244;
      margin-bottom: 30px;
      text-align: center;
      font-weight: 700;
    }
    .report-section {
      max-width: 600px;
      margin: 0 auto 40px;
      background: white;
      border-radius: 8px;
      padding: 25px 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .report-section h2 {
      color: #014e7a;
      margin-bottom: 15px;
      border-bottom: 2px solid #002244;
      padding-bottom: 2px;
      font-weight: 600;
    }
    ul.report-list {
      list-style-type: none;
      padding-left: 0;
    }
    ul.report-list li {
      font-size: 16px;
      padding: 8px 0;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      color: #333;
    }
    ul.report-list li:last-child {
      border-bottom: none;
    }
    ul.report-list li span.count {
      font-weight: 700;
      color: #002244;
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
        <li><a href="reports.php" class="active">Reports</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <h1>Enrollment Reports</h1>

      <section class="report-section">
        <h2>Enrollments by Course</h2>
        <ul class="report-list">
          <?php
          $courses = ['ICS', 'ITE', 'IBM'];
          foreach ($courses as $course) {
              $count = isset($courseCounts[$course]) ? $courseCounts[$course] : 0;
              echo "<li>$course <span class='count'>$count</span></li>";
          }
          ?>
        </ul>
      </section>


      <section class="report-section">
        <h2>Enrollments by Component</h2>
        <ul class="report-list">
          <?php
          $components = ['ROTC', 'CWTS'];
          foreach ($components as $comp) {
              $count = isset($componentCounts[$comp]) ? $componentCounts[$comp] : 0;
              echo "<li>$comp <span class='count'>$count</span></li>";
          }
          ?>
        </ul>
      </section>

      <section class="report-section">
  <h2>Enrollments by Gender</h2>
  <ul class="report-list">
    <?php
    $genders = ['Male', 'Female'];
    foreach ($genders as $gender) {
        $count = isset($genderCounts[$gender]) ? $genderCounts[$gender] : 0;
        echo "<li>$gender <span class='count'>$count</span></li>";
    }
    ?>
  </ul>
</section>
    </main>
  </div>
</body>
</html>
