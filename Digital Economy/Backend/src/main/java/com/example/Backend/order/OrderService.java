package com.example.Backend.order;

import com.example.Backend.exception.OrderNotFoundException;
import lombok.AllArgsConstructor;
import org.springframework.stereotype.Service;

import java.util.List;

@AllArgsConstructor
@Service
public class OrderService {

    private final OrderRepo orderRepo;

    public List<Order> getAllOrders() {
        return orderRepo.findAll();
    }

    public Order saveNewOrder(Order order) {
        return orderRepo.insert(order);
    }

    public Order findOrder(String orderid) {
        for (Order order : orderRepo.findAll()) {
            if (order.getOrderId().equals(orderid)) {
                return order;
            }
        }
        throw new OrderNotFoundException(String.format("order with id %s does not exist", orderid));
    }

    public Order updateOrder(Order order) {
        return orderRepo.save(order);
    }

    public String deleteOrder(String orderid) {
        return orderRepo.deleteByOrderId(orderid);
    }

    public void deleteAll() {
        orderRepo.deleteAll();
    }
}