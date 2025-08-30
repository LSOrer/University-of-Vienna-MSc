package com.taskmanager.TaskManager;

public class Task {

    // Task class
    private String taskName;
    private String description;
    private String dueDate;
    private boolean isCompleted;

    public Task(String taskName, String description, String dueDate) {
        this.taskName = taskName;
        this.description = description;
        this.dueDate = dueDate;
        this.isCompleted = false;
    }

    public String getTaskName() {
        return taskName;
    }

    public String getDescription() {
        return description;
    }

    public String getDueDate() {
        return dueDate;
    }

    public boolean isCompleted() {
        return isCompleted;
    }

    public void setCompleted(boolean completed) {
        isCompleted = completed;
    }

}