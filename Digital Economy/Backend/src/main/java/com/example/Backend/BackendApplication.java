package com.example.Backend;

import com.example.Backend.user.User;
import com.example.Backend.user.UserRepo;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.data.mongodb.core.MongoTemplate;
import org.springframework.data.mongodb.core.query.Criteria;
import org.springframework.data.mongodb.core.query.Query;

@SpringBootApplication
public class BackendApplication {

    public static void main(String[] args) {
        SpringApplication.run(BackendApplication.class, args);
    }

    @Bean
    CommandLineRunner runner(UserRepo repository, MongoTemplate mongoTemplate) {
        return args -> {

            User admin = new User(
                    "Admin",
                    "Admin3",
                    "ADMINAPITOKEN",
                    "Admin"
            );

            User business = new User(
                    "Business",
                    "Business3",
                    "BUSINESSAPITOKEN",
                    "Business"
            );

            User consumer = new User(
                    "Consumer",
                    "Consumer3",
                    "CONSUMERAPITOKEN",
                    "Consumer"
            );

            if (mongoTemplate.find(new Query().addCriteria(Criteria.where("username").is("Admin")), User.class).isEmpty()) {
                System.out.println("User has been inserted " + admin.getUsername());
                repository.insert(admin);
            }
            if (mongoTemplate.find(new Query().addCriteria(Criteria.where("username").is("Business")), User.class).isEmpty()) {
                System.out.println("User has been inserted " + business.getUsername());
                repository.insert(business);
            }
            if (mongoTemplate.find(new Query().addCriteria(Criteria.where("username").is("Consumer")), User.class).isEmpty()) {
                System.out.println("User has been inserted " + consumer.getUsername());
                repository.insert(consumer);
            }
            System.out.println("Default users created");
        };
    }
}
