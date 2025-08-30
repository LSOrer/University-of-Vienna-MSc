package com.taskmanager.TaskManager;

import static org.junit.Assert.*;

import org.junit.Test;

public class TaskManagerTests {

    @Test
    public void testAddTask() {
        TaskManager taskManager = new TaskManager();
        Task task = new Task("Test Task", "Description", "2023-12-31");
        taskManager.addTask(task);
        assertEquals(1, taskManager.getAllTasks().size());
    }

    @Test
    public void testUpdateTaskStatus() throws TaskException {
        TaskManager taskManager = new TaskManager();
        Task task = new Task("Test Task", "Description", "2023-12-31");
        taskManager.addTask(task);
        taskManager.updateTaskStatus("Test Task", true);
        assertTrue(taskManager.getAllTasks().get(0).isCompleted());
    }

    @Test
    public void testSearchTasks() {
        TaskManager taskManager = new TaskManager();
        Task task1 = new Task("Task 1", "Description 1", "2023-11-01");
        Task task2 = new Task("Task 2", "Description 2", "2023-11-15");
        taskManager.addTask(task1);
        taskManager.addTask(task2);
        assertEquals(1, taskManager.searchTasks("Description 1").size());
    }

    @Test
    public void testGetAllTasks() {
        TaskManager taskManager = new TaskManager();
        Task task1 = new Task("Task 1", "Description 1", "2023-11-01");
        Task task2 = new Task("Task 2", "Description 2", "2023-11-15");
        taskManager.addTask(task1);
        taskManager.addTask(task2);
        assertEquals(2, taskManager.getAllTasks().size());
    }

    @Test
    public void testUpdateTaskStatusNonExistentTask() {
        TaskManager taskManager = new TaskManager();
        Task task = new Task("Test Task", "Description", "2023-12-31");
        taskManager.addTask(task);
        try {
            taskManager.updateTaskStatus("Non-Existent Task", true);
            fail("Expected TaskException was not thrown.");
        } catch (TaskException e) {
            assertEquals("Task not found: Non-Existent Task", e.getMessage());
        }
    }

    @Test
    public void testSearchTasksNoMatchingTasks() {
        TaskManager taskManager = new TaskManager();
        Task task = new Task("Test Task", "Description", "2023-12-31");
        taskManager.addTask(task);
        assertEquals(0, taskManager.searchTasks("Non-Matching").size());
    }
}