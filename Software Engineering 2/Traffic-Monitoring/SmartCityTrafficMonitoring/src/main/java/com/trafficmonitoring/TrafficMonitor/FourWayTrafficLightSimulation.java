package com.trafficmonitoring.TrafficMonitor;

import java.util.List;

public class FourWayTrafficLightSimulation extends TrafficSimulation {

    private TrafficLightSensorActuator trafficLightNorth;
    private TrafficLightSensorActuator trafficLightSouth;
    private TrafficLightSensorActuator trafficLightEast;
    private TrafficLightSensorActuator trafficLightWest;

    private VehiclePresenceSensor vehiclePresenceSensorNorth;
    private VehiclePresenceSensor vehiclePresenceSensorSouth;
    private VehiclePresenceSensor vehiclePresenceSensorEast;
    private VehiclePresenceSensor vehiclePresenceSensorWest;

    private PedestrianPresenceSensor pedestrianPresenceSensorNorth;
    private PedestrianPresenceSensor pedestrianPresenceSensorSouth;
    private PedestrianPresenceSensor pedestrianPresenceSensorEast;
    private PedestrianPresenceSensor pedestrianPresenceSensorWest;

    public FourWayTrafficLightSimulation(List<Observer> observers) {
        super(observers);
        this.trafficLightNorth = new TrafficLightSensorActuator("Traffic Light North");
        this.trafficLightSouth = new TrafficLightSensorActuator("Traffic Light South");
        this.trafficLightEast = new TrafficLightSensorActuator("Traffic Light East");
        this.trafficLightWest = new TrafficLightSensorActuator("Traffic Light West");

        this.vehiclePresenceSensorNorth = new VehiclePresenceSensor("Vehicle Presence North");
        this.vehiclePresenceSensorSouth = new VehiclePresenceSensor("Vehicle Presence South");
        this.vehiclePresenceSensorEast = new VehiclePresenceSensor("Vehicle Presence East");
        this.vehiclePresenceSensorWest = new VehiclePresenceSensor("Vehicle Presence West");

        this.pedestrianPresenceSensorNorth = new PedestrianPresenceSensor("Pedestrian Presence North");
        this.pedestrianPresenceSensorSouth = new PedestrianPresenceSensor("Pedestrian Presence South");
        this.pedestrianPresenceSensorEast = new PedestrianPresenceSensor("Pedestrian Presence East");
        this.pedestrianPresenceSensorWest = new PedestrianPresenceSensor("Pedestrian Presence West");
    }

    @Override
    public void simulate(int steps) {
        for (int i = 0; i < steps; i++) {
            logSimulationEvent("Simulation step: " + i);

            // Example simulation events for a four-way traffic light pattern:
            simulateTrafficLightChange(trafficLightNorth, LightStatus.GREEN);
            simulateTrafficLightChange(trafficLightSouth, LightStatus.RED);
            simulateTrafficLightChange(trafficLightEast, LightStatus.RED);
            simulateTrafficLightChange(trafficLightWest, LightStatus.RED);

            simulateVehiclePresence(vehiclePresenceSensorNorth, true);
            simulateVehiclePresence(vehiclePresenceSensorSouth, false);
            simulateVehiclePresence(vehiclePresenceSensorEast, false);
            simulateVehiclePresence(vehiclePresenceSensorWest, false);

            simulatePedestrianPresence(pedestrianPresenceSensorNorth, true);
            simulatePedestrianPresence(pedestrianPresenceSensorSouth, false);
            simulatePedestrianPresence(pedestrianPresenceSensorEast, false);
            simulatePedestrianPresence(pedestrianPresenceSensorWest, false);
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

    }

    @Override
    protected void simulateVehiclePresence(boolean presence) {

    }

    @Override
    protected void simulatePedestrianPresence(boolean presence) {

    }

    private void simulateTrafficLightChange(TrafficLightSensorActuator trafficLight, LightStatus newColor) {
        trafficLight.setLightStatus(newColor);
        logSimulationEvent(trafficLight.getName() + " changed to " + newColor);
    }

    private void simulateVehiclePresence(VehiclePresenceSensor sensor, boolean presence) {
        sensor.setVehiclePresent(presence);
        logSimulationEvent("Vehicle presence on " + sensor.getName() + ": " + presence);
    }

    private void simulatePedestrianPresence(PedestrianPresenceSensor sensor, boolean presence) {
        sensor.setPedestrianPresent(presence);
        logSimulationEvent("Pedestrian presence on " + sensor.getName() + ": " + presence);
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
