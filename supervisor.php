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

// SQL query to fetch job request data
$sqlJobRequests = "SELECT jr.requestID, u.Name as userName, jr.dateRequested, jr.certification, jr.jobPosition, f.facultyName, jr.status
                   FROM job_request jr
                   INNER JOIN user u ON jr.userID = u.userID
                   INNER JOIN faculty f ON jr.facultyID = f.facultyID";
$resultJobRequests = $conn->query($sqlJobRequests);

$jobRequests = [];
if ($resultJobRequests->num_rows > 0) {
    while ($row = $resultJobRequests->fetch_assoc()) {
        $jobRequests[] = $row;
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
        * {
            font-family: "Montserrat";
        }

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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: calc(100% - 40px);
            padding: 10px;
            margin-left: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group button {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 20px;
        }

        .form-group button:hover {
            background: #555;
        }

        .create-job {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 10px 20px;
            background-color: #000000;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            color: #ffffff;
            font-size: 16px;
            font-weight: 500;
        }

        .form-group button:hover {
            background-color: #670420;
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
                <a href="../index.php" class="logout">
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
                                                    <option value="working" <?php echo ($application['Status'] == 'currently working') ? 'selected' : ''; ?>>Working</option>
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
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Recent Job Requests</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Date Requested</th>
                                <th>Certification</th>
                                <th>Job Position</th>
                                <th>Faculty</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($jobRequests) > 0): ?>
                                <?php foreach ($jobRequests as $jobRequest): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($jobRequest['userName']); ?></td>
                                        <td><?php echo htmlspecialchars($jobRequest['dateRequested']); ?></td>
                                        <td><?php echo htmlspecialchars($jobRequest['certification']); ?></td>
                                        <td><?php echo htmlspecialchars($jobRequest['jobPosition']); ?></td>
                                        <td><?php echo htmlspecialchars($jobRequest['facultyName']); ?></td>
                                        <td>
                                            <form action="scripts/update_job_request_status.php" method="post">
                                                <input type="hidden" name="requestID"
                                                    value="<?php echo $jobRequest['requestID']; ?>">
                                                <select name="status" class="status-select" onchange="this.form.submit()">
                                                    <option value="approved" <?php echo ($jobRequest['status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                                    <option value="rejected" <?php echo ($jobRequest['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                    <option value="pending" <?php echo ($jobRequest['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="scripts/delete_job_request.php" method="post"
                                                onsubmit="return confirm('Are you sure you want to delete this job request?');">
                                                <input type="hidden" name="requestID"
                                                    value="<?php echo $jobRequest['requestID']; ?>">
                                                <button type="submit" class="delete-button"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No job requests found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="create-job">
                        <div class="head">
                            <h3>Create a Job</h3>
                        </div>
                        <form id="create-job-form" action="scripts/create_job.php" method="post">
                            <div class="form-group">
                                <label for="job-position">Job Position</label>
                                <input type="text" id="job-position" name="position" placeholder="Enter job position"
                                    required />
                            </div>

                            <div class="form-group">
                                <label for="faculty">Faculty</label>
                                <select id="faculty" name="faculty" required>
                                    <option value="1">Computing</option>
                                    <option value="2">Management</option>
                                    <option value="3">Science</option>
                                    <option value="4">Mechanical Engineering</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" id="location" name="location" placeholder="Enter job location"
                                    required />
                            </div>

                            <div class="form-group">
                                <label for="salary">Salary</label>
                                <input type="number" step="0.01" id="salary" name="salary" placeholder="Enter salary"
                                    required />
                            </div>

                            <div class="form-group">
                                <label for="deadline">Deadline</label>
                                <input type="datetime-local" id="deadline" name="deadline" required />
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="5"
                                    placeholder="Enter job description" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="lecturer">Lecturer</label>
                                <input type="text" id="lecturer" name="lecturer" placeholder="Enter lecturer name"
                                    required />
                            </div>

                            <button type="submit">Create Job</button>
                        </form>
                    </div>
                </div>
        </main>
    </section>
</body>

</html>