package com.trafficmonitoring.TrafficMonitor;

import java.util.ArrayList;
import java.util.List;

public class HistoryObserver implements Observer {
    private List<String> history = new ArrayList<>();

    @Override
    public void update(String event) {
        history.add(event);
    }

    public List<String> getHistory() {
        return history;
    }
}