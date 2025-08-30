package com.trafficmonitoring.TrafficMonitor;

import java.util.ArrayList;
import java.util.List;

public abstract class Device {
    private String name;
    private List<String> eventHistory;

    public Device(String name) {
        setName(name);
        eventHistory = new ArrayList<>();
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public List<String> getEventHistory() {
        return eventHistory;
    }

    protected void addToEventHistory(String event) {
        eventHistory.add(event);
    }
}