package com.example.Backend.order.data;

import lombok.Data;

@Data
public class Address {
    // all strings because it's only used for displaying information
    private String street;
    private String number;
    private String zip;
    private String country;
}
