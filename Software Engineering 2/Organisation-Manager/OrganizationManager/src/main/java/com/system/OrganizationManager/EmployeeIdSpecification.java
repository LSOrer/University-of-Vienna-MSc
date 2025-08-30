package com.system.OrganizationManager;

public class EmployeeIdSpecification implements Specification<Employee> {
    private int idToMatch;

    public EmployeeIdSpecification(int idToMatch) {
        this.idToMatch = idToMatch;
    }

    @Override
    public boolean isSatisfied(Employee employee) {
        return employee.getId() == idToMatch;
    }
}