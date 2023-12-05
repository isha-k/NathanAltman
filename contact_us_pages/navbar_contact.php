<?php
if (isset($_SESSION['user_id'])) {
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
        <a class="navbar-brand ms-5" href="../index.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="../client_pages/index.php">Clients</a>
                <a class="nav-item nav-link" href="../project_pages/index.php">Projects</a>
                <a class="nav-item nav-link" href="../organisations_pages/index.php">Organisations</a>
                <a class="nav-item nav-link" href="../user_pages/index.php">Users</a>
            </div>
            <div class="navbar-nav ms-auto">
                <a class="nav-item nav-link me-5 d-inline" href="contact_forms.php">Manage Contact Forms</a>
                <a class="nav-item nav-link me-5 d-inline" href="index.php">Contact Us</a>
                <a class="nav-item nav-link me-5 d-inline" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <?php
} else {
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
        <a class="navbar-brand ms-5" href="../index.php">Home</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-item nav-link me-5 d-inline" href="index.php">Contact Us</a>
            <a class="nav-item nav-link me-5 d-inline" href="../login.php">Login</a>
        </div>
    </nav>
    <?php
}
?>