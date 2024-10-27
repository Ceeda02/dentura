<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denture Ni Ano</title>
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Include the Navigation Bar -->
    <?php include 'navigationbar.php'; ?>
    <?php include 'notif_modal.php'; ?>

    <div class="d-flex align-items-center justify-content-center flex-column flex-lg-row mt-4">
        <div class="image-container me-4">
            <img src="/assets/images/Saly-44.png" alt="image">
        </div>

        <main class="text-container">
            <h1>Welcome to Dentura</h1>
            <p>One of the best dental clinics in Pangasinan. We are here to provide you with the best dental care services.</p>
            
            <!-- Check if the user is logged in before showing the booking link -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="booking_form.php" class="btn btn-appointment btn-lg">Book an Appointment</a>
            <?php else: ?>
                <!-- Show login modal if user is not logged in -->
                <a class="btn btn-appointment btn-lg" data-toggle="modal" data-target="#loginModal">
                    Book an Appointment
            </a>
            <?php endif; ?>
            
            
        </main>
    </div>

    <br>
    </div>

    <br>

    

    <?php include 'about.php'; ?>

    <div>
        <h2 class="text-center">Latest Reviews</h2>
        <br>
        <?php include 'review.php'; ?>
    </div>

    <div>
        <h2 class="text-center">Meet our Expert Team</h2>
    </div>
    <br><br>
    
    <?php include 'team.php'; ?>

    <br><br>
    <div><br></div>

    <?php include 'mission.php'; ?>

    <div><br></div>

    <br><br><br><br>

    <?php include 'branch.php'; ?>

    <br><br><br><br><br>

    <?php include 'footer.php'; ?>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="login.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="login_email">Email:</label>
                            <input type="email" class="form-control" id="login_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="login_password">Password:</label>
                            <input type="password" class="form-control" id="login_password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="signup.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="signupModalLabel">Signup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="signup_first_name">First Name:</label>
                            <input type="text" class="form-control" id="signup_first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="signup_last_name">Last Name:</label>
                            <input type="text" class="form-control" id="signup_last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="signup_email">Email:</label>
                            <input type="email" class="form-control" id="signup_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="signup_password">Password:</label>
                            <input type="password" class="form-control" id="signup_password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifications Modal -->
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
