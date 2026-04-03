package com.example.localisationsmartphone;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.location.LocationProvider;
import android.os.Bundle;
import android.provider.Settings;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Random;

public class MainActivity extends AppCompatActivity {

    private double latitude;
    private double longitude;
    private double altitude;
    private float accuracy;

    private RequestQueue requestQueue;
    private TextView tvInfo;

    private String insertUrl = "http://192.168.1.11/localisation/createPosition.php";

    // 🔐 Code généré une seule fois
    private String sessionCode;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        tvInfo = findViewById(R.id.tvInfo);
        requestQueue = Volley.newRequestQueue(getApplicationContext());

        // 🎯 Génération du code 4 chiffres (une seule fois)
        sessionCode = generateCode4Digits();

        LocationManager locationManager =
                (LocationManager) getSystemService(Context.LOCATION_SERVICE);

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED
                && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

            ActivityCompat.requestPermissions(this,
                    new String[]{
                            Manifest.permission.ACCESS_FINE_LOCATION,
                            Manifest.permission.ACCESS_COARSE_LOCATION
                    }, 1);
            return;
        }

        locationManager.requestLocationUpdates(
                LocationManager.GPS_PROVIDER,
                60000,
                2,
                new LocationListener() {
                    @Override
                    public void onLocationChanged(Location location) {

                        latitude = location.getLatitude();
                        longitude = location.getLongitude();
                        altitude = location.getAltitude();
                        accuracy = location.getAccuracy();

                        String msg = "Latitude : " + latitude
                                + "\nLongitude : " + longitude
                                + "\nAltitude : " + altitude
                                + "\nPrécision : " + accuracy + " m"
                                + "\nCode : " + sessionCode;

                        tvInfo.setText(msg);

                        Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG).show();

                        addPosition(latitude, longitude);
                    }

                    @Override
                    public void onStatusChanged(String provider, int status, Bundle extras) {}

                    @Override
                    public void onProviderEnabled(String provider) {}

                    @Override
                    public void onProviderDisabled(String provider) {}
                }
        );
    }

    // 🎯 Générer un code à 4 chiffres
    private String generateCode4Digits() {
        Random random = new Random();
        int code = 1000 + random.nextInt(9000); // entre 1000 et 9999
        return String.valueOf(code);
    }

    private void addPosition(final double lat, final double lon) {

        JSONObject json = new JSONObject();

        try {
            SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
            String currentDate = sdf.format(new Date());

            String deviceId = Settings.Secure.getString(
                    getContentResolver(),
                    Settings.Secure.ANDROID_ID
            );

            json.put("latitude", lat);
            json.put("longitude", lon);
            json.put("date_position", currentDate);
            json.put("imei", deviceId);

            // 🔥 Ajout du code
            json.put("code", sessionCode);

        } catch (Exception e) {
            e.printStackTrace();
        }

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.POST,
                insertUrl,
                json,
                response -> Toast.makeText(this,
                        response.toString(),
                        Toast.LENGTH_LONG).show(),

                error -> {
                    Toast.makeText(this,
                            "Erreur: " + error.toString(),
                            Toast.LENGTH_LONG).show();
                    error.printStackTrace();
                }
        );

        requestQueue.add(request);
    }
}