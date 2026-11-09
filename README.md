# About Apariamin

## Purpose, Use Cases

This section explains the purpose, use cases, and limitations of the Apariamin project. Apariamin is designed to provide a lightweight and modular Docker Compose-based alternative to XAMPP for local development and production environments. It simplifies the setup of a web server, database, and database management tool while maintaining flexibility for customization.

## Project Name and Meaning

The name **Apariamin** is derived from the following components:

- **Apa**che, the popular open-source web server.
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

## Quick Start

VSCode is optional and only needed for step debugging. Everything else works from a terminal, as long as Docker is running. Run these commands from the workspace root.

**1. Create the configuration files**

```bash
cp .env-example .env
cp example_docker-compose.override.dev.yml docker-compose.override.yml
```

Open `.env`, enter the database root password, database name, username, and user password, then uncomment `COMPOSE_PROFILES=dev` so phpMyAdmin starts.

**2. Build and start the containers**

```bash
docker compose up -d --build
```

**3. Check that it works**

| Service    | URL                     | Expected result                                              |
|------------|-------------------------|--------------------------------------------------------------|
| Web page   | http://127.0.0.1:8000   | The "UTC and Local Time" page is displayed.                  |
| phpMyAdmin | http://127.0.0.1:8090   | You are logged in automatically and your database is listed. |

MariaDB takes about 20 to 30 seconds to become ready, especially on the first start. If phpMyAdmin shows a connection error such as `Connection refused` right after startup, wait a moment and refresh the page.

**4. Edit pages**

Edit the files in `www/`, save them, and refresh the browser. The folder is mounted into the container, so no rebuild is needed. Rebuild with the command in step 2 only after changing the `Dockerfile` or the files next to it.

**5. Stop and restart**

```bash
docker compose stop    # stop the containers
docker compose up -d   # start them again
```

## Component Versions

Verified on 2026-11-10:

| Component  | Version                | Source                      | Used in          |
|------------|------------------------|-----------------------------|------------------|
| PHP        | 8.5.12                 | `php:8.5-apache`            | All environments |
| Apache     | 2.4.69                 | Included in the PHP image   | All environments |
| MariaDB    | 11.4.13                | `mariadb:11.4.13-ubi9`      | All environments |
| Xdebug     | 3.5.3                  | `pecl install xdebug`       | Development only |
| phpMyAdmin | 5.2.3 (on PHP 8.3.36)  | `phpmyadmin:latest`         | `dev` profile only |

Only MariaDB is pinned to an exact version. The other components can move to newer releases when images are rebuilt or pulled. To check the PHP version in use, run `docker compose exec web php -v`.

## Initial Setup

### 1. Open the Cloned Repository in VSCode and Install Recommended Extensions

After cloning the repository, open the project folder in VSCode.  
When prompted, install the recommended extensions for the workspace.  

If a prompt appears asking for an executable PHP extension, you can safely ignore it.

Skip this step if you are not using VSCode.

### 2. Create `.env` File from Example

Create the `.env` file from the provided example to configure the database and other environment variables. Use the command below:

```bash
cp .env-example .env
```
**Ensure this command is executed from the workspace root.**

Edit the `.env` file as needed to enter the database root password, database name, username, and user password.

For development, also uncomment `COMPOSE_PROFILES=dev` to start phpMyAdmin. It is not started otherwise.

### 3. Configure `docker-compose.override.yml` for Development

For development environments, create the `docker-compose.override.yml` file from the provided example to use a dedicated database volume for development, build the web image with Xdebug, and prevent containers from restarting automatically. Use the command below:

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
| `Apariamin Compose build`                     | Builds the Docker images using `docker-compose.yml` and `docker-compose.override.yml`. |
| `Apariamin Compose up`                        | Starts containers in detached mode with development override configuration. |
| `Apariamin Compose up with rebuild image`     | Rebuilds images and starts containers (useful after changing the `Dockerfile`). To get a newer base image, see [Applying Security Updates](#applying-security-updates). |
| `Apariamin Compose stop`                      | Stops running containers without removing them. |
| `Apariamin Compose remove containers`          | Stops and removes containers (equivalent to `docker compose down`). |
| `Apariamin Compose remove volume storage(dev)`| Removes the development database volume `apariamin_db_data_dev`. |
| `Apariamin open web and phpmyadmin in browser`| Opens the development web page and phpMyAdmin in your default browser. |


## Running on a Production Server
Clone the repository, then create and configure the `.env` file. Do not create `docker-compose.override.yml` or enable `COMPOSE_PROFILES=dev` on a production server, so that it runs without Xdebug and phpMyAdmin.  
After completing the setup, run the following command **from the workspace root** to start the containers:

```bash
docker compose up -d
```

To stop the containers without removing them, use the following command:

```bash
docker compose stop
```

## Applying Security Updates

A plain rebuild can reuse an old base image, so use the commands below to get the latest patches. MariaDB is pinned to a specific version: to update it, change its image tag in `docker-compose.yml` first.

```bash
# 1. Back up the database, then check that backup.sql is not empty
docker compose exec -T db sh -c 'exec mariadb-dump --all-databases -uroot -p"$MYSQL_ROOT_PASSWORD"' > backup.sql

# 2. Pull the latest images and rebuild
docker compose build --pull --no-cache web
docker compose pull --ignore-buildable
docker compose up -d

# 3. Confirm the running PHP version
docker compose exec web php -v
```

## Debug PHP Code

Debugging requires `docker-compose.override.yml` from the setup steps, because only the development image includes Xdebug.

Press `F5` in VSCode to launch the debugger. This rebuilds and starts the containers automatically, and stops them when debugging ends.  

Xdebug will communicate through port `9003`.  
(This is just a reference for information purposes and does not require any action from the developer.)

Access the web page by navigating to:

```text
http://127.0.0.1:8000
```

Set breakpoints in your PHP code and test the functionality on the PHP-based web page. You can inspect variable values and step through the code during execution.

To access phpMyAdmin (requires `COMPOSE_PROFILES=dev` in `.env`), open your browser and navigate to:

```text
http://127.0.0.1:8090
```

### Note
All ports are bound to `127.0.0.1`, assuming a separate reverse proxy, such as Nginx, will be used.