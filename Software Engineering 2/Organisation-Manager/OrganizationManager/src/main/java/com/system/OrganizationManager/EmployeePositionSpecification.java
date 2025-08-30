package com.system.OrganizationManager;

public class EmployeePositionSpecification implements Specification<Employee> {
    private String positionToMatch;

    public EmployeePositionSpecification(String positionToMatch) {
        this.positionToMatch = positionToMatch.toLowerCase();
    }

    @Override
    public boolean isSatisfied(Employee employee) {
        return employee.getPosition().toLowerCase().contains(positionToMatch);
    }
}