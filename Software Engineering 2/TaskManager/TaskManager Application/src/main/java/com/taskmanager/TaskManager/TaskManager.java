package com.taskmanager.TaskManager;

import java.util.ArrayList;
import java.util.List;
import java.util.logging.Logger;
import java.util.logging.FileHandler;
import java.util.logging.SimpleFormatter;

public class TaskManager {

    private List<Task> tasks;
    private static final Logger logger = Logger.getLogger(TaskManager.class.getName());

    public TaskManager() {
        tasks = new ArrayList<>();
        try {
            // Setup logging
            FileHandler fileHandler = new FileHandler("taskmanager.log");
            fileHandler.setFormatter(new SimpleFormatter());
            logger.addHandler(fileHandler);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // Method to add a new task
    public void addTask(Task task) {
        tasks.add(task);
        logger.info("new task added");
    }

    // Method to update the status of a task
    public void updateTaskStatus(String taskName, boolean isCompleted) throws TaskException {
        for (Task task : tasks) {
            if (task.getTaskName().equals(taskName)) {
                task.setCompleted(isCompleted);
                logger.info("Task status updated: " + taskName);
                return;
            }
        }
        throw new TaskException("Task not found: " + taskName);
    }

    // Method to search for tasks
    public List<Task> searchTasks(String keyword) {
        List<Task> matchingTasks = new ArrayList<>();
        for (Task task : tasks) {
            if (task.getTaskName().contains(keyword) || task.getDescription().contains(keyword)) {
                matchingTasks.add(task);
            }
        }
        return matchingTasks;
    }

    // Method to display all tasks
    public List<Task> getAllTasks() {
        return tasks;
    }
}