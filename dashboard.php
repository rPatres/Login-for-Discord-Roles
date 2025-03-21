<?php
session_start();

// Check if user data is set in the session
if (!isset($_SESSION['userData'])) {
    header("Location: /index.html"); // Redirect to login if no user data
    exit();
}

// Check if the user has the required role
$hasRequiredRole = $_SESSION['userData']['hasRequiredRole'] ?? false;

if (!$hasRequiredRole) {
    header("Location: /index.html"); // Redirect to login if the user doesn't have the required role
    exit();

    // Fetch user data from the session
$userData = $_SESSION['userData'];
$username = $userData['name'];
$discordId = $userData['discord_id'];
$avatarUrl = "https://cdn.discordapp.com/avatars/{$discordId}/{$userData['avatar']}.png";
$hasRequiredRole = $userData['hasRequiredRole'] ?? false;
}

// If the user has the required role, they can proceed
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Body Styling */
    body {
      font-family: 'Arial', sans-serif;
      background: #000; /* Black background */
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff; /* White text */
    }

    /* Dashboard Container */
    .dashboard-container {
      text-align: center;
      background: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(255, 255, 255, 0.1); /* White shadow */
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1); /* Subtle white border */
      animation: fadeIn 1.5s ease-in-out;
    }

    /* Profile Picture */
    .profile-picture {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-bottom: 20px;
      border: 3px solid #fff; /* White border */
    }

    /* Username */
    .username {
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    /* Discord ID */
    .discord-id {
      font-size: 1rem;
      color: #aaa; /* Light gray text */
      margin-bottom: 20px;
    }

    /* Role Status */
    .role-status {
      font-size: 1rem;
      color: <?php echo $hasRequiredRole ? '#00ff00' : '#ff0000'; ?>; /* Green if role exists, red otherwise */
    }

    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <img src="<?php echo $avatarUrl; ?>" alt="Profile Picture" class="profile-picture">
    <h1 class="username"><?php echo $username; ?></h1>
    <p class="discord-id">Discord ID: <?php echo $discordId; ?></p>
    <p class="role-status">
      <?php echo $hasRequiredRole ? 'You have the required role!' : 'You do not have the required role.'; ?>
    </p>
  </div>
</body>
</html>