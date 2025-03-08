<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hamro Job - Home</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <style>
   /* Navbar Styling */
.navbar {
    background-color: #fff; /* Sets the background color of the navbar to white */
    height: 80px; /* Defines the height of the navbar */
    margin: 20px; /* Adds space around the navbar */
    border-radius: 16px; /* Rounds the corners of the navbar */
    padding: 0.3rem; /* Adds padding inside the navbar */
}

/* Navbar Brand */
.navbar-brand {
    font-weight: 500; /* Makes the brand text slightly bold */
    color: #00bcd4; /* Sets the brand text color */
    font-size: 24px; /* Increases font size for better visibility */
    transition: 0.3s color; /* Smooth transition effect for color changes */
}

/* Buttons for Jobseeker, Employer, and Admin */
.jobseeker-button,
.employer-button,
.admin-button {
    background-color: #00bcd4; /* Sets the button background color */
    color: #fff; /* Sets the text color to white */
    font-size: 14px; /* Defines the font size */
    padding: 8px 20px; /* Adds padding inside the button */
    border-radius: 50px; /* Makes the button rounded */
    text-decoration: none; /* Removes underlining from links */
    transition: 0.3s background-color; /* Smooth transition effect for background color */
}

/* Button Hover Effects */
.jobseeker-button:hover,
.employer-button:hover,
.admin-button:hover {
    background-color: #98d0f1; /* Changes background color on hover */
}

/* Navbar Toggler (Mobile View) */
.navbar-toggler {
    border: none; /* Removes the border */
    font-size: 1.2rem; /* Increases the icon size */
}

/* Removes focus outline on navbar toggler and close button */
.navbar-toggler:focus,
.btn-close:focus {
    box-shadow: none;
    outline: none;
}

/* Hero Section */
.hero-section {
    background: url('./img/home.jpg') no-repeat center center; /* Sets background image with no repeat */
    background-size: cover; /* Ensures the background covers the entire section */
    width: 100%; /* Makes it full width */
    height: 100vh; /* Sets the height to full viewport height */
    position: relative; /* Required for overlay positioning */
}

/* Dark Overlay Effect on Hero Section */
.hero-section::before {
    background-color: rgba(0, 0, 0, 0.6); /* Adds a semi-transparent black overlay */
    content: ""; /* Required for pseudo-elements */
    position: absolute; /* Covers the entire section */
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

/* Centering Content in Hero Section */
.hero-section .container {
    height: 100%; /* Ensures the container takes full height */
    z-index: 1; /* Ensures content appears above the overlay */
    position: relative; /* Keeps content positioned correctly */
    display: flex; /* Enables flexbox for alignment */
    flex-direction: column; /* Stacks elements vertically */
    justify-content: center; /* Centers content vertically */
    align-items: center; /* Centers content horizontally */
    text-align: center; /* Aligns text to center */
    color: #fff; /* Sets text color to white */
}

/* Search Bar Styling */
.hero-section .search-bar {
    width: 100%; /* Full width of container */
    max-width: 700px; /* Limits maximum width */
    margin-top: 20px; /* Adds space above the search bar */
}

/* Input Field Styling */
.hero-section .form-control {
    border: 2px solid #ccc; /* Sets border color */
    border-radius: 50px; /* Makes the input field rounded */
    transition: all 0.3s ease; /* Smooth transition for styling */
}

/* Focus Effect on Input Field */
.hero-section .form-control:focus {
    border-color: #00bcd4; /* Changes border color when focused */
    box-shadow: 0 0 5px rgba(95, 202, 238, 0.5); /* Adds a subtle glow effect */
    outline: none; /* Removes the default outline */
}

/* Search Button Styling */
.hero-section .btn {
    border-radius: 50px; /* Makes the button rounded */
    padding: 10px 20px; /* Adds padding */
    background-color: #00bcd4; /* Sets background color */
    transition: background-color 0.3s ease, border-color 0.3s ease; /* Adds smooth transition effect */
}

/* Hover Effect for Search Button */
.hero-section .btn:hover {
    background-color: #00bcd4; /* Keeps the background color same */
    color: white; /* Ensures text remains white */
    border-color: #00bcd4; /* Maintains border color */
}

/* Footer Styling */
footer {
    background-color: #00bcd4; /* Sets background color */
}

/* Footer Heading */
footer h5 {
    color: black; /* Changes heading color to black */
    font-weight: bold; /* Makes text bold */
}

/* Footer List Styling */
footer ul {
    padding-left: 0; /* Removes default padding */
}

/* Footer List Items */
footer ul li {
    color: black; /* Changes text color to black */
    font-weight: normal; /* Keeps normal font weight */
    margin-bottom: 5px; /* Adds spacing between list items */
}

/* Footer Links */
footer a {
    color: black; /* Sets link color to black */
    font-weight: bold; /* Makes links bold */
    transition: 0.3s; /* Smooth transition effect */
}

/* Footer Link Hover Effect */
footer a:hover {
    color: #fff; /* Changes link color to white on hover */
    text-decoration: underline; /* Adds underline on hover */
}

    </style>

  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-light shadow">
      <div class="container-fluid">
        <a class="navbar-brand me-auto" href="about.php">Hamro Job</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
          </ul>
          <!-- Admin Dropdown -->
          <div class="dropdown me-2">
            <button
              class="btn admin-button dropdown-toggle"
              type="button"
              id="adminDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              Admin
            </button>
            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
              <li><a class="dropdown-item" href="./admin/login.php">Login</a></li>
            </ul>
          </div>
          <!-- JobSeeker Dropdown -->
          <div class="dropdown me-2">
            <button
              class="btn jobseeker-button dropdown-toggle"
              type="button"
              id="jobseekerDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              JobSeeker
            </button>
            <ul class="dropdown-menu" aria-labelledby="jobseekerDropdown">
              <li><a class="dropdown-item" href="./jobseeker/login.php">Login</a></li>
              <li>
                <a class="dropdown-item" href="./jobseeker/register.php"
                  >Register</a
                >
              </li>
            </ul>
          </div>
          <!-- Employer Dropdown -->
          <div class="dropdown">
            <button
              class="btn employer-button dropdown-toggle"
              type="button"
              id="employerDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              Employer
            </button>
            <ul class="dropdown-menu" aria-labelledby="employerDropdown">
              <li><a class="dropdown-item" href="./employer/login.php">Login</a></li>
              <li>
                <a class="dropdown-item" href="./employer/register.php"
                  >Register</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar end -->

    <!-- Hero section -->
    <section class="hero-section">
      <div class="container">
        <h1 class="mb-4">Find Your Dream Job</h1>
        <form class="search-bar d-flex" action="search_results.php" method="GET">
          <input
          id="search"
          name="query"
            class="form-control me-2"
            type="text"
            placeholder="Search for jobs, companies, or skills"
            aria-label="Search"
            
          />
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
    </section>
    <!-- End Hero section -->

     <!-- Footer -->
     <footer class="text-light">
        <div class="container">
          <div class="row">
            <!-- About Us -->
            <div class="col-md-4">
              <h5>ABOUT US</h5>
              <ul>
                <li><a href="about.php">About HamroJob</a></li>
                <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
                <li><a href="https://www.twitter.com" target="_blank">Twitter</a></li>                
              </ul>
            </div>
            <!-- Contact Us -->
            <div class="col-md-4">
              <h5>CONTACT US</h5>
              <ul>
                <li>📍 Kathmandu, Nepal</li>
                <li>📞 +977 1 4106700</li>
                <li>📧 info@hamrojob.com</li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
      <!-- End Footer -->

    <!-- Bootstrap JS -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
  </body>
</html>