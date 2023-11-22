<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

// Fetch unique category names from the database
$categorySql = "SELECT DISTINCT name FROM Categories";
$categoryStmt = $db->query($categorySql);
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch details for featured solutions (Network Solutions and Structured Cabling)
$featuredSolutionsSql = "SELECT Products.name AS product_name, Products.description AS product_description, Products.price AS product_price
                        FROM Products
                        JOIN Categories ON Products.category_id = Categories.category_id
                        WHERE Categories.name IN ('Network Solutions and Structured Cabling')";
$featuredSolutionsStmt = $db->query($featuredSolutionsSql);

// Initialize $featuredSolutions as an empty array
$featuredSolutions = array();

// Check if the query was successful and results were obtained
if ($featuredSolutionsStmt !== false) {
    $featuredSolutions = $featuredSolutionsStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SVPB E-Commerce and Smart Solutions</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

<div class="header-container">
    <!-- Search Container -->
    <div class="search-container">
        <div class="search-input-container">
            <input type="text" id="search" name="search" placeholder="SEARCH BY CATEGORY">
            <button type="button" onclick="searchProducts()">
                <img src="images/icon.png" alt="Search" class="search-button-icon">
            </button>
        </div>
    </div>

    <!-- User Signin Container -->
    <div class="user-signin-container">
        <?php
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            // Display user information or logout link
            echo '<div class="user-dropdown">
                    <span id="signin-link">
                        Welcome, ' . $_SESSION['username'] . '!
                    </span>
                    <div class="dropdown-content">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>';
        } else {
            // Display login and registration links
            echo '<div class="user-dropdown">
                    <a href="login.php" id="signin-link"> 
                        <img src="images/sign-in.png" alt="Sign In" class="dropbtn">
                    </a>
                    <div class="dropdown-content">
                        <a href="login.php">Sign In</a> <!-- Update the href here as well -->
                        <a href="registration.html">Register</a>
                    </div>
                </div>';
        }
        ?>
        <a href="addtocart.html">
            <img src="images/cart.png" alt="Cart" class="cart-icon">
        </a>
    </div>
</div>

<form id="login-form" action="login.php" method="post" style="display: none;">
    <input type="text" name="serveruser" placeholder="Username">
    <input type="password" name="fontelar" placeholder="Password">
    <button type="submit">Login</button>
</form>

<div id="header-separator"></div>
<header id="header" class="fixed-header">
    <a href="index.php">
        <img src="images/lbglogo.png" alt="Logo" class="logo">
    </a>
    
    <nav id="navigation">
        <ul>
            <li><a href="#">Home</a></li>
            <li class="dropdown">
                <a href="#">Solutions</a>
                <div class="dropdown-content">
                    <a href="solutions.html">Security Solutions</a>
                    <a href="solutions.html">Network Solutions</a>
                    <a href="solutions.html">ICT Infrastructure</a>
                </div>
            </li>
            <li><a href="#">Events</a></li>
            <li><a href="#">Jobs</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    </nav>
</header>

<div class="product-listing">
    <h1>Products Offered</h1>
    <div class="category-row">
        <?php
        $firstRowCategories = array_slice($categories, 0, 7);
        foreach ($firstRowCategories as $category) :
            $categoryName = $category['name'];
            ?>
            <div class="product-item">
                <h2><a href="product.php?category=<?php echo urlencode($categoryName); ?>"><?php echo $categoryName; ?></a></h2>
                <?php echo getCategoryDescription($categoryName); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="category-row">
        <?php
        $secondRowCategories = array_slice($categories, 7);
        foreach ($secondRowCategories as $category) :
            $categoryName = $category['name'];
            ?>
            <div class="product-item">
                <h2><a href="product.php?category=<?php echo urlencode($categoryName); ?>"><?php echo $categoryName; ?></a></h2>
                <?php echo getCategoryDescription($categoryName); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php
