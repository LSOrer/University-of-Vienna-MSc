package com.system.OrganizationManager;

public class EmployeeSalarySpecification implements Specification<Employee> {
    private double minSalary;
    private double maxSalary;

    public EmployeeSalarySpecification(double minSalary, double maxSalary) {
        this.minSalary = minSalary;
        this.maxSalary = maxSalary;
    }

    @Override
    public boolean isSatisfied(Employee employee) {
        return employee.getSalary() >= minSalary && employee.getSalary() <= maxSalary;
    }
}