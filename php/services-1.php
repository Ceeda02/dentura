<?php
require 'config.php'; // Include your database connection file

// Define the target directory for image uploads.
$target_dir = "../admin/php/uploads/";

// Fetch all services from the database.
$sql = "SELECT service_name, image, description FROM services";
$result = $conn->query($sql);

$services = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if the stored path already includes the uploads directory.
        if (!str_starts_with($row['image'], $target_dir)) {
            $row['image'] = $target_dir . basename($row['image']);
        }
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
    <title>Our Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <?php include 'navigationbar.php'; ?>
    <?php include 'notif_modal.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Our Services</h2>
        <?php if (!empty($services)): ?>
            <div id="servicesCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($services as $index => $service): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="<?php echo htmlspecialchars($service['image']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($service['service_name']); ?>" style="max-height: 500px; object-fit: cover;">
                            <div class="carousel-caption d-none d-md-block">
                                <h5><?php echo htmlspecialchars($service['service_name']); ?></h5>
                                <p><?php echo htmlspecialchars($service['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <?php else: ?>
            <p>No services available at the moment.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
