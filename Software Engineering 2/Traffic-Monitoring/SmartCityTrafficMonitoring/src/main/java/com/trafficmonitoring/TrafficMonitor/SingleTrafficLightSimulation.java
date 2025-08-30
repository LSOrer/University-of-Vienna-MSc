package com.trafficmonitoring.TrafficMonitor;

import java.util.List;

public class SingleTrafficLightSimulation extends TrafficSimulation {

    private TrafficLightSensorActuator trafficLight;
    private VehiclePresenceSensor vehiclePresenceSensor;
    private PedestrianPresenceSensor pedestrianPresenceSensor;

    public SingleTrafficLightSimulation(List<Observer> observers) {
        super(observers);
        this.trafficLight = new TrafficLightSensorActuator("Single Traffic Light");
        this.vehiclePresenceSensor = new VehiclePresenceSensor("Vehicle Presence Sensor");
        this.pedestrianPresenceSensor = new PedestrianPresenceSensor("Pedestrian Presence Sensor");
    }

    @Override
    public void simulate(int steps) {
        for (int i = 0; i < steps; i++) {
            // Use the common logging method from TrafficSimulation
            logSimulationEvent("Simulation step: " + i);

            // Example simulation events:
            simulateLightColorChange(LightStatus.GREEN);
            simulateVehiclePresence(true);
            simulatePedestrianPresence(true);

            if (i % 5 == 0) {
                // Every 5 steps, simulate a change in traffic light color
                simulateLightColorChange(LightStatus.RED);
            }

            if (i % 7 == 0) {
                // Every 7 steps, simulate the arrival of a vehicle
                simulateVehiclePresence(true);
            }

            if (i % 9 == 0) {
                // Every 9 steps, simulate the presence of a pedestrian
                simulatePedestrianPresence(true);
            }

            // Simulate a pause between steps (for illustration purposes)
            try {
                Thread.sleep(1000); // Sleep for 1 second
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
        }
    }

    @Override
    protected void simulateLightColorChange(LightStatus newColor) {
        trafficLight.setLightStatus(newColor);
        logSimulationEvent("Traffic light changed to " + newColor);
    }

    @Override
    protected void simulateVehiclePresence(boolean presence) {
        vehiclePresenceSensor.setVehiclePresent(presence);
        logSimulationEvent("Vehicle presence: " + presence);
    }

    @Override
    protected void simulatePedestrianPresence(boolean presence) {
        pedestrianPresenceSensor.setPedestrianPresent(presence);
        logSimulationEvent("Pedestrian presence: " + presence);
    }

    @Override
    public void addObserver(Observer observer) {

    }

    @Override
    public void removeObserver(Observer observer) {

    }

    @Override
    public void notifyObservers(String event) {

    }
}
