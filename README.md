# About Apariamin

**Apa** - Apache  
**ria** - MariaDB  
**min** - phpMyAdmin  

This project is a Docker Compose-based alternative to XAMPP, providing a lightweight and modular setup for both local development and production environments.

## License

This project is licensed under the MIT License. See the LICENSE file for details.

## Buy me a ko-fi
[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/B0B21CR05U)

## Initial Setup

### 1. Open the Cloned Repository in VSCode and Install Recommended Extensions

After cloning the repository, open the project folder in VSCode.  
When prompted, install the recommended extensions for the workspace.  

If a prompt appears asking for an executable PHP extension, you can safely ignore it.

### 2. Copy `.env-example` to `.env`

Run the following command in your project root to create a `.env` file:

```bash
cp .env-example .env
```

Edit the `.env` file as needed to enter the database root password, database name, username, and user password.

### 3. Configure `docker-compose.override.yml` for Development

For development environments, apply the following configuration to use a dedicated database volume for development and prevent containers from restarting automatically. Copy the `docker-compose.override.dev.yml` file to `docker-compose.override.yml`:

```bash
cp [WORKSPACE_PATH]/docker-compose.override.dev.yml docker-compose.override.yml
```

Replace `[WORKSPACE_PATH]` with the appropriate path to your workspace.


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
| `Apariamin open phpmyadmin in browser`| Opens phpMyAdmin in your default browser at `http://localhost:8090`. |


## Running on a Production Server
Clone the repository and complete step 1 of the Initial Setup.  
Run `docker compose up -d` or `docker-compose up -d` from the workspace path to operate on the production server.

## Debug PHP Code

To debug PHP code, start the containers using the `docker-compose up` task.  
Then press `F5` in VSCode to launch the debugger. Xdebug will communicate through port `9003`.  
Access the web page via 127.0.0.1:8080.  
Set breakpoints in your PHP code and test the functionality on the PHP-based web page.  
You can inspect variable values and step through the code during execution.

### Note
1. All ports are bound to `127.0.0.1` assuming a separate reverse proxy, such as Nginx, will be used.
