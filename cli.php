#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$command = $argv[1] ?? null;
$arg1 = $argv[2] ?? null;

$taskManager = new TaskTrackerCli\TaskManager();

match ($command) {
   'add' => $taskManager->addTask($arg1),
   'list' => $taskManager->getAllTasks(),
   default => print "Invalid command\n",
};
