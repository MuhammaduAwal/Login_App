package com.example.andriodlog.models;

public class ApiResponse {
    private int status;
    private String message;
    private User data;

    public ApiResponse(int status, String message, User data) {
        this.status = status;
        this.message = message;
        this.data = data;
    }

    public int getStatus() {
        return status;
    }

    public String getMessage() {
        return message;
    }

    public User getData() {
        return data;
    }
}
