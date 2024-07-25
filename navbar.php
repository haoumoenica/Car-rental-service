<?php
require_once "connection.php";
// require_once "logout.php";

// if (isset($_SESSION["user"])) {
//     $id = $_SESSION["user"];
// } else {
//     $id = $_SESSION["admin"];
// }

// $sql = "SELECT * FROM users WHERE id = $id";
// $result = mysqli_query($conn, $sql);
// $row = mysqli_fetch_assoc($result);

if ((isset($_SESSION["user"]))) {
    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-black'>
                <div class='container-fluid'>
                    <a class='navbar-brand' href='home.php'>Home</a>
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                        <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='home.php'>Rental Cars</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='profile.php'>Profile</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='logout.php?logout'>Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>";
}


if (isset($_SESSION["admin"])) {
    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-black'>
                <div class='container-fluid'>
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                        <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='home.php'>Rental Cars</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='profile.php'>Profile</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='create.php'>Create a car</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='logout.php?logout'>Logout</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </nav>";
} else if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-black'>
                <div class='container-fluid'>
                    <a class='navbar-brand' href='home.php'>Home</a>
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                        <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='home.php'>Rental Cars</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='login.php?logout'>Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>";
}



// if (isset($_SESSION["admin"])) {
//     echo "<nav class='navbar navbar-expand-lg navbar-dark bg-black'>
//                 <div class='container-fluid'>
//                     <a class='navbar-brand' href='home.php'><img src='pictures/{$row["picture"]}' width='50'></a>
//                     <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
//                         <span class='navbar-toggler-icon'></span>
//                     </button>
//                     <div class='collapse navbar-collapse' id='navbarSupportedContent'>
//                         <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
//                             <li class='nav-item'>
//                                 <a class='nav-link active' aria-current='page' href='home.php'>Rental Cars</a>
//                             </li>
//                             <li class='nav-item'>
//                                 <a class='nav-link active' aria-current='page' href='profile.php'>Profile</a>
//                             </li>
//                             <li class='nav-item'>
//                                 <a class='nav-link active' aria-current='page' href='create.php'>Create a car</a>
//                             </li>
//                             <li class='nav-item'>
//                                 <a class='nav-link active' aria-current='page' href='logout.php'>Logout</a>
//                             </li>
                            
//                         </ul>
//                     </div>
//                 </div>
//             </nav>";
// } else {
//     echo "<nav class='navbar navbar-expand-lg navbar-dark bg-black'>
//                 <div class='container-fluid'>
//                     <a class='navbar-brand' href='home.php'>home</a>

//                 <img src='pictures/{$row["picture"]}' width='50'>
//                     <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
//                     <span class='navbar-toggler-icon'></span>
//                     </button>
//                     <div class='collapse navbar-collapse' id='navbarSupportedContent'>
//                         <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
//                             <li class='nav-item'>
//                                 <a class='nav-link active' aria-current='page' href='home.php'>Rental Cars</a>
//                             </li>
//                             <li class='nav-item'>
//                                 <a class='nav-link active' aria-current='page' href='profile.php'>Profile</a>
//                             </li>
//                             <li class='nav-item'>
//                                 <a class='nav-link active' aria-current='page' href='logout.php'>Logout</a>
//                             </li>
//                         </ul>
//                     </div>
//                 </div>
//             </nav>";
// }