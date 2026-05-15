package com.example.andriodlog.api;

import com.example.andriodlog.models.ApiResponse;
import com.example.andriodlog.models.LoginRequest;
import com.example.andriodlog.models.RegisterRequest;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;

public interface ApiService {

    @POST("auth/login.php")
    Call<ApiResponse> login(@Body LoginRequest loginRequest);

    @POST("auth/register.php")
    Call<ApiResponse> register(@Body RegisterRequest registerRequest);
}
