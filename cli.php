#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$command = $argv[1] ?? null;
$arg1 = $argv[2] ?? null;
$arg2 = $argv[3] ?? null;

$taskManager = new TaskTrackerCli\TaskManager();

match ($command) {
   'add' => $taskManager->addTask($arg1),
   'update' => $taskManager->updateTask($arg1, $arg2),
   'list' => $taskManager->getAllTasks(),
   default => print "Invalid command\n",
};
