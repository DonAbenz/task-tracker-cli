#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$command = $argv[1] ?? null;
$arg1 = $argv[2] ?? null;
$arg2 = $argv[3] ?? null;

$taskManager = new TaskTrackerCli\TaskManager();

match ($command) {
   'add' => $taskManager->addTask($arg1),
   'update' => $taskManager->updateTaskById($arg1, $arg2),
   'delete' => $taskManager->deleteTaskById($arg1),
   'mark-in-progress' => $taskManager->markTaskInProgress($arg1),
   'mark-done' => $taskManager->markTaskDone($arg1),
   'list' => $taskManager->getTasksByStatus($arg1),
   default => print "Invalid command\n",
};
