<?php

include('include/header.php');



$employer_id = $_SESSION['user_id'];



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
                    <span class="due-date" title="deadline"><img src="img/calendar3.svg" alt="" height="20" width="20" style="padding-right: 8px;"><?php echo date("F j", strtotime($row['deadline'])) ?></span>
                    <span class="status-tag">Pending</span>
                    <button class="action-btn" onclick="window.location.href='delete_job.php?id=<?php echo $row['job_id']; ?>'">Delete</button>
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
                    <th>Status</th>
                    <th>Deadline</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result2) == 0) {
                    echo "<tr><td colspan='5'>No posted jobs available.</td></tr>";
                }
                while ($row1 = mysqli_fetch_assoc($result2)) { ?>
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
                                <?php if ($row1["current_status"] == 1) { ?>
                                    <button style=" background-color: orange;
                                        color: #fff;
                                        border: none;
                                        padding: 8px 12px;
                                        border-radius: 4px;
                                        cursor: pointer;">
                                        <a href="deactivate_job.php?id=<?php echo $row1['job_id']; ?>" style="text-decoration: none; color: white;">Deactivate</a>
                                    </button>
                                <?php } ?>
                                <?php if ($row1["current_status"] == 0) { ?>
                                    <button style=" background-color: blue;
                                        color: #fff;
                                        border: none;
                                        padding: 8px 12px;
                                        border-radius: 4px;
                                        cursor: pointer;">
                                        <a href="active_job.php?id=<?php echo $row1['job_id']; ?>" style="text-decoration: none; color: white;">Activate</a>
                                    </button>
                                <?php } ?>
                            </div>
                        </td>
                        <td> <?php if ($row1['current_status'] == 0) {

                                    echo "Inactive";
                                } else {
                                    echo "Active";
                                }
                                ?></td>
                        <td><?php echo $row1['deadline']; ?></td>
                    </tr>
                <?php } ?>
                <!-- Additional grades here -->
            </tbody>
        </table>
    </section>
</main>

<?php
include('include/footer.php');
?>