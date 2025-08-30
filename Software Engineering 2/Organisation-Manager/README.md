Software Engineering 2 @ the University of Vienna

3rd Programming and Design Task

Task: Developing an Organizational Hierarchy System
Design and implement an organizational hierarchy system in Java to represent and manage the structures of an organization effectively. Utilize design patterns to create a flexible to navigate and interact with organizational structure.

Organization and its Members: Develop mechanisms to add, remove, and reassign employees to departments. Ensure that each department has a manager. Implement methods for retrieving a department's manager and members. Each employee should have a name to identify them within the organization. Employees should have a defined position or job title. Assign a unique identification number to each employee. Track the salary or compensation for each employee.

Organizational Hierarchy (Composite Pattern): Create a hierarchical structure using the Composite pattern representing an organization, where departments and individual employees are part of a composite structure. Departments should have properties like names and a manager. Implement sub-departments within departments for efficient organization.

Enable employees to be members of multiple departments without copying the employee objects to each of these other departments. Can a pattern be used for this task? If Java provides pre-defined interfaces or classes for this pattern, you can use them in your solution.

Realize a search for employees by different criteria, including the name contains a string, the ID, the position includes a string, and the salary is in a particular range. Can a pattern be used for this task? If Java provides pre-defined interfaces or classes for this pattern, you can use them in your solution.

Consider your system needs to offer its service to an external system that requires the employee data as JSON strings. You agreed on the following interface:


public interface ExternalEmployee {
    // returns a JSON string with all employee data
    public String getEmployeeData();
}
Provide functionality to convert the employees in your system to this interface. Can a pattern be used for this task? If Java provides pre-defined interfaces or classes for this pattern, you can use them in your solution.

Write a Facade class for your organization. Consider the functionalities listed above and consider which should be represented on your Facade.

Write unit tests using JUnit or another testing framework to ensure the correctness of your methods and the application as a whole. Test edge cases and scenarios where exceptions might be thrown. Write sufficient test cases for each of the subtasks above.

Model your resulting solution in PlantUML as a class diagram (https://plantuml.com/de/class-diagram). You can use PlantText to work interactively with PlantUML (https://www.planttext.com/).
