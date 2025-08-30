package com.taskmanager.TaskManager;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import java.io.IOException;
import java.util.List;

@SpringBootApplication
public class TaskManagerApplication {

    public static void main(String[] args) throws IOException, TaskException {
        SpringApplication.run(TaskManagerApplication.class, args);

        TaskManager taskManager = new TaskManager();
        TaskInput taskInput = new TaskInput(taskManager);

        // Example usage of the TaskManager class
        Task task1 = new Task("Task 1", "Description 1", "2023-11-01");
        Task task2 = new Task("Task 2", "Description 2", "2023-11-15");
        taskManager.addTask(task1);
        taskManager.addTask(task2);

        taskManager.updateTaskStatus("Task 1", true);

        taskInput.addTaskFromCLI();

        List<Task> searchedTasks = taskManager.searchTasks("Task");
        System.out.println("Display searched tasks:");
        for (Task task : searchedTasks) {
            System.out.println("Task: " + task.getTaskName() + ", Description: " + task.getDescription() + ", Status: " + task.isCompleted());
        }

        taskInput.updateTaskNameFromCLI();

        List<Task> allTasks = taskManager.getAllTasks();
        System.out.println("Display all tasks:");
        for (Task task : allTasks) {
            System.out.println("Task: " + task.getTaskName() + ", Description: " + task.getDescription() + ", Status: " + task.isCompleted());
        }
    }
}