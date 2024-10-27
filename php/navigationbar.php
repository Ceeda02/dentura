
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dentura</title>

    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/navigationbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">
                <img src="/assets/images/DENTURA.png" alt="DENTURA" style="width: 100px; height: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item category">
                        <a class="nav-link" aria-current="page" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item category">
                      <a class="nav-link" aria-current="page" href="aboutus.php">About Us</a>
                    </li>
                    <li class="nav-item category">
                      <a class="nav-link" aria-current="page" href="services-1.php">Services</a>
                    </li>
                    
                    <li class="nav-item category">
                        <a class="nav-link" aria-current="page" href="contactus.php">Contact Us</a>
                    </li>
                </ul>
                
                <!-- Right-aligned user options -->
                <!-- Right-aligned user options -->
<ul class="navbar-nav">
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        <li class="nav-item">
            <i class="fas fa-bell" data-toggle="modal" data-target="#notificationsModal"></i>
        </li>
        <li class="nav-item">
            <span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link coloraccount" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link coloraccount" data-bs-toggle="modal" data-bs-target="#signupModal">Sign up</a>
        </li>        
    <?php endif; ?>
</ul>

            </div>
        </div> 
    </nav>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
