<?php
include('authentication.php');
$page_title = "Dashboard";
include('includes/header.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="dashboard.css">
    <title>Document</title>
</head>

<body>
    <nav id="sidebar">
        <ul style="padding-left: 0% !important;">
            <li>
                <span class="logo">GGcode</span>
                <button onclick="toggleSidebar()" id="toggle-btn" class="text-primary bg-dark mb-4 d-flex">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </li>
            <li class="active">
                <a href="index.php">
                    <i class="fa-solid fa-house"></i>
                    <span> Home</span>
                </a>
            </li>
            <li>
                <a href="dashboard.php">
                    <i class="fa-solid fa-grip"></i>
                    <span> Dashboard</span>
                </a>
            </li>
            <li>
                <button onclick="ToggleMenu(this)" class="dropdown-btn">
                    <i class="fa-solid fa-file"></i>
                    <span> Create</span>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
                <ul class="sub-menu">
                    <div>
                        <li><a href="#">Folder</a></li>
                        <li><a href="#">Document</a></li>
                        <li><a href="#">Project</a></li>
                    </div>
                </ul>
            </li>
            <li>
                <button onclick="ToggleMenu(this)" class="dropdown-btn">
                    <i class="fa-solid fa-check-double"></i>
                    <span>Todo-list</span>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
                <ul class="sub-menu">
                    <div>
                        <li><a href="#">Work</a></li>
                        <li><a href="#">Private</a></li>
                        <li><a href="#">Coding</a></li>
                        <li><a href="#">Gardening</a></li>
                        <li><a href="#">School</a></li>
                    </div>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa-solid fa-calendar"></i>
                    <span>calendar</span>
                </a>
            </li>
            <li>
                <button onclick="ToggleMenu(this)" class="dropdown-btn">
                    <i class="fa-solid fa-user"></i>
                    <span>Profile</span>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
                <?php if (!isset($_SESSION['authenticated'])) : ?>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        <?php endif ?>
        <?php if (isset($_SESSION['authenticated'])) : ?>
            <ul class="sub-menu">
                <div>
                <li><a href="logout.php"><i class="fa fa-sign-out d-flex" aria-hidden="true"></i>Logout</a></li>
                </div>
            </ul>
        <?php endif ?>
        </li>
        </ul>
    </nav>
    <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($_SESSION['status'])) { ?>
                            <div class="alert alert-success">
                                <h5> <?= $_SESSION['status']; ?> </h5>
                            </div>
                        <?php
                            unset($_SESSION['status']);
                        } ?>
                            <div class="card-header">
                                <h5>User Dashboard</h5>
                            </div>
                            <div class="card-body">
                                <h2>Access when you are Logged IN</h2>
                                <hr>
                                <h5>name: <?= $_SESSION['auth_user']['name']; ?></h5>
                                <h5>email: <?= $_SESSION['auth_user']['email']; ?></h5>
                                <h5>phone: <?= $_SESSION['auth_user']['phone']; ?></h5>
                                <h5>API Key: <?= isset($_SESSION['auth_user']['api_key']) ? htmlspecialchars($_SESSION['auth_user']['api_key'], ENT_QUOTES, 'UTF-8') : 'Not available'; ?></h5>           
                            </div>
                        
                    </div>
                </div>
            </div>
        <div class="container">
            <h2>hello world</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis repudiandae placeat autem, obcaecati
                enim ea assumenda perspiciatis voluptas blanditiis sapiente dolore sit. Aperiam ipsum repellendus
                consequatur quae facere expedita numquam?</p>
        </div>
    </main>
    <script type="text/javascript" src="dashboard.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<?php include('includes/footer.php'); ?>