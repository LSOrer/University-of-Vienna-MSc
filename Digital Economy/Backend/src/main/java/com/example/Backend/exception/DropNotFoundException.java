package com.example.Backend.exception;

public class DropNotFoundException extends RuntimeException {
    public DropNotFoundException(String message) {
        super(message);
    }
}
