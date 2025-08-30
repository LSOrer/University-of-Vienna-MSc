package com.system.OrganizationManager;

import org.junit.jupiter.api.Test;
import org.springframework.boot.test.context.SpringBootTest;

import static org.junit.jupiter.api.Assertions.*;

@SpringBootTest
class OrganizationManagerApplicationTests {

	@Test
	public void testAddDepartment() {
		Organization organization = new Organization();
		organization.addDepartment(new Department("IT"));
		organization.addDepartment(new Department("HR"));

		// Check if departments are added
		assertEquals(2, organization.getDepartments().size());
	}

	@Test
	public void testReassignEmployee() {
		Organization organization = new Organization();
		Department department1 = new Department("IT");
		Department department2 = new Department("HR");
		Employee employee = new Employee("John Doe", "Developer", 80000);

		department1.addMember(employee);
		organization.reassignEmployee(employee, department1, department2);

		// Check if employee is moved to department2
		assertFalse(department1.getEmployees().contains(employee));
		assertTrue(department2.getEmployees().contains(employee));
	}

	@Test
	public void testAddEmployeeToMultipleDepartments() {
		Department itDepartment = new Department("IT");
		Department hrDepartment = new Department("HR");
		Employee employee = new Employee("Jane Doe", "HR Manager", 90000);

		itDepartment.addMember(employee);
		hrDepartment.addMember(employee);

		// Check if employee is in both departments
		assertTrue(itDepartment.getEmployees().contains(employee));
		assertTrue(hrDepartment.getEmployees().contains(employee));
	}

	@Test
	public void testAddNullEmployee() {
		Department department = new Department("IT");

		// This should throw a NullPointerException
		assertThrows(NullPointerException.class, () -> department.addMember(null));
	}

	@Test
	public void testAddAndRemoveSubDepartment() {
		Department department = new Department("IT");
		Department subDepartment = new Department("Software Development");

		department.addSubDepartment(subDepartment);
		assertTrue(department.getSubDepartments().contains(subDepartment));

		department.removeSubDepartment(subDepartment);
		assertFalse(department.getSubDepartments().contains(subDepartment));
	}

	@Test
	public void testDepartmentManagerAssignment() {
		Department department = new Department("IT");
		Employee manager = new Employee("John Manager", "IT Manager", 95000);

		department.setManager(manager);

		assertEquals(manager, department.getManager());
	}

	@Test
	public void testEmployeeDetailsUpdate() {
		Employee employee = new Employee("Alice", "Developer", 75000);

		employee.setName("Alice Smith");
		employee.setPosition("Senior Developer");
		employee.setSalary(80000);

		assertEquals("Alice Smith", employee.getName());
		assertEquals("Senior Developer", employee.getPosition());
		assertEquals(80000, employee.getSalary(), 0.0);
	}

}
