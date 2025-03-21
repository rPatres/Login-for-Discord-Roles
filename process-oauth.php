<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the 'code' parameter is present in the URL
if (!isset($_GET['code'])) {
    echo 'No code provided';
    exit();
}

$discord_code = $_GET['code'];

// Payload for exchanging the code for an access token
$payload = [
    'code' => $discord_code,
    'client_id' => 'clientid', // Replace with your Discord client ID
    'client_secret' => 'clientsecret', // Replace with your Discord client secret
    'grant_type' => 'authorization_code',
    'redirect_uri' => 'redirecturi', // Replace with your redirect URI
    'scope' => 'identify guilds', // Updated scope to include guilds
];

$payload_string = http_build_query($payload);
$discord_token_url = "https://discordapp.com/api/oauth2/token";

// Initialize cURL to request the access token
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $discord_token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($ch);

if (!$result) {
    echo curl_error($ch);
    exit();
}

$result = json_decode($result, true);
$access_token = isset($result['access_token']) ? $result['access_token'] : null;

if (!$access_token) {
    echo 'Failed to retrieve access token';
    exit();
}

// Fetch user data from Discord
$discord_users_url = "https://discordapp.com/api/users/@me";
$header = ["Authorization: Bearer $access_token", "Content-Type: application/x-www-form-urlencoded"];

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $discord_users_url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($ch);
$result = json_decode($result, true);

// Fetch guild member data to check roles
$guild_id = 'guildid'; // Replace with your guild ID
$guildObject = getGuildObject($access_token, $guild_id);
$guild_roles = $guildObject['roles'];

// Define the required role ID
$requiredRoleId = 'roleid'; // Replace with your required role ID

// Check if the user has the required role
$hasRequiredRole = in_array($requiredRoleId, $guild_roles);

// Start session and store user data
session_start();

$_SESSION['logged_in'] = true;
$_SESSION['userData'] = [
    'name' => $result['username'],
    'discord_id' => $result['id'],
    'avatar' => $result['avatar'],
    'hasRequiredRole' => $hasRequiredRole,
];

// Redirect based on role
if ($hasRequiredRole) {
    header("Location: dashboard.php"); // Redirect to the customer page
    exit();
} else {
    header("Location: errorlogin.php"); // Redirect to the error page
    exit();
}

// Function to fetch guild member data
function getGuildObject($access_token, $guild_id)
{
    $discord_api_url = "https://discordapp.com/api";
    $header = ["Authorization: Bearer $access_token", "Content-Type: application/x-www-form-urlencoded"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_URL, $discord_api_url . '/users/@me/guilds/' . $guild_id . '/member');
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    $result = json_decode($result, true);
    return $result;
}