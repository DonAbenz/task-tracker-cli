<?php

namespace TaskTrackerCli;

use TaskTrackerCli\Task;

class TaskManager
{
   private array $tasks = [];
   private string $taskFilePath;

   public function __construct()
   {
      $this->taskFilePath = __DIR__ . '/../data.json';

      if (!file_exists($this->taskFilePath)) {
         file_put_contents($this->taskFilePath, json_encode([], JSON_PRETTY_PRINT));
      }

      $this->loadTasksFromFile();
   }

   private function loadTasksFromFile(): void
   {
      $data = json_decode(file_get_contents($this->taskFilePath), true);
      $this->tasks = array_map(fn($taskData) => new Task(
         $taskData['id'],
         $taskData['description'],
         $taskData['status'],
         $taskData['createdAt'],
         $taskData['updatedAt']
      ), $data);
   }

   private function saveTasksToFile(): bool
   {
      $data = array_map(fn(Task $task) => $task->toArray(), $this->tasks);
      $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
      return file_put_contents($this->taskFilePath, $json) !== false;
   }

   public function addTask(string $description): void
   {
      $id = count($this->tasks) > 0 ? max(array_map(fn(Task $task) => $task->getId(), $this->tasks)) + 1 : 1;
      $task = new Task($id, $description);
      $this->tasks[] = $task;

      if ($this->saveTasksToFile()) {
         echo "\n ✅ Task added successfully (ID: " . $task->getId() . ") \n";
      } else {
         echo "Failed to add task\n";
      }
   }

   public function updateTaskById(int $id, string $description): void
   {
      $task = $this->findTaskById($id);
      if (!$task) {
         echo "Task with ID $id not found\n";
         return;
      }

      $task->setDescription($description);

      if ($this->saveTasksToFile()) {
         echo "\n ✅ Task updated successfully (ID: " . $task->getId() . ") \n";
      } else {
         echo "Failed to update task\n";
      }
   }

   public function deleteTaskById(int $id): void
   {
      $this->tasks = array_filter($this->tasks, fn(Task $task) => $task->getId() !== $id);

      if ($this->saveTasksToFile()) {
         echo "\n ✅ Task deleted successfully (ID: " . $id . ") \n";
      } else {
         echo "Failed to delete task\n";
      }
   }

   public function markTaskInProgress(int $id): void
   {
      $task = $this->findTaskById($id);
      if (!$task) {
         echo "Task with ID $id not found\n";
         return;
      }

      $task->setStatus('in-progress');

      if ($this->saveTasksToFile()) {
         echo "\n ✅ Task marked as in-progress\n";
      } else {
         echo "Failed to mark task as done\n";
      }
   }

   public function markTaskDone(int $id): void
   {
      $task = $this->findTaskById($id);
      if (!$task) {
         echo "Task with ID $id not found\n";
         return;
      }

      $task->setStatus('done');

      if ($this->saveTasksToFile()) {
         echo "\n ✅ Task marked as done\n";
      } else {
         echo "Failed to mark task as done\n";
      }
   }

   public function getTasksByStatus(?string $status = null): void
   {
      $filteredTasks = $status
         ? array_filter($this->tasks, fn(Task $task) => $task->getStatus() === $status)
         : $this->tasks;

      if (empty($filteredTasks)) {
         echo "No tasks found with status: " . ($status ?? "all") . "\n";
         return;
      }

      echo "Tasks with status: " . ($status ?? "all") . "\n";
      $this->displayTasks($filteredTasks);
   }

   private function findTaskById(int $id): ?Task
   {
      foreach ($this->tasks as $task) {
         if ($task->getId() === $id) {
            return $task;
         }
      }
      return null;
   }

   private function displayTasks(array $tasks): void
   {
      $headers = ['id', 'description', 'status', 'createdAt', 'updatedAt'];
      $widths = $this->calculateColumnWidths($tasks, $headers);

      $this->printSeparatorLine($widths);
      $this->printRow($headers, $widths);
      $this->printSeparatorLine($widths);

      foreach ($tasks as $task) {
         $row = $task->toArray();
         $rowData = array_map(fn($header) => $row[$header], $headers);
         $this->printRow($rowData, $widths);
      }

      $this->printSeparatorLine($widths);
   }

   private function calculateColumnWidths(array $tasks, array $headers): array
   {
      return array_map(function ($header) use ($tasks) {
         $maxLength = strlen($header);
         foreach ($tasks as $task) {
            $row = $task->toArray();
            $maxLength = max($maxLength, strlen((string) $row[$header]));
         }
         return $maxLength;
      }, $headers);
   }

   private function printSeparatorLine(array $widths): void
   {
      echo '+';
      foreach ($widths as $width) {
         echo str_repeat('-', $width + 2) . '+';
      }
      echo PHP_EOL;
   }

   private function printRow(array $row, array $widths): void
   {
      echo '|';
      foreach ($row as $key => $value) {
         printf(" %-{$widths[$key]}s |", $value);
      }
      echo PHP_EOL;
   }
}
