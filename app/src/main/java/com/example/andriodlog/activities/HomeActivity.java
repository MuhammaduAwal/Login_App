package com.example.andriodlog.activities;

import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

import androidx.activity.OnBackPressedCallback;
import androidx.appcompat.app.AppCompatActivity;

import com.example.andriodlog.R;
import com.example.andriodlog.models.User;
import com.example.andriodlog.utils.SharedPrefManager;
import com.google.android.material.button.MaterialButton;

public class HomeActivity extends AppCompatActivity {

    private TextView textViewWelcome;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        textViewWelcome = findViewById(R.id.textViewWelcome);
        MaterialButton buttonLogout = findViewById(R.id.buttonLogout);

        User user = SharedPrefManager.getInstance(this).getUser();
        textViewWelcome.setText("Welcome, " + user.getName() + "!");

        buttonLogout.setOnClickListener(v -> {
            SharedPrefManager.getInstance(HomeActivity.this).logout();
            Intent intent = new Intent(HomeActivity.this, LoginActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intent);
        });

        // Disable back button
        getOnBackPressedDispatcher().addCallback(this, new OnBackPressedCallback(true) {
            @Override
            public void handleOnBackPressed() {
                // Do nothing to disable back button
            }
        });
    }
}
