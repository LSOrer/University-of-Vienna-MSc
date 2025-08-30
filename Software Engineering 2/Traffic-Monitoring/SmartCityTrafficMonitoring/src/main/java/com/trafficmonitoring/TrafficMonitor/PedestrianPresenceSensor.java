package com.trafficmonitoring.TrafficMonitor;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class PedestrianPresenceSensor extends Device {
    private static final Logger logger = LoggerFactory.getLogger(PedestrianPresenceSensor.class);

    private boolean pedestrianPresent = false;

    public PedestrianPresenceSensor(String name) {
        super(name);
    }

    public void setPedestrianPresent(boolean presence) {
        pedestrianPresent = presence;
        String event = "Pedestrian presence detected: " + presence + " (Device: " + getName() + ")";
        addToEventHistory(event);
        logger.info(event);
    }

    public boolean isPedestrianPresent() {
        return pedestrianPresent;
    }
}