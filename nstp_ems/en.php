<?php
include("connect.php"); // Make sure this file defines $connection correctly
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Enrollment Admin Panel</title>
  <link rel="stylesheet" href="enrollment.css">
</head>

<body>

  <div class="container">
    <aside class="sidebar">
      <h2>Admin Panel</h2>
      <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="enrollments.php">Enrollments</a></li>
        <li><a href="#">Students</a></li>
        <li><a href="#">Reports</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <header>
        <h1>Enrolled Students</h1>
      </header>

      <a class="btn" href="/nstp_ems/assStudent.php" role="button">Add Student</a>

      <table>
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Course</th>
            <th>Address</th>
            <th>Religion</th>
            <th>Gender</th>
            <th>Component</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM students";
          $result = $connection->query($sql);

          if(!$result){
              die("Invalid query: " . $connection->error);
          }

          while($row = $result->fetch_assoc()){
              echo "
                <tr>
                  <td>{$row['studentId']}</td>
                  <td>{$row['lastName']}</td>
                  <td>{$row['firstName']}</td>
                  <td>{$row['course']}</td>
                  <td>{$row['address']}</td>
                  <td>{$row['religion']}</td>
                  <td>{$row['gender']}</td>
                  <td>{$row['component']}</td>
                  <td>
                    <a class=\"btn btn-primary btn-sm\" href=\"/nstp_ems/edit.php?id={$row['id']}\">Edit</a>
                    <a class=\"btn btn-danger btn-sm\" href=\"/nstp_ems/delete.php?id={$row['id']}\">Delete</a>
                  </td>
                </tr>
              ";
          }
          ?>
        </tbody>
      </table>
    </main>
  </div>

</body>
</html>
