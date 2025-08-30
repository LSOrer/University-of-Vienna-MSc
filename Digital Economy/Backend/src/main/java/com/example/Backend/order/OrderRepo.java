package com.example.Backend.order;

import org.springframework.data.mongodb.repository.MongoRepository;

public interface OrderRepo extends MongoRepository<Order, Integer> {
    String deleteByOrderId(String oderid);
}