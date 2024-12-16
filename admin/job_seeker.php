<?php
include('include/header.php');
include('include/sidebar.php');

include('connection/connection.php');

$query = "SELECT * FROM job_seeker";

$result = mysqli_query($conn, $query);

?>




<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Job Seeker</a></li>

        </ol>
    </nav>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Job Seeker</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary">Share</button>
                <button class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
            </button>
        </div>
    </div>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>I.D</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $row['job_seeker_id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <a href="delete_job_seeker.php?id=<?php echo $row['job_seeker_id'];?>" class="btn btn-sm btn-outline-danger">Delete</a>
                            </div>
                            
                            

                        </div>
                    </td>
                <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>I.D</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

    <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>


    <div class="table-responsive">

    </div>
</main>
</div>
</div>

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>
    window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
</script>
<script src="../../assets/js/vendor/popper.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>

<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- datatables plugins -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
    new DataTable('#example');
</script>
</body>

</html>