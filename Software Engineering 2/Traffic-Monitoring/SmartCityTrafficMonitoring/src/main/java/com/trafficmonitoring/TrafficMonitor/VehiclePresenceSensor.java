package com.trafficmonitoring.TrafficMonitor;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class VehiclePresenceSensor extends Device {
    private static final Logger logger = LoggerFactory.getLogger(VehiclePresenceSensor.class);

    private boolean vehiclePresent = false;

    public VehiclePresenceSensor(String name) {
        super(name);
    }

    public boolean isVehiclePresent() {
        return vehiclePresent;
    }

    public void setVehiclePresent(boolean presence) {
        vehiclePresent = presence;
        String event = "Vehicle presence detected: " + presence + " (Device: " + getName() + ")";
        addToEventHistory(event);
        logger.info(event);
    }
}