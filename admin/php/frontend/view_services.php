<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../loginadmin.php"); // Redirect to login if not logged in
    exit();
}

// Database configuration for booking notifications and services
$conn = new mysqli("localhost", "root", "", "dentura");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count new (pending) bookings for notifications
$result = $conn->query("SELECT COUNT(*) as newBookings FROM bookings WHERE status = 'Pending'");
$newBookings = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newBookings = $row['newBookings'];
}

// Fetch all services from the database for display and carousel
$sql = "SELECT service_name, image, description FROM services";
$result = $conn->query($sql);

$services = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DenturAdmin</title>
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/admin/css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <style>
        /* Additional CSS for hiding/showing sections */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/assets/images/DENTURA.png" alt="DenturAdmin Logo" style="height: 100px;"> <!-- Adjust height as needed -->
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link text-dark">Hello, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b> !</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" id="notification-btn">
                        <i class="fas fa-bell"></i> Notifications 
                        <?php if ($newBookings > 0): ?>
                            <span class="badge badge-danger"><?php echo $newBookings; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <!-- Logout Button -->
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-dark">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>




<!-- Navbar and Sidebar code -->

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <!-- Sidebar code -->

            <div class="sidebar-sticky">
                <h4 class="text-center">D E N T U R A D M I N</h4>
                <ul class="nav flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="../manage_admin.php">
                            <i class="fas fa-user-shield"></i> Manage Admins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_dentists.php">
                            <i class="fas fa-user-md"></i> Dentists
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_services.php">
                            <i class="fas fa-tools"></i> Services
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_branches.php">
                            <i class="fas fa-building"></i> Branches
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_contacts.php">
                            <i class="fas fa-envelope"></i> View Contacts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view_bookings.php">
                            <i class="fas fa-calendar-check"></i> View Bookings
                        </a>
                    </li>
                    
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1 class="text-center mt-5 dashboard-header">Welcome to the D E N T U R A D M I N</h1>

            <!-- Display Services Information -->
            <div id="service-info" class="mt-5">
                <div class="mb-3">
                    <a href="../add_service.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                </div>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Service Id</th>
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($services)): ?>
                            <?php foreach ($services as $index => $service): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($service['description'], 0, 50)) . (strlen($service['description']) > 50 ? '...' : ''); ?></td>

                                    <td>
                                        <a href='../edit_service.php?service_name=<?php echo urlencode($service['service_name']); ?>' class='text-warning mr-3'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <a href='../delete_service.php?service_name=<?php echo urlencode($service['service_name']); ?>' class='text-danger'>
                                            <i class='fas fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan='4' class='text-center'>No registered services found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


<script>
    $(document).ready(function () {
        // Show SweetAlert for pending bookings when the notification button is clicked
        $('#notification-btn').on('click', function (e) {
            e.preventDefault(); // Prevent the default link behavior
            if (<?php echo $newBookings; ?> > 0) {
                swal({
                    title: "Pending Appointments",
                    text: "You have <strong><?php echo $newBookings; ?></strong> pending appointments. Please review them in Bookings!",
                    html: true,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Go to Bookings",
                    cancelButtonText: "Close",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        window.location.href = "../view_bookings.php"; // Redirect to bookings section
                    }
                });
            }
        });

        // Example: Using SweetAlert for success messages (optional)
        <?php if (isset($_SESSION['delete_success'])): ?>
            swal("Deleted!", "<?php echo $_SESSION['delete_success']; ?>", "success");
            <?php unset($_SESSION['delete_success']); // Clear the message after displaying ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['delete_error'])): ?>
            swal("Error!", "<?php echo $_SESSION['delete_error']; ?>", "error");
            <?php unset($_SESSION['delete_error']); // Clear the message after displaying ?>
        <?php endif; ?>
    });
</script>

<!-- CRUD -->

</body>
</html>
