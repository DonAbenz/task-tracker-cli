# Task Tracker CLI

Task Tracker CLI is a command-line application inspired by the [Task Tracker Roadmap](https://roadmap.sh/projects/task-tracker). It provides a simple and efficient way to manage tasks directly from the terminal. The application allows users to add, update, delete, and track the status of tasks while maintaining a modular and scalable structure.

## Features

-  **Add Tasks**: Create new tasks with a description.
-  **Update Tasks**: Modify the description of existing tasks.
-  **Delete Tasks**: Remove tasks by their ID.
-  **Track Status**: Mark tasks as `todo`, `in-progress`, or `done`.
-  **List Tasks**: View tasks filtered by their status or list all tasks.
-  **Persistent Storage**: Tasks are stored in a JSON file for persistence.

## Table of Contents

-  [Installation](#installation)
-  [Usage](#usage)
   -  [Commands](#commands)
-  [Project Structure](#project-structure)
-  [Requirements](#requirements)

## Installation

1. Clone the repository:

```bash
   git clone https://github.com/DonAbenz/task-tracker-cli.git
   cd task-tracker-cli
```

2. Install dependencies using Composer:

```bash
   composer install
```

3. Ensure the `data.json` file exists in the root directory. If not, it will be created automatically.

## Usage

Run the CLI application using PHP:

```bash
   php cli.php <command> [arguments]
```

## Commands

-  Add a Task:

```bash
   php cli.php add "Task description"
```

-  Update a Task:

```bash
   php cli.php update <task_id> "Updated description"
```

-  Delete a Task:

```bash
   php cli.php delete <task_id>
```

-  Mark a Task as In-Progress:

```bash
   php cli.php mark-in-progress <task_id>
```

-  Mark a Task as Done:

```bash
   php cli.php mark-done <task_id>
```

-  List Tasks:

```bash
   php cli.php list
```

```bash
   php cli.php list <status>
```

## Project Structure

-  `src/Task.php`: Defines the Task class, representing individual tasks.
-  `src/TaskManager.php`: Manages task operations such as adding, updating, deleting, and listing tasks.
-  `cli.php`: Entry point for the CLI application.
-  `data.json`: Stores task data in JSON format.
-  `composer.json`: Manages project dependencies and autoloading.

## Requirements

-  PHP 8.0 or higher
-  Composer
