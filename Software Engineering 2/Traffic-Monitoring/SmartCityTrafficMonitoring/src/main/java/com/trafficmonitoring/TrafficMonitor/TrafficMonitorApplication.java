package com.trafficmonitoring.TrafficMonitor;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

import java.util.List;
import java.util.Scanner;
import java.util.logging.FileHandler;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.logging.SimpleFormatter;

@SpringBootApplication
public class TrafficMonitorApplication {

	private static final Logger logger = Logger.getLogger(TrafficMonitorApplication.class.getName());

	static {
		try {
			FileHandler fileHandler = new FileHandler("traffic_monitor_history.log");
			fileHandler.setFormatter(new SimpleFormatter());
			logger.addHandler(fileHandler);
			logger.setLevel(Level.ALL);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public static void main(String[] args) {
		try {
			SpringApplication.run(TrafficMonitorApplication.class, args);

			// Create observers
			ConsoleOutputObserver consoleObserver = new ConsoleOutputObserver();
			HistoryObserver historyObserver = new HistoryObserver();

			// Create the subject
			SingleTrafficLightSimulation simulation = new SingleTrafficLightSimulation(List.of(consoleObserver, historyObserver));
			TrafficSimulation fourWayTrafficLightSimulation = new FourWayTrafficLightSimulation(List.of(consoleObserver, historyObserver));

			// Attach observers to the SingleTrafficLightSimulation
			simulation.addObserver(consoleObserver);
			simulation.addObserver(historyObserver);

			// Attach observer to FourTrafficLightSimulation
			fourWayTrafficLightSimulation.addObserver(consoleObserver);
			fourWayTrafficLightSimulation.addObserver(historyObserver);

			// User input for simulation steps
			Scanner scanner = new Scanner(System.in);
			int simulationSteps;

			while (true) {
				System.out.print("Enter the number of simulation steps (between 1 and 500): ");
				while (!scanner.hasNextInt()) {
					System.out.println("Please enter a valid integer.");
					scanner.next(); // consume the invalid input
				}
				simulationSteps = scanner.nextInt();
				if (simulationSteps >= 1 && simulationSteps <= 500) {
					break;
				} else {
					System.out.println("Please enter a number between 1 and 500.");
				}
			}

			// Simulate events and observe the reactions

			// Run the main simulation
			simulation.simulate(simulationSteps);
			fourWayTrafficLightSimulation.simulate(simulationSteps);


			// Use the history observer for tests
			List<String> history = historyObserver.getHistory();
			for (String event : history) {
				System.out.println("History Event: " + event);
			}


			System.out.println("Simulation completed.\n\n");

		} catch (Exception e) {
			logger.log(Level.SEVERE, "An error occurred during simulation.", e);
		}
	}
}
