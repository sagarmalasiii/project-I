<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hamro Job - Home</title>
    <!-- Bootstrap CSS -->
    <link
      href="bootstrap-5.3.3-dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="./css/style.css" rel="stylesheet" />
  </head>
  <body>
    <!--navbar-->
    <nav class="navbar navbar-expand-lg fixed-top bg-light shadow">
      <div class="container-fluid">
        <a class="navbar-brand me-auto" href="#">Hamro Job</a>
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
            <li class="nav-item">
              <a class="nav-link mx-lg-2 active" aria-current="page" href="#"
                >Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#">Contact</a>
            </li>
          </ul>
          <!-- Search Form -->
          <form class="d-flex me-3" role="search">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
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
              <li><a class="dropdown-item" href="./jobseeker/login.html">Login</a></li>
              <li><a class="dropdown-item" href="./jobseeker/register.html">Register</a></li>
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
              <li><a class="dropdown-item" href="./employer/login.html">Login</a></li>
              <li><a class="dropdown-item" href="./employer/register.html">Register</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!--navbar end-->

    <!--Hero section-->
    <section class="hero-section">
      <div class="container justify-content-center fs-1 text-white flex-column">
        <!-- Hero content can go here -->
      </div>
    </section>

    <!--End Hero section-->

    <!-- Bootsrap JS-->
    <script
      src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
  </body>
</html>