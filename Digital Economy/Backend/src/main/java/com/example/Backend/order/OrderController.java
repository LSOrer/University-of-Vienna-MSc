package com.example.Backend.order;

import com.example.Backend.exception.OrderNotFoundException;
import lombok.AllArgsConstructor;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@CrossOrigin
@RestController
@RequestMapping("api/orders")
@AllArgsConstructor
public class OrderController {

    private final OrderService orderService;

    @GetMapping
    public List<Order> fetchAllOrders() {
        return orderService.getAllOrders();
    }

    @PostMapping(consumes = "application/json", produces = "application/json")
    @ResponseBody
    public Order newOrder(@RequestBody Order order) {
        return orderService.saveNewOrder(order);
    }

    @GetMapping(path = "/{orderid}")
    @ResponseBody
    public Order showOrderWithId(@PathVariable String orderid) {
        try {
            return orderService.findOrder(orderid);
        } catch (OrderNotFoundException e) {
            return new Order();
        }
    }

    @PutMapping
    @ResponseBody
    public Order updateOrder(@RequestBody Order order) {
        try {
            return orderService.updateOrder(order);
        } catch (OrderNotFoundException e) {
            return new Order();
        }
    }


    @DeleteMapping(path = "/{orderid}")
    public String deleteOrder(@PathVariable String orderid) {
        return orderService.deleteOrder(orderid);
    }

    @DeleteMapping
    public String deleteAllOrders() {
        orderService.deleteAll();
        return "Success";
    }


}