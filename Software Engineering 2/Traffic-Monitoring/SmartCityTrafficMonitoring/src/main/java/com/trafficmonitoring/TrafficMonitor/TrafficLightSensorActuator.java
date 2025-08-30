package com.trafficmonitoring.TrafficMonitor;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class TrafficLightSensorActuator extends Device {
    private static final Logger logger = LoggerFactory.getLogger(TrafficLightSensorActuator.class);

    private LightStatus lightStatus = LightStatus.RED;

    public TrafficLightSensorActuator(String name) {
        super(name);
    }

    public void setLightStatus(LightStatus status) {
        lightStatus = status;
        String event = "Traffic light status changed: " + status + " (Device: " + getName() + ")";
        addToEventHistory(event);
        logger.info(event);
    }

    public LightStatus getLightStatus() {
        return lightStatus;
    }
}