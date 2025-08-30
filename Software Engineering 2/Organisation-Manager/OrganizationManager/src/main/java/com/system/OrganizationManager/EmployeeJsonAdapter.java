package com.system.OrganizationManager;

public class EmployeeJsonAdapter implements ExternalEmployee {
    private Employee employee;

    public EmployeeJsonAdapter(Employee employee) {
        this.employee = employee;
    }

    @Override
    public String getEmployeeData() {
        return String.format(
                "{\"name\":\"%s\", \"position\":\"%s\", \"salary\":%.2f}",
                employee.getName(),
                employee.getPosition(),
                employee.getSalary()
        );
    }
}