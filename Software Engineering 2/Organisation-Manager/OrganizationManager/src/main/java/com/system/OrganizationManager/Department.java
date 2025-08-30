package com.system.OrganizationManager;

import java.util.ArrayList;
import java.util.List;
import java.util.HashSet;
import java.util.Set;

public class Department implements OrganizationComponent {
    private String name;
    private Employee manager;
    private List<OrganizationComponent> members;
    private Set<Employee> employees;
    private List<Department> subDepartments;

    public Department(String name) {
        this.name = name;
        this.members = new ArrayList<>();
        this.employees = new HashSet<>();
        this.subDepartments = new ArrayList<>();
    }

    public String getName(){
        return name;
    }

    public void setManager(Employee manager) {
        this.manager = manager;
    }

    public Employee getManager() {
        return manager;
    }

    public void addEmployee(Employee employee) {
        employees.add(employee);
    }

    public void removeEmployee(Employee employee) {
        employees.remove(employee);
    }

    public List<Employee> getEmployees() {
        return new ArrayList<>(employees);
    }

    public void addMember(Employee employee, boolean updateEmployee) {
        if (!employees.contains(employee)) {
            employees.add(employee);
            if (updateEmployee) {
                employee.addDepartment(this); // Call addDepartment only if updateEmployee is true
            }
        }
    }

    public void addMember(Employee employee) {
        addMember(employee, true); // Default behavior is to update employee
    }

    public void removeMember(Employee employee) {
        employees.remove(employee);
        employee.removeDepartment(this);
    }

    public void addSubDepartment(Department subDepartment) {
        subDepartments.add(subDepartment);
    }

    public void removeSubDepartment(Department subDepartment) {
        subDepartments.remove(subDepartment);
    }
    public List<Department> getSubDepartments() {
        return subDepartments;
    }

    @Override
    public void printDetails() {
        System.out.println("Department: " + name);
        if (manager != null) {
            System.out.println("  Manager: " + manager.getName());
        }
        for (OrganizationComponent member : members) {
            member.printDetails();
        }
        for (Department subDept : subDepartments) {
            subDept.printDetails();
        }
    }

}