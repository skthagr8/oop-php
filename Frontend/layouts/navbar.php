<?php
class Navbar {
    private $isLoggedIn;
    private $isAdmin;

    public function __construct($isLoggedIn, $isAdmin) {
        $this->isLoggedIn = $isLoggedIn; 
        $this->isAdmin = $isAdmin; 
    }

    public function render_navbar() {
        ?>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Book Bible</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent"> <!-- Updated the ID for collapse -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Browse Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="borrowbookform.php">Borrow a Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="my-reserved-books.php">Reserved Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="return-a-book.php">Return a Book</a>
                        </li>

                        <?php 
                        // Check if $isAdmin is true
                        if ($this->isAdmin): 
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="AdminMenu" role="button" data-bs-toggle="dropdown">
                                    Admin
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="manage-all-books.php">Manage Books</a></li>
                                    <li><a class="dropdown-item" href="manage-all-users.php">Manage Users</a></li>
                                </ul>
                            </li>
                            <?php
                        endif; // End of the if statement
                        ?>

                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <ul class="navbar-nav ms-2">
                        <li class="nav-item">
                            <a class="nav-link" href="user-profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="my-borrowed-books.php">Borrowed Books</a>
                        </li>
                        <?php
                        try {
                            // Check if the user is logged in
                            if ($this->isLoggedIn):
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="memberlogoutform.php">Logout</a>
                                </li>
                                <?php
                            else:
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="memberloginform.php">Login</a>
                                </li>
                                <?php
                            endif;
                        } catch (\Throwable $th) {
                            echo "Incorrect Initialization: " . $th->getMessage();
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
    }
}
?>
