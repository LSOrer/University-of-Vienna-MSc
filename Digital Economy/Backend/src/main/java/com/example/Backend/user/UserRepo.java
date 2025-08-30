package com.example.Backend.user;

import org.springframework.data.mongodb.repository.MongoRepository;

public interface UserRepo extends MongoRepository<User, Integer> {
    String deleteByUsername(String username);
}
