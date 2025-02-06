<nav class="navbar navbar-expand-lg bg-primary admin-nav" data-bs-theme="dark">
    <div class="container-fluid">
        <!-- <a class="navbar-brand" href="landing_admin.php">NOP</a> -->
        <a class="navbar-brand" href="adminManageCourses.php">NOP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item nav-item-margin">
                    <a class="nav-link" href="adminManageUsers.php">User accounts</a>
                </li>
                <li class="nav-item nav-item-margin">
                    <a class="nav-link" href="adminManageCourses.php">Courses</a>
                </li>
            </ul>
            <form class="" action="../logout.php" method="POST">
                <button class="btn btn-secondary my-2 my-sm-0 logout-button" type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</nav>