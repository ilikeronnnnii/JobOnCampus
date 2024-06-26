<?php
include ("scripts/database.php");
session_start();

// Fetch faculties data
$sql = "SELECT * FROM faculty";
$result = $conn->query($sql);

$faculties = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faculties[$row['facultyID']] = $row;
        $faculties[$row['facultyID']]['jobCount'] = 0; // Initialize job count
    }
}

$sqlJobs = "SELECT j.jobID, j.facultyID, f.facultyName, j.position, j.location, j.salary, j.deadline
            FROM jobs j
            JOIN faculty f ON j.facultyID = f.facultyID";
$resultJobs = $conn->query($sqlJobs);

$jobs = [];
if ($resultJobs->num_rows > 0) {
    while ($row = $resultJobs->fetch_assoc()) {
        $jobs[] = $row;
        if (isset($faculties[$row['facultyID']])) {
            $faculties[$row['facultyID']]['jobCount'] += 1; // Increment job count for the respective faculty
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/careers.css" />
    <link rel="shortcut icon" type="x-icon" href="images/tab.png" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobOnCampus</title>
    <style>
        /* Modal Styling */
        .modal-alert {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-alert-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
        }

        .modal-alert-content h2 {
            margin-top: 0;
        }

        .modal-alert-content button {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <a href="home.php">
            <img class="logo" src="images/jobOnCampusBlack.png" alt="logo" /></a>
        <nav>
            <ul class="nav_links">
                <li><a href="careers.php">Careers</a></li>
                <?php if (isset($_SESSION['userID'])): ?>
                    <li><a href="applications.php">Applications</a></li>
                <?php endif; ?>
                <li><a href="request.php">Job Requests</a></li>
            </ul>
        </nav>
        <?php if (isset($_SESSION['userID'])): ?>
            <a class="cta" href="scripts/logout.php"><button>Log Out</button></a>
        <?php else: ?>
            <a class="cta" href="index.php"><button>Log In</button></a>
        <?php endif; ?>
    </header>
    <section>
        <div class="greetings">
            <?php
            if (isset($_SESSION["username"])) {
                $username = ucfirst(htmlspecialchars($_SESSION["username"]));
                echo "<h2>Welcome, " . $username . "!</h2>";
            }
            ?>
        </div>
        <div class="jobs-list-container">
            <h2>On-Campus Job Opportunities</h2>
            <div class="jobs">
                <?php foreach ($faculties as $faculty): ?>
                    <div class="job" data-facultyid="<?php echo $faculty['facultyID']; ?>">
                        <div class="job-header">
                            <img src="images/<?php echo strtolower(str_replace(' ', '', $faculty['facultyName'])); ?>.png"
                                alt="<?php echo $faculty['facultyName']; ?> Logo" class="company-logo" />
                            <div class="company-info">
                                <h3 class="company-title"><?php echo $faculty['facultyName']; ?></h3>
                                <p class="supervision"><?php echo $faculty['employees']; ?> Employees</p>
                            </div>
                        </div>
                        <div class="details"><?php echo $faculty['description']; ?></div>
                        <div class="positions">
                            <span>View <?php echo isset($faculty['jobCount']) ? $faculty['jobCount'] : 0; ?>
                                positions</span>
                            <a href="#" class="open-modal" data-facultyid="<?php echo $faculty['facultyID']; ?>"> <i
                                    class="fa-solid fa-arrow-right-to-bracket"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="jobData" style="display: none;">
            <?php foreach ($jobs as $job): ?>
                <div class="job-item" data-facultyid="<?php echo $job['facultyID']; ?>">
                    <div class="job-position"><?php echo $job['position']; ?></div>
                    <div class="job-location"><?php echo $job['location']; ?></div>
                    <div class="job-salary">RM<?php echo $job['salary']; ?> per hour</div>
                    <div class="job-deadline">
                        <?php echo date('Y-m-d', strtotime($job['deadline'])); ?>
                    </div>
                    <div class="job-apply"><a href="scripts/apply.php?jobID=<?php echo $job['jobID']; ?>"><i
                                class="fa-solid fa-briefcase"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Modal for Jobs -->
    <div id="jobModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <main class="table" id="customers_table">
                <section class="table__header">
                    <h2>Available Job Positions in <span id="facultyName"></span></h2>
                    <div class="input-group">
                        <input type="search" placeholder="Search Data...">
                        <i class='bx bx-search-alt'></i>
                    </div>
                </section>
                <section class="table__body">
                    <table>
                        <thead>
                            <tr>
                                <th> Position <span class="icon-arrow">&UpArrow;</span></th>
                                <th> Location <span class="icon-arrow">&UpArrow;</span></th>
                                <th> Salary <span class="icon-arrow">&UpArrow;</span></th>
                                <th> Job Type <span class="icon-arrow">&UpArrow;</span></th>
                                <th> Application Deadline<span class="icon-arrow">&UpArrow;</span></th>
                                <th> Apply </th>
                            </tr>
                        </thead>
                        <tbody id="jobList">
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </div>

    <!-- Modal for Login Alert -->
    <div id="alertModal" class="modal-alert">
        <div class="modal-alert-content">
            <h2>Login Required</h2>
            <p>You need to log in to view job positions.</p>
            <button id="alertClose">OK</button>
        </div>
    </div>

    <script>
        var modal = document.getElementById("jobModal");
        var alertModal = document.getElementById("alertModal");
        var span = document.getElementsByClassName("close")[0];
        var alertCloseBtn = document.getElementById("alertClose");

        var isLoggedIn = <?php echo isset($_SESSION['userID']) ? 'true' : 'false'; ?>;

        var jobs = document.querySelectorAll(".job");
        jobs.forEach(function (job) {
            job.addEventListener("click", function (e) {
                if (!isLoggedIn) {
                    e.preventDefault();
                    alertModal.style.display = "block";
                    return;
                }
                var facultyID = job.getAttribute("data-facultyid");
                var companyName = job.querySelector(".company-title").textContent;
                document.getElementById("facultyName").textContent = companyName;

                // Populate job positions dynamically
                var jobItems = document.querySelectorAll("#jobData .job-item[data-facultyid='" + facultyID + "']");
                var jobList = document.getElementById("jobList");
                jobList.innerHTML = ''; // Clear any previous content

                jobItems.forEach(function (item) {
                    var position = item.querySelector(".job-position").textContent;
                    var location = item.querySelector(".job-location").textContent;
                    var salary = item.querySelector(".job-salary").textContent;
                    var deadline = item.querySelector(".job-deadline").textContent;
                    var apply = item.querySelector(".job-apply").innerHTML;

                    jobList.innerHTML += `
     <tr>
      <td style="vertical-align:middle; text-align: left;">${position}</td>
       <td style="vertical-align:middle; text-align: left;">${location}</td>
       <td style="vertical-align:middle; text-align: left;">${salary}</td>
       <td style="vertical-align:middle; text-align: left;">Part-Time</td>
       <td style="vertical-align:middle; text-align: left;">Apply before - ${deadline}</td>
       <td style="vertical-align:middle; text-align: center;">${apply}</td>
     </tr>`;
                });

                // Reinitialize search and sort functionality
                initializeSearchAndSort();

                modal.style.display = "block";
            });
        });

        span.onclick = function () {
            modal.style.display = "none";
        };

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            if (event.target == alertModal) {
                alertModal.style.display = "none";
            }
        };

        alertCloseBtn.onclick = function () {
            alertModal.style.display = "none";
        };

        function initializeSearchAndSort() {
            const search = document.querySelector('.input-group input'),
                table_rows = document.querySelectorAll('tbody tr'),
                table_headings = document.querySelectorAll('thead th');

            // Searching for specific data of HTML table
            search.addEventListener('input', searchTable);

            function searchTable() {
                table_rows.forEach((row, i) => {
                    let table_data = row.textContent.toLowerCase(),
                        search_data = search.value.toLowerCase();

                    row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
                    row.style.setProperty('--delay', i / 25 + 's');
                });

                document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
                    visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
                });
            }

            // Sorting | Ordering data of HTML table
            table_headings.forEach((head, i) => {
                let sort_asc = true;
                head.onclick = () => {
                    table_headings.forEach(head => head.classList.remove('active'));
                    head.classList.add('active');

                    document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
                    table_rows.forEach(row => {
                        row.querySelectorAll('td')[i].classList.add('active');
                    });

                    head.classList.toggle('asc', sort_asc);
                    sort_asc = head.classList.contains('asc') ? false : true;

                    sortTable(i, sort_asc);
                }
            });

            function sortTable(column, sort_asc) {
                [...table_rows].sort((a, b) => {
                    let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
                        second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

                    return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
                })
                    .map(sorted_row => document.querySelector('tbody').appendChild(sorted_row));
            }
        }

        // Initialize search and sort functionality on page load
        initializeSearchAndSort();
    </script>
</body>

</html>