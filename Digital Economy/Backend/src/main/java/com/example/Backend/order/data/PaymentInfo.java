package com.example.Backend.order.data;

import lombok.Data;

@Data
public class PaymentInfo {
    // all strings because it's only used for displaying information
    private String ccnumber;
    private String expirydate;
    private String cvv;
}
