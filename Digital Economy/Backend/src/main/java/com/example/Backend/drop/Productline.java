package com.example.Backend.drop;

import lombok.Data;
import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

@Data
@Document
public class Productline {
    @Id
    private String productlineid;
    private String manufacturer;
    private String productname;
    private String productdesc;
    private Double unitprice;
    private String picturelink;
}
