# Login for Discord Roles

This repository provides a solution for implementing role-based authentication on Discord. With this bot, users can log in to your website via Discord OAuth and automatically receive roles based on their access status.

## Features
- **Discord OAuth Integration**: Allows users to log in using their Discord account.
- **Role-Based Access Control**: Assign roles to users based on their authentication status and access.
- **Automatic Role Management**: Once the user logs in, the bot assigns the correct roles without manual intervention.
- **Easy Setup**: Includes simple instructions to get started quickly.

## Requirements
- A **Discord Bot Token**.
- A **Discord Developer Account**.
- A **Web Server** for hosting the OAuth flow (can be a local or cloud server).
- Python 3.x and required libraries (listed in `requirements.txt`).

## Installation

1. **Clone the repository**:
    ```bash
    git clone https://github.com/rPatres/Login-for-Discord-Roles.git
    cd Login-for-Discord-Roles
    ```

2. **Install dependencies**:
    ```bash
    pip install -r requirements.txt
    ```

3. **Create a Discord Bot**:
    - Go to the [Discord Developer Portal](https://discord.com/developers/applications).
    - Create a new application, then navigate to the "OAuth2" tab.
    - Set the `Redirect URI` in the OAuth2 tab and make sure to use it in your bot configuration.

4. **Configure your bot**:
    - Update the `config.json` file with your Discord Bot Token and Client ID.
    - Set the appropriate permissions for your bot to manage roles.

5. **Start the bot**:
    ```bash
    python bot.py
    ```

## Usage

1. **Login Flow**: Users log in using their Discord credentials via OAuth.
2. **Role Assignment**: Once authenticated, roles are assigned automatically based on the user's access level.
3. **Manage Roles**: You can modify role assignments in the `bot.py` script.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

