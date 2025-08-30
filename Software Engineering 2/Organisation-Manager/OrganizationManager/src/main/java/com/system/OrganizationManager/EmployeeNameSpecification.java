package com.system.OrganizationManager;

public class EmployeeNameSpecification implements Specification<Employee> {
    private String nameToMatch;

    public EmployeeNameSpecification(String nameToMatch) {
        this.nameToMatch = nameToMatch.toLowerCase();
    }

    @Override
    public boolean isSatisfied(Employee employee) {
        return employee.getName().toLowerCase().contains(nameToMatch);
    }
}