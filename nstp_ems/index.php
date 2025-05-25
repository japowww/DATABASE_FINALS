<?php
session_start();
include("connect.php");

$totalEnrolledQuery = "SELECT COUNT(*) as total FROM students";
$totalResult = $conn->query($totalEnrolledQuery);
$totalEnrolled = 0;
if ($totalResult) {
    $row = $totalResult->fetch_assoc();
    $totalEnrolled = $row['total'];
}

$rotcQuery = "SELECT COUNT(*) as rotc_count FROM students WHERE component = 'ROTC'";
$rotcResult = $conn->query($rotcQuery);
$rotcCount = 0;
if ($rotcResult) {
    $row = $rotcResult->fetch_assoc();
    $rotcCount = $row['rotc_count'];
}

$cwtsQuery = "SELECT COUNT(*) as cwts_count FROM students WHERE component = 'CWTS'";
$cwtsResult = $conn->query($cwtsQuery);
$cwtsCount = 0;
if ($cwtsResult) {
    $row = $cwtsResult->fetch_assoc();
    $cwtsCount = $row['cwts_count'];
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Enrollment Admin Panel</title>
  <link rel="stylesheet" href="adminstyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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
      <header>
        <h1>Welcome, Admin!</h1>
      </header>

      <section class="dashboard">
        <div class="card">
          <div class="icon"><i class="fas fa-users"></i></div>
          <h3>NSTP Students Enrolled</h3>
          <div class="divider"></div>
          <p><?= $totalEnrolled ?></p>
        </div>
        <div class="card">
          <div class="icon"><i class="fas fa-shield-alt"></i></div>
          <h3>ROTC</h3>
          <div class="divider"></div>
          <p><?= $rotcCount ?></p>
        </div>
        <div class="card">
          <div class="icon"><i class="fas fa-hands-helping"></i></div>
          <h3>CWTS</h3>
          <div class="divider"></div>
          <p><?= $cwtsCount ?></p>
        </div>
      </section>

      </section>

<section class="image-row">
  <div class="image-box">
    <img src="ROTC.jpg" alt="ROTC">
    <p>ROTC</p>
  </div>
  <div class="image-box">
    <img src="CWTS.jpg" alt="CWTS">
    <p>CWTS</p>
  </div>
</section>


    </main>
  </div>
</body>
</html>
