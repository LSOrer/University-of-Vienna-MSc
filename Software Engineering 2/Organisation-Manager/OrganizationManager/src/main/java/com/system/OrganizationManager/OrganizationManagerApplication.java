package com.system.OrganizationManager;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

import java.util.ArrayList;
import java.util.List;
import java.util.stream.Collectors;

@SpringBootApplication
public class OrganizationManagerApplication {

	public static void main(String[] args) {SpringApplication.run(OrganizationManagerApplication.class, args);
		Organization myOrganization = new Organization();

		// Create departments
		Department headOffice = new Department("Head Office");
		Department sales = new Department("Sales");
		Department marketing = new Department("Marketing");
		Department research = new Department("Research");
		Department development = new Department("Development");

		// Sub-departments
		Department onlineSales = new Department("Online Sales");
		Department retailSales = new Department("Retail Sales");
		sales.addSubDepartment(onlineSales);
		sales.addSubDepartment(retailSales);

		myOrganization.addDepartment(headOffice);
		myOrganization.addDepartment(sales);
		myOrganization.addDepartment(marketing);
		myOrganization.addDepartment(research);
		myOrganization.addDepartment(development);

		// Create employees
		Employee alice = new Employee("Alice", "CEO", 200000);
		Employee bob = new Employee("Bob", "Sales Manager", 100000);
		Employee charlie = new Employee("Charlie", "Marketing Manager", 95000);
		Employee dave = new Employee("Dave", "Developer", 80000);
		Employee eve = new Employee("Eve", "Researcher", 85000);

		// Create a employeeList to search for employees with specific criteria
		List<Employee> employeeList = new ArrayList<>();
		employeeList.add(alice);
		employeeList.add(bob);
		employeeList.add(charlie);
		employeeList.add(dave);
		employeeList.add(eve);

		// Set managers for each department
		headOffice.setManager(alice);
		sales.setManager(bob);
		marketing.setManager(charlie);
		research.setManager(eve);
		development.setManager(dave);

		// Add employees to departments
		alice.addDepartment(headOffice);
		bob.addDepartment(sales);
		charlie.addDepartment(marketing);
		dave.addDepartment(development);
		eve.addDepartment(research);

		// Employees in multiple departments
		eve.addDepartment(development); // Eve also works in Development
		dave.addDepartment(research); // Dave also works in Research

		// Add departments to head office
		headOffice.addSubDepartment(sales);
		headOffice.addSubDepartment(marketing);
		headOffice.addSubDepartment(research);
		headOffice.addSubDepartment(development);

		// Print organization details
		printOrganizationDetails(myOrganization);


		// Search for employees with name containing "Alice"
		Specification<Employee> nameSpec = new EmployeeNameSpecification("Alice");
		List<Employee> foundByName = employeeList.stream()
				.filter(nameSpec::isSatisfied)
				.collect(Collectors.toList());

		// Search for employees with ID 2
		Specification<Employee> idSpec = new EmployeeIdSpecification(2);
		List<Employee> foundById = employeeList.stream()
				.filter(idSpec::isSatisfied)
				.collect(Collectors.toList());

		// Search for employees with position containing "Manager" and salary between 50000 and 100000
		Specification<Employee> positionSpec = new EmployeePositionSpecification("Manager");
		Specification<Employee> salarySpec = new EmployeeSalarySpecification(50000, 100000);
		Specification<Employee> combinedSpec = positionSpec.and(salarySpec);
		List<Employee> foundByPositionAndSalary = employeeList.stream()
				.filter(combinedSpec::isSatisfied)
				.collect(Collectors.toList());

		// Output results of the name search
		System.out.println("Employees found by name containing 'Alice':");
		foundByName.forEach(employee -> System.out.println(employee.getName()));

		// Output results of the position and salary search
		System.out.println("Employees found by position containing 'Manager' and salary between 50000 and 100000:");
		foundByPositionAndSalary.forEach(employee -> System.out.println(employee.getName() + " - " + employee.getPosition() + " - $" + employee.getSalary()));

		// Create external employee to test the employee json interface
		ExternalEmployee externalEmployee = new EmployeeJsonAdapter(alice);

		String employeeJson = externalEmployee.getEmployeeData();
		System.out.println("JSON of employee Alice: " + employeeJson);
	}
	private static void printOrganizationDetails(Organization org) {
		for (Department dept : org.getDepartments()) {
			System.out.println("Department: " + dept.getName());
			System.out.println("  Manager: " + dept.getManager().getName());
			System.out.print("  Employees: ");
			for (Employee emp : dept.getEmployees()) {
				System.out.print(emp.getName() + " ");
			}
			System.out.println("\n");
		}
	}

}


