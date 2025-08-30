package com.example.Backend.ordergraphql;


import com.example.Backend.order.OrderRepo;
import graphql.schema.DataFetcher;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.util.stream.Collectors;

@Component
public class GraphQLDataFetchers {

    @Autowired
    OrderRepo orderRepo;

    public DataFetcher ordersOfUserDataFetcher() {
        return dataFetchingEnvironment -> orderRepo.findAll().stream().filter(order -> order.getUserid().startsWith(dataFetchingEnvironment.getArgument("userid"))).collect(Collectors.toList());
    }

    public DataFetcher allOrdersDataFetcher() {
        return dataFetchingEnvironment -> orderRepo.findAll();
    }

}
