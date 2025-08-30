package com.system.OrganizationManager;

import java.util.ArrayList;
import java.util.List;

public class Organization {
    private List<Department> departments;

    public Organization() {
        departments = new ArrayList<>();
    }

    public void addDepartment(Department department) {
        departments.add(department);
    }

    public void reassignEmployee(Employee employee, Department fromDepartment, Department toDepartment) {
        if (fromDepartment != null && toDepartment != null) {
            fromDepartment.removeEmployee(employee);
            toDepartment.addEmployee(employee);
        }
    }

    public List<Department> getDepartments() {
        return departments;
    }

}
