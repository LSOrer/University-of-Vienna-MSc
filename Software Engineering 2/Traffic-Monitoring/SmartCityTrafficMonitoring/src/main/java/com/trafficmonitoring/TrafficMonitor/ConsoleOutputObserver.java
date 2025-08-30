package com.trafficmonitoring.TrafficMonitor;

public class ConsoleOutputObserver implements Observer {
    @Override
    public void update(String event) {
        System.out.println("Console Output: " + event);
    }
}
