package com.example.Backend.order;

import com.example.Backend.drop.Product;
import com.example.Backend.order.data.Address;
import com.example.Backend.order.data.PaymentInfo;
import lombok.Data;
import org.springframework.data.annotation.Id;

import java.util.ArrayList;
import java.util.List;

@Data
public class Order {
    @Id
    private String orderId;
    private String userid;
    private String dropid;
    private Address address;
    private PaymentInfo paymentinfo;
    private List<Product> products = new ArrayList<>();
}
