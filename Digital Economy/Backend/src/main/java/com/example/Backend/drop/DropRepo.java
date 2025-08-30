package com.example.Backend.drop;

import org.springframework.data.mongodb.repository.MongoRepository;

public interface DropRepo extends MongoRepository<Drop, String> {
    String deleteByDropid(String dropid);
}
 