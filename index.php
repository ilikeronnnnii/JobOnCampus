<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="x-icon" href="images/tab.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="stylesheet" href="css/index.css" />
    <title>JobOnCampus</title>
  </head>

  <body>
    <div class="container" id="container">
      <div class="form-container sign-up">
        <form
          action="scripts/registration.php"
          method="post"
          enctype="multipart/form-data"
        >
          <h1>Create Account</h1>
          <div class="social-icons">
            <a href="#" class="icon"
              ><i class="fa-brands fa-google-plus-g"></i
            ></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
          <span>or use your email for registeration</span>
          <input type="text" placeholder="Name" name="Name" required />
          <input type="email" placeholder="Email" name="Email" required />
          <input
            type="password"
            placeholder="Password"
            name="Password"
            required
          />
          <label for="resume-upload">Upload Resume</label>
          <input
            type="file"
            id="resume-upload"
            name="Resume"
            accept=".pdf"
            required
          />
          <button name="submit" type="submit">Sign Up</button>
        </form>
      </div>
      <div class="form-container sign-in">
        <form action="scripts/login.php" method="post">
          <h1>Sign In</h1>
          <div class="social-icons">
            <a href="#" class="icon"
              ><i class="fa-brands fa-google-plus-g"></i
            ></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
          <span>or use your email password</span>
          <input type="email" placeholder="Email" name="Email" />
          <input type="password" placeholder="Password" name="Password" />
          <a href="#">Forget Your Password?</a>
          <button name="login" type="submit">Sign In</button>
        </form>
      </div>
      <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-left">
            <h1>Welcome!</h1>
            <p>Enter your personal details to use all of site features</p>
            <button class="hidden" id="login">Sign In</button>
          </div>
          <div class="toggle-panel toggle-right">
            <h1>jobOnCampus.</h1>
            <p>
              The best gateway to connecting with valuable career opportunities
              right on campus.
            </p>
            <button name="submit" class="hidden" id="register">Sign Up</button>
          </div>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
