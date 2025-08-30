package com.taskmanager.TaskManager;

import org.junit.Before;
import org.junit.Test;
import static org.junit.Assert.*;
import org.springframework.boot.test.context.SpringBootTest;

@SpringBootTest
public class TaskManagerApplicationTests {

    private Task task;

    @Before
    public void setUp() {
        // Create a new Task object before each test
        task = new Task("Test Task", "Test Description", "2023-12-31");
    }

    @Test
    public void testGetTaskName() {
        assertEquals("Test Task", task.getTaskName());
    }

    @Test
    public void testGetDescription() {
        assertEquals("Test Description", task.getDescription());
    }

    @Test
    public void testGetDueDate() {
        assertEquals("2023-12-31", task.getDueDate());
    }

    @Test
    public void testIsCompleted() {
        assertFalse(task.isCompleted());
    }

    @Test
    public void testSetCompleted() {
        task.setCompleted(true);
        assertTrue(task.isCompleted());
    }

}
