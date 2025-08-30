package com.system.OrganizationManager;

import java.util.HashSet;
import java.util.Set;

public class Employee implements OrganizationComponent {
    private static int idCounter = 0;
    private int id;
    private String name;
    private String position;
    private double salary;
    private Set<Department> departments;

    public Employee(String name, String position, double salary) {
        this.id = ++idCounter;
        this.name = name;
        this.position = position;
        this.salary = salary;
        this.departments = new HashSet<>();
    }

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getPosition() {
        return position;
    }

    public void setPosition(String position) {
        this.position = position;
    }

    public double getSalary() {
        return salary;
    }

    public void setSalary(double salary) {
        this.salary = salary;
    }

    public void addDepartment(Department department) {
        if (!departments.contains(department)) {
            departments.add(department);
            department.addMember(this, false); // Pass false to avoid recursion
        }
    }

    public void removeDepartment(Department department) {
        departments.remove(department);
        department.removeMember(this);
    }

    @Override
    public void printDetails() {
        System.out.println("Employee: " + name + ", Position: " + position);
    }
}