package com.example.Backend.user;

import com.example.Backend.exception.UserNotFoundException;
import lombok.AllArgsConstructor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@CrossOrigin
@RestController
@RequestMapping("api/users")
@AllArgsConstructor
public class UserController {

    @Autowired
    private UserRepo userRepo;

    @GetMapping
    public List<User> fetchAllUsers() {
        return userRepo.findAll();
    }

    @PostMapping(consumes = "application/json", produces = "application/json")
    @ResponseBody
    public User newUser(@RequestBody User user) {
        return userRepo.save(user);
    }

    @RequestMapping(value = "/{username}")
    @ResponseBody
    public User showUserWithId(@PathVariable String username) {
        for (User user : userRepo.findAll()) {
            if (user.getUsername().equals(username)) {
                return user;
            }
        }
        throw new UserNotFoundException(String.format("user %s does not exist", username));
    }

    @DeleteMapping(path = "/{username}")
    public String deleteuser(@PathVariable String username) {
        return userRepo.deleteByUsername(username);
    }


}
