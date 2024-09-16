<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In/Sign Up Form</title>
    <link rel="stylesheet" href="css/stylelogin.css" />
    <link rel="stylesheet" href="css/a.css" />
    <link rel="icon" href="images/logo.png" type="image/png" />
  </head>
  <body>
    
    <h1>Sign in/up Form</h1>
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form action="signup.php" method="post">
          <h1>Create Account</h1>
          <div class="social-container">
            <a href="https://www.facebook.com/" class="social">
              <img src="images/facebook1.png" alt="Facebook" />
            </a>
            <a href="https://www.instagram.com/" class="social">
              <img src="images/instagram1.png" alt="Facebook" />
            </a>
            <a href="https://www.google.com/" class="social">
              <img src="images/google1.png" alt="Facebook" />
            </a>
          </div>
          <span>or use your email for registration</span>
          <select name="user_type" required>
    <option value="" disabled selected>Select user type</option>
    <option value="Admin">Admin</option>
    <option value="Staff">Staff</option>
    <option value="Customer">Customer</option>
  </select>
          <input type="text" name="name" placeholder="Name" required />
          <input type="email" name="email" placeholder="Email" required />
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
          />

          <button>Sign Up</button>
        </form>
      </div>
      <div class="form-container sign-in-container">
        <form action="signin.php" method="post">
          <h1>Sign in</h1>
          <div class="social-container">
            <a href="https://www.facebook.com/" class="social">
              <img src="images/facebook1.png" alt="Facebook" />
            </a>
            <a href="https://www.instagram.com/" class="social">
              <img src="images/instagram1.png" alt="Facebook" />
            </a>
            <a href="https://www.google.com/" class="social">
              <img src="images/google1.png" alt="Facebook" />
            </a>
          </div>
          <span>or use your account</span>
          <select name="user_type" required>
    <option value="" disabled selected>Select user type</option>
    <option value="Admin">Admin</option>
    <option value="Staff">Staff</option>
    <option value="Customer">Customer</option>
  </select>
          <input type="email" name="email" placeholder="Email" required />
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
          />

          <a href="forgot-password.html">Forgot your password?</a>
          <button>Sign In</button>
        </form>
      </div>
      <div class="overlay-container" id="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h2>Welcome Back!</h2>
            <p1>
              To keep connected with us please login with your personal info
            </p1>
            <button class="ghost" id="signIn">Sign In</button><br /><br />
            <button onclick="window.location.href='index.html';">Home</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Hello, Friend!</h1>
            <p>Enter your personal details and start journey with us</p>
            <button class="ghost" id="signUp">Sign Up</button><br /><br />
            <button onclick="window.location.href='index.html';">Home</button>
          </div>
        </div>
      </div>
    </div>
    <script src="js/scriptlogin.js"></script>
  </body>
</html>
