<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

require_once "scripts/database.php";

// Fetch the number of users
$sqlUserCount = "SELECT COUNT(*) as userCount FROM user";
$resultUserCount = $conn->query($sqlUserCount);
$userCount = 0;
if ($resultUserCount->num_rows > 0) {
    $row = $resultUserCount->fetch_assoc();
    $userCount = $row['userCount'];
}

// Fetch the number of applications
$sqlApplicationCount = "SELECT COUNT(*) as applicationCount FROM application";
$resultApplicationCount = $conn->query($sqlApplicationCount);
$applicationCount = 0;
if ($resultApplicationCount->num_rows > 0) {
    $row = $resultApplicationCount->fetch_assoc();
    $applicationCount = $row['applicationCount'];
}

// SQL query to fetch application data
$sql = "SELECT u.Name, a.ApplicationID, a.DateApplied, a.Status, u.Resume 
        FROM application a
        INNER JOIN user u ON a.userID = u.userID";
$result = $conn->query($sql);

$applications = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/supervisor.css">
    <link rel="shortcut icon" type="x-icon" href="images/tab.png" />
    <title>JobOnCampus</title>
    <style>
        .status-select {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .delete-button {
            background: none;
            border: none;
            color: #ff0000;
            cursor: pointer;
        }

        .delete-button:hover {
            color: #cc0000;
        }
    </style>
</head>

<body>

    <section id="sidebar">
        <a href="#" class="brand">
            <img src="images/jobOnCampusBlack.png" style="width: 70%; margin-top: 50px;">
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="http://localhost/jobOnCampus/index.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <section id="content">
        <nav>
            <a href="#" class="notification"></a>
            <a href="#" class="profile"></a>
        </nav>

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">
                        <h3><?php echo $applicationCount; ?></h3>
                        <p>Applications</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo $userCount; ?></h3>
                        <p>Users</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Recent Applications</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Date Applied</th>
                                <th>Status</th>
                                <th>Resume</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($applications) > 0): ?>
                                <?php foreach ($applications as $application): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($application['Name']); ?></td>
                                        <td><?php echo htmlspecialchars($application['DateApplied']); ?></td>
                                        <td>
                                            <form action="scripts/update_status.php" method="post">
                                                <input type="hidden" name="applicationID"
                                                    value="<?php echo $application['ApplicationID']; ?>">
                                                <select name="status" class="status-select" onchange="this.form.submit()">
                                                    <option value="working" <?php echo ($application['Status'] == 'working') ? 'selected' : ''; ?>>Working</option>
                                                    <option value="rejected" <?php echo ($application['Status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                    <option value="accepted" <?php echo ($application['Status'] == 'accepted') ? 'selected' : ''; ?>>Accepted</option>
                                                    <option value="pending" <?php echo ($application['Status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                    <option value="past" <?php echo ($application['Status'] == 'past') ? 'selected' : ''; ?>>Past</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td><a href="scripts/uploads/<?php echo htmlspecialchars($application['Resume']); ?>"
                                                target="_blank">Download</a></td>
                                        <td>
                                            <form action="scripts/delete_application.php" method="post"
                                                onsubmit="return confirm('Are you sure you want to delete this application?');">
                                                <input type="hidden" name="applicationID"
                                                    value="<?php echo $application['ApplicationID']; ?>">
                                                <button type="submit" class="delete-button"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No applications found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <script src="script3.js"></script>
</body>

</html>