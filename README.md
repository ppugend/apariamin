# About Apariamin

## Purpose, Use Cases

This section explains the purpose, use cases, and limitations of the Apariamin project. Apariamin is designed to provide a lightweight and modular Docker Compose-based alternative to XAMPP for local development and production environments. It simplifies the setup of a web server, database, and database management tool while maintaining flexibility for customization.

## Project Name and Meaning

The name **Apariamin** is derived from the following components:

- **Apa**che**, the popular open-source web server.
- Ma**ria**DB, a robust and scalable database management system.
- phpMyAd**min**, a web-based database administration tool.

This project is a Docker Compose-based alternative to XAMPP, providing a lightweight and modular setup for both local development and production environments.

## License

This project is licensed under the MIT License. See the LICENSE file for details.

## Support This Project

If you found this project helpful, consider supporting its maintenance and future development with a small donation.  
You can buy me a coffee via the Ko-fi link below — thank you! ☕✨  

[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/B0B21CR05U)

---

## Initial Setup

### 1. Open the Cloned Repository in VSCode and Install Recommended Extensions

After cloning the repository, open the project folder in VSCode.  
When prompted, install the recommended extensions for the workspace.  

If a prompt appears asking for an executable PHP extension, you can safely ignore it.

### 2. Create `.env` File from Example

Create the `.env` file from the provided example to configure the database and other environment variables. Use the command below:

```bash
cp .env-example .env
```
**Ensure this command is executed from the workspace root.**

Edit the `.env` file as needed to enter the database root password, database name, username, and user password.

### 3. Configure `docker-compose.override.yml` for Development

For development environments, create the `docker-compose.override.yml` file from the provided example to use a dedicated database volume for development and prevent containers from restarting automatically. Use the command below:

```bash
cp example_docker-compose.override.dev.yml docker-compose.override.yml
```
**Ensure this command is executed from the workspace root.**

### 4. VSCode Tasks for Local Development

You can run Docker Compose commands using pre-defined VSCode tasks.  
To access them:

- Open the **Command Palette** → _"Tasks: Run Task"_
- Shortcut:
  - **Windows/Linux**: `Ctrl+Shift+P`
  - **macOS**: `Cmd+Shift+P`

Here are the available tasks:

| Task Label                                 | Description |
|--------------------------------------------|-------------|
| `Apariamin Compose build`                     | Builds the Docker images using `docker-compose.yml` and `docker-compose.override.dev.yml`. |
| `Apariamin Compose up`                        | Starts containers in detached mode with development override configuration. |
| `Apariamin Compose up with rebuild image`     | Rebuilds images and starts containers (useful when base image or code changes). |
| `Apariamin Compose stop`                      | Stops running containers without removing them. |
| `Apariamin Compose remove containers`          | Stops and removes containers (equivalent to `docker-compose down`). |
| `Apariamin Compose remove volume storage(dev)`| Removes the development database volume `apariamin_db_data_dev`. |
| `Apariamin open web and phpmyadmin in browser`| Opens the development web page and phpMyAdmin in your default browser. |


## Running on a Production Server
Clone the repository and complete the initial setup steps, including creating and configuring the `.env` file.  
After completing the setup, run the following command **from the workspace root** to start the containers:

```bash
docker compose up -d
```

To stop the containers without removing them, use the following command:

```bash
docker compose stop
```

## Debug PHP Code

To debug PHP code, start the containers using the following command:

```bash
docker compose up
```

Then press `F5` in VSCode to launch the debugger.  

Xdebug will communicate through port `9003`.  
(This is just a reference for information purposes and does not require any action from the developer.)

Access the web page by navigating to:

```text
http://127.0.0.1:8000
```

Set breakpoints in your PHP code and test the functionality on the PHP-based web page. You can inspect variable values and step through the code during execution.

To access phpMyAdmin, open your browser and navigate to:

```text
http://127.0.0.1:8090
```

### Note
1. Replace `[WORKSPACE_PATH]` with the appropriate path to your workspace.
2. All ports are bound to `127.0.0.1`, assuming a separate reverse proxy, such as Nginx, will be used.