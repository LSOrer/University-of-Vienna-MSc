package com.trafficmonitoring.TrafficMonitor;

import java.util.ArrayList;
import java.util.List;
import java.util.logging.Logger;

public abstract class TrafficSimulation implements Subject {
    private List<Observer> observers;
    protected Logger logger = Logger.getLogger(getClass().getName());
    public TrafficSimulation(List<Observer> observers) {
        this.observers = new ArrayList<>(observers);
    }

    public abstract void simulate(int steps);

    protected void logSimulationEvent(String event) {
        logger.info(event);
        notifyObservers(event);
    }

    protected abstract void simulateLightColorChange(LightStatus newColor);

    protected abstract void simulateVehiclePresence(boolean presence);

    protected abstract void simulatePedestrianPresence(boolean presence);

    @Override
    public void addObserver(Observer observer) {
        observers.add(observer);
    }

    @Override
    public void removeObserver(Observer observer) {
        observers.remove(observer);
    }

    public void notifyObservers(String event) {
        for (Observer observer : observers) {
            observer.update(event);
        }
    }
}
