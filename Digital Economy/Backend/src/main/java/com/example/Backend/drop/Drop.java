package com.example.Backend.drop;

import lombok.Data;
import org.springframework.data.annotation.Id;

import java.util.ArrayList;
import java.util.List;


@Data
public class Drop {
    @Id
    private String dropid;
    private String startdate;
    private String enddate;
    private List<Productline> productlines = new ArrayList<>();
    private String api_token;
    private Integer qtyupperlimit;
}
