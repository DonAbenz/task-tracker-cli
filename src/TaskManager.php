<?php

namespace TaskTrackerCli;

class TaskManager
{
   private $tasks;
   private $taskFilePath = __DIR__ . '/../data.json';

   public function __construct()
   {
      if (!file_exists($this->taskFilePath)) {
         file_put_contents($this->taskFilePath, json_encode([], JSON_PRETTY_PRINT));
      }

      $this->tasks = (array) json_decode(file_get_contents($this->taskFilePath), true);
   }

   public function addTask($description)
   {
      $data = $this->tasks;
      $id = count($data) > 0 ? max(array_column($data, 'id')) + 1 : 1;

      $data[$id] = [
         "id" => $id,
         "description" => $description,
         "status" => "todo",
         "createdAt" => date("Y-m-d H:i:s"),
         "updatedAt" => date("Y-m-d H:i:s")
      ];

      $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
      $insert = file_put_contents($this->taskFilePath, $json);

      if ($insert) {
         echo "Task added successfully\n";
         $this->displayTasks([$data[$id]]);
      } else {
         echo "Failed to add task\n";
      }
   }

   public function updateTaskById($id, $description)
   {
      $data = $this->tasks;

      $taskIndex = array_search($id, array_column($data, 'id'));
      if ($taskIndex === false) {
         echo "Task with ID $id not found\n";
         return;
      }

      $data[$taskIndex]['description'] = $description;
      $data[$taskIndex]['updatedAt'] = date("Y-m-d H:i:s");

      $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
      $insert = file_put_contents($this->taskFilePath, $json);

      if ($insert) {
         echo "Task updated successfully\n";
         $this->displayTasks([$data[$taskIndex]]);
      } else {
         echo "Failed to update task\n";
      }
   }

   public function deleteTaskById($id)
   {
      $data = $this->tasks;

      $taskIndex = array_search($id, array_column($data, 'id'));
      if ($taskIndex === false) {
         echo "Task with ID $id not found\n";
         return;
      }

      unset($data[$taskIndex]);

      $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
      $insert = file_put_contents($this->taskFilePath, $json);

      if ($insert) {
         echo "Task deleted successfully\n";
         $this->displayTasks($data);
      } else {
         echo "Failed to delete task\n";
      }
   }

   public function markTaskInProgress($id)
   {
      $data = $this->tasks;

      $taskIndex = array_search($id, array_column($data, 'id'));
      if ($taskIndex === false) {
         echo "Task with ID $id not found\n";
         return;
      }

      $data[$taskIndex]['status'] = 'in-progress';
      $data[$taskIndex]['updatedAt'] = date("Y-m-d H:i:s");

      $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
      $insert = file_put_contents($this->taskFilePath, $json);

      if ($insert) {
         echo "Task marked as in-progress successfully\n";
         $this->displayTasks([$data[$taskIndex]]);
      } else {
         echo "Failed to mark task as in-progress\n";
      }
   }

   public function markTaskDone($id)
   {
      $data = $this->tasks;

      $taskIndex = array_search($id, array_column($data, 'id'));
      if ($taskIndex === false) {
         echo "Task with ID $id not found\n";
         return;
      }

      $data[$taskIndex]['status'] = 'done';
      $data[$taskIndex]['updatedAt'] = date("Y-m-d H:i:s");

      $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
      $insert = file_put_contents($this->taskFilePath, $json);

      if ($insert) {
         echo "Task marked as done successfully\n";
         $this->displayTasks([$data[$taskIndex]]);
      } else {
         echo "Failed to mark task as done\n";
      }
   }

   public function getTasksByStatus($status = null)
   {
      $filteredTasks = $status ? array_filter($this->tasks, function ($task) use ($status) {
         return isset($task['status']) && $task['status'] === $status;
      }) : $this->tasks;

      if (empty($filteredTasks)) {
         echo "No tasks found \n";
         return;
      }

      $this->displayTasks($filteredTasks);
   }

   private function displayTasks($tasks)
   {
      $headers = ['id', 'description', 'status', 'createdAt', 'updatedAt'];

      $widths = array_map(function ($header) use ($tasks) {
         $maxLength = strlen($header);
         foreach ($tasks as $row) {
            $value = $row[$header];
            $maxLength = max($maxLength, strlen((string) $value));
         }
         return $maxLength;
      }, $headers);

      $this->printSeparatorLine($widths);
      $this->printRow($headers, $widths);
      $this->printSeparatorLine($widths);

      foreach ($tasks as $row) {
         $rowData = array_map(function ($header) use ($row) {
            return $row[$header];
         }, $headers);
         $this->printRow($rowData, $widths);
      }

      $this->printSeparatorLine($widths);
   }

   private function printSeparatorLine($widths)
   {
      echo '+';
      foreach ($widths as $width) {
         echo str_repeat('-', $width + 2) . '+';
      }
      echo PHP_EOL;
   }

   private function printRow($row, $widths)
   {
      echo '|';
      foreach ($row as $key => $value) {
         printf(" %-{$widths[$key]}s |", $value);
      }
      echo PHP_EOL;
   }
}
