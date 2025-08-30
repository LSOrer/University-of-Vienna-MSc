package com.example.Backend.user;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.Data;
import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.index.Indexed;
import org.springframework.data.mongodb.core.mapping.Document;

@Data
@Document
public class User {
    @Id
    private String userid;
    @Indexed(unique = true)
    @JsonProperty("username")
    private String username;
    @JsonProperty("password")
    private String password;
    @JsonProperty("api_token")
    private String api_token;
    @JsonProperty("usertype")
    private String usertype;

    public User(String username, String password, String api_token, String usertype) {
        this.username = username;
        this.password = password;
        this.api_token = api_token;
        this.usertype = usertype;
    }

    public User() {
    }

    public String getUserid() {
        return userid;
    }

    public String getUsername() {
        return username;
    }

    public String getPassword() {
        return password;
    }

    public String getApi_token() {
        return api_token;
    }

    public String getUsertype() {
        return usertype;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public void setApi_token(String api_token) {
        this.api_token = api_token;
    }

    public void setUsertype(String usertype) {
        this.usertype = usertype;
    }
}