function getCategoryDescription($categoryName)
{
    $descriptions = array(
        'Central Processing Units (CPUs)' => 'A CPU, or Central Processing Unit, is the primary component of a computer responsible for executing instructions of a computer program.',
        'Motherboards' => 'A motherboard is the central circuit board in a computer, connecting and facilitating communication between key hardware components. It determines compatibility, houses the CPU socket, RAM slots, and provides expansion options for additional components.',
        'Memory (RAM)' => 'RAM, or Random Access Memory, is a type of computer memory that provides high-speed data access to the CPU. It is volatile memory used for running applications and storing temporary data.',
        'Storage Drives (SSDs and HDDs)' => 'Storage drives, including HDDs and SSDs, are devices used for long-term data storage. HDDs offer larger storage capacity, while SSDs provide faster data access.',
        'Graphics Cards' => 'Graphics cards, or GPUs, are dedicated hardware components designed to accelerate graphics rendering. They are essential for gaming, video editing, and other graphics-intensive tasks.',
        'Power Supplies (PSUs)' => 'A power supply unit (PSU) is a critical component that converts electrical power from an outlet into usable power for a computer. It provides energy to other hardware components.',
        'Cooling Solutions (CPU coolers and case fans)' => 'Cooling solutions, including CPU coolers and case fans, are essential for maintaining optimal operating temperatures. They prevent overheating and ensure system stability.',
        'Network Interface Cards (NICs)' => 'Network Interface Cards (NICs) enable computers to connect to networks. They facilitate communication by providing a network connection for data transmission.',
        'Input Devices (Keyboards, Mice, etc.)' => 'Input devices, such as keyboards and mice, are peripherals that allow users to interact with and control the computer. They are crucial for user input.',
        'Monitors' => 'Monitors are display devices that visually present information generated by the computer. They come in various sizes and resolutions, enhancing the user experience.',
        'Printers and Scanners' => 'Printers and scanners are devices used for producing hard copies of digital documents and converting physical documents into digital format, respectively.',
        'Security Solutions' => 'Security solutions encompass hardware and software measures designed to protect computer systems and data from unauthorized access, cyber threats, and malicious activities.',
        'Network Solutions and Structured Cabling' => 'Network Solutions and Structured Cabling services optimize network infrastructure for seamless connectivity, scalability, and reliability in business environments.',
        'Information and Communication Technology Infrastructure' => 'ICT infrastructure refers to the hardware, software, networks, and facilities that support information and communication technology services within an organization.'
    );

    return isset($descriptions[$categoryName]) ? '<p>' . $descriptions[$categoryName] . '</p>' : '';
}
?>


<div id="text-box">
    <h1 id="h1">LBG E-COMMERCE AND SMART SOLUTIONS</h1>
    <h2 id="h2">Bright Solutions, Profitable Ideas</h2>
    <p>L.B.G E-COMMERCE AND SMART SOLUTIONS is a distinguished Information Technology service provider, specializing in providing cutting-edge computer parts and IT solutions to small, medium, and large organizations. With a strong focus on technological collaboration, they empower their clients to find the best computer parts and IT solutions to enhance their operations. SVPB E-Commerce and Smart Solutions' mission is to assist businesses in fulfilling their IT needs, allowing them to concentrate on their core competencies while delivering high-quality computer parts built on simplicity, security, and scalability.</p>
</div>

<div id="featured-solutions-box">
    <h2>Featured Solutions: Network Solutions and Structured Cabling</h2>
    <p>Explore our best-in-class Network Solutions and Structured Cabling services designed to optimize your network infrastructure. Our comprehensive solutions ensure seamless connectivity, scalability, and reliability for your business needs.</p>
    <p>Upgrade your business infrastructure with our cutting-edge Network Solutions and Structured Cabling services. We offer comprehensive solutions designed to enhance connectivity, scalability, and reliability.</p>
    <ul>
    <?php foreach ($featuredSolutions as $solution) : ?>
            <li>
                <strong><?php echo $solution['product_name']; ?></strong>
                <p><?php echo $solution['product_description']; ?></p>
                <p>Price: $<?php echo $solution['product_price']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<footer id="footer">
    <div class="footer-division">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    </div>
    <div class="footer-division">
        <h3>Solutions</h3>
        <ul>
            <li><a href="solutions.html">Security Solutions</a></li>
            <li><a href="solutions.html">Network Solutions</a></li>
            <li><a href="solutions.html">ICT Infrastructure</a></li>
        </ul>
    </div>
    <div class="footer-division">
        <a href="index.php">
            <div><img src="images/lbglogo.png" alt="Logo" class="logo">
                <p>© Copyright Jay Fontelar<br>All rights reserved. 2023.</p>
            </div>
        </a>
    </div>
</footer>

</body>
</html>

<script>

const slideshowContainer = document.getElementById('slideshow-container');
const images = slideshowContainer.querySelectorAll('img');
let currentIndex = 0;

setInterval(() => {
    images[currentIndex].style.opacity = 0;
    currentIndex = (currentIndex + 1) % images.length;
    images[currentIndex].style.opacity = 1;
}, 3000);

const header = document.getElementById('header');
const headerHeight = header.offsetHeight;

window.addEventListener('scroll', () => {
    const scrollPosition = window.scrollY || window.pageYOffset;

    if (scrollPosition >= headerHeight) {
        header.classList.add('fixed-header');
    } else {
        header.classList.remove('fixed-header');
    }
});

</script>
