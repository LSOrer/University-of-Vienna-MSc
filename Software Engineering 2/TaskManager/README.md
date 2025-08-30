Software Engineering 2 @ the University of Vienna

1st Programming and Design Task

1.    Task: Task Management Application Implementation
Realize the following small programming project in Java using the insights from Lectures 1-3.

Task Class: Create a Task class with attributes like task name, description, due date, and status (i.e., whether the task is completed). 
TaskManager Class: Implement a TaskManager class responsible for managing tasks. This class will include methods for adding tasks, updating tasks, searching for tasks, displaying tasks, etc. Use proper data structures (e.g., ArrayList or HashMap) to store and manage tasks.
Coding Conventions: Follow Java coding conventions for naming variables, classes, methods, and packages. Maintain consistent indentation and formatting to enhance code readability.
Input Handling: Implement proper input validation and handling. Ensure that inputs for task names, descriptions, due dates, etc., are checked adequately for correctness to prevent issues like SQL injection, cross-site scripting, and invalid data.
Exception Handling: Implement robust exception handling throughout the application. Handle scenarios like invalid input, null references, out-of-bounds indices, and other potential errors gracefully. Create custom exceptions for specific error cases if needed.
Logging: Incorporate logging using a logging framework like Log4j or java.util.logging to capture relevant information, errors, and events during the application's execution.
Testing: Write unit tests using JUnit or another testing framework to ensure the correctness of your methods and the application as a whole. Test edge cases and scenarios where exceptions might be thrown. Write at least 10 test cases for the TaskManager class.

2.    Task: Task Management Application Design
To apply your UML design skills, design a task management application in three stages, each as a class diagram.

Stage 1: The application design should contain notions of tasks and a task manager, as described in Task 1 above. Additionally, represent a single application user with username, email, and password properties. Add task categories representing different categories or tags that can be assigned to tasks. Each task could belong to one or more categories.
Stage 2: Consider that your task management involves organizing tasks into projects. The single user of the application can have tasks without a project association and tasks that are organized into projects.
Stage 3: Consider your application supports collaborative task management in teams of users. That is, now the application has multiple users, and they can organize themselves in teams. Still, each user can have tasks and projects independently, and each team can have tasks and projects.
Realize all three stages as class diagrams in PlantUML code (https://plantuml.com/de/class-diagram). 
You can use PlantText to work interactively with PlantUML (https://www.planttext.com/).

In addition, explain how your resulting design supports the design principles discussed in the lecture.
