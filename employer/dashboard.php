<?php
include('include/header.php');
include('../connection.php');
if ($_SESSION['user_id'] == true) {
    // Fetch job details for pending jobs
    $employer_id = $_SESSION['user_id'];
} else {
    header("Location: login.html");
}



$query = "SELECT * FROM jobs WHERE employer_id = $employer_id AND is_approved = 0 ";

$result = mysqli_query($conn, $query);

$query2 = "SELECT * FROM jobs WHERE employer_id = $employer_id AND is_approved = 1 ";

$result2 = mysqli_query($conn, $query2);



?>

<main>

    <section class="assignments-section">
        <h2>Pending Jobs</h2>
        <?php
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <ul class="assignments-list">
                <li class="assignment overdue">
                    <strong><?php echo $row['job_title']; ?></strong>
                    <a href="view_job_details.php?id=<?php echo $row['job_id']; ?>">View Job Details</a>
                    <span class="due-date"><img src="img/calendar3.svg" alt="" height="20" width="20" style="padding-right: 8px;"><?php echo date("F j", strtotime($row['deadline'])) ?></span>
                    <span class="status-tag">Pending</span>
                    <button class="action-btn"><a href="delete_job.php?id=<?php echo $row['job_id']; ?>" style="text-decoration: none; color: white;">Delete</a></button>
                </li>

            </ul>
        <?php } ?>
    </section>
    <section class="grades-section">
        <h2>Posted Jobs</h2>
        <table class="grades-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>View Details</th>
                    <th>Action</th>
                    <th>Posted Date</th>
                    <th>Deadline</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row1 = mysqli_fetch_assoc($result2)) { ?>
                    <tr>

                        <td><?php echo $row1['job_title']; ?></td>
                        <td> <a href="view_job_details.php?id=<?php echo $row1['job_id']; ?>">View Job Details</a></td>

                        <td class="grade A">
                            <div class="action-cotainer">
                                <button
                                    style=" background-color: red;
                                        color: #fff;
                                        border: none;
                                        padding: 8px 12px;
                                        border-radius: 4px;
                                        cursor: pointer;">
                                    <a href="delete_job.php?id=<?php echo $row1['job_id']; ?>" style="text-decoration: none; color: white;">Delete</a>
                                </button>
                                <button style=" background-color: green;
                                        color: #fff;
                                        border: none;
                                        padding: 8px 12px;
                                        border-radius: 4px;
                                        cursor: pointer;">
                                    <a href="edit_job.php?id=<?php echo $row1['job_id']; ?>" style="text-decoration: none; color: white;">Edit</a>
                                </button>
                            </div>
                        </td>
                        <td> <?php echo $row1['created_date']; ?></td>
                        <td><?php echo $row1['deadline']; ?></td>
                    </tr>
                <?php } ?>
                <!-- Additional grades here -->
            </tbody>
        </table>
    </section>
</main>
<footer>
    <div class="contact-info">
        <p><img src="img/telephone.svg" alt=""> 091-523-221</p>
        <p><img src="img/envelope.svg" alt=""> info@hamrojob.com.np</p>
    </div>
    <div class="useful-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Help Center</a>
        <a href="#">Feedback</a>
    </div>
    <div class="social-media">
        <a href="#"><img class="socials" src="img/facebook.svg" alt=""></a>
        <a href="#"><img src="img/twitter-x.svg" alt="" class="socials"></a>
        <a href="#"><img src="img/linkedin.svg" alt="" class="socials"></a>
    </div>
</footer>

<script src="./js/script.js" defer></script>
</body>

</html>