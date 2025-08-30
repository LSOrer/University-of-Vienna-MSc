package com.system.OrganizationManager;

public interface Specification<T> {
    boolean isSatisfied(T item);

    default Specification<T> and(Specification<T> other) {
        return item -> isSatisfied(item) && other.isSatisfied(item);
    }

}