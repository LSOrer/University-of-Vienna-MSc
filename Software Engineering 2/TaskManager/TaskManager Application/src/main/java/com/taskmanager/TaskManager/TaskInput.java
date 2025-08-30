package com.taskmanager.TaskManager;

import java.util.Scanner;
import java.util.regex.Pattern;

public class TaskInput {
    private TaskManager taskManager;
    private Scanner scanner;

    public TaskInput(TaskManager taskManager) {
        this.taskManager = taskManager;
        this.scanner = new Scanner(System.in);
    }

    public void addTaskFromCLI() {
        System.out.println("Create a new task! Enter the following details;");

        String taskName = getValidInput("Task Name: ", "^[\\w\\s]{1,50}$"); // Valid task name: 1-50 characters, letters, digits, spaces
        String description = getValidInput("Description: ", "^[\\w\\s]{0,100}$"); // Valid description: Up to 100 characters, letters, digits, spaces
        String dueDate = getValidInput("Due Date (yyyy-mm-dd): ", "^[0-9]{4}-[0-9]{2}-[0-9]{2}$"); // Valid date format

        Task task = new Task(taskName, description, dueDate);
        taskManager.addTask(task);

        System.out.println("Task added successfully.");
    }

    private String getValidInput(String prompt, String regexPattern) {
        String input;
        boolean isValid = false;
        Scanner scanner = new Scanner(System.in);

        do {
            System.out.print(prompt);
            input = scanner.nextLine().trim();

            if (Pattern.matches(regexPattern, input)) {
                isValid = true;
            } else {
                System.out.println("Invalid input. Please enter a valid value.");
            }
        } while (!isValid);

        return input;
    }

    public void updateTaskNameFromCLI() {
        System.out.print("Enter the name of the task you want to update: ");
        String taskName = getValidInput("Task Name: ", "^[\\w\\s]{1,50}$"); // Valid task name: 1-50 characters, letters, digits, spaces
        boolean newStatus = Boolean.parseBoolean(getValidInput("Is the task completed? (true or false): ", "^(true|false)$")); // Valid status: true or false

        try {
            taskManager.updateTaskStatus(taskName, newStatus);
            System.out.println("Task updated successfully.");
        } catch (TaskException e) {
            System.out.println(e.getMessage());
        }
    }
}