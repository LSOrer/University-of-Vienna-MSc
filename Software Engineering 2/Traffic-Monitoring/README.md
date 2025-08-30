Software Engineering 2 @ the University of Vienna

2nd Programming and Design Task

Task: Extending a Simple Traffic Monitoring System
Consider that your team is tasked with developing a traffic monitoring system for a smart city project. The system must collect traffic data from various sensors at traffic lights or intersections, process it, and present it to users differently. It will use actuators to realize smart behavior. Consider further that a colleague started with a simple prototype, realizing three device (sensor/actuator) types, and built a simple simulation of a single pedestrian traffic light. You can find the implementation at below.

In a code review, your team identified a couple of suggestions for improvements for the subsequent development step:

1. Currently, the simulation uses System.out.println() for printing simulation steps and device invocations to the console. While this is okay at this very early development stage, it is foreseeable that understanding the state of the simulation and the sensors needs to be extended. For instance, later on, a GUI for the simulation might be added, sensors and actuators might be linked to real devices, the device state needs to be observed by a production UI, the system’s events need to be logged, a statistical processor might be needed, and so on. For now, an immediate extension needed would be a history of simulation and sensor events. This history could help improve the simulations’ tests, such as SingleTrafficLightSimulationTest, which is incomplete as all interesting information can only be observed in the console output. 
A colleague suggests that the Observer pattern can be used to observe the application. Different Observers for the console output, history, UIs, statistical processors, etc. can be realized. Design and implement such an application of the Observer pattern for this system. Realize a console output and a history observer. Use the history observer to improve the simulations’ tests. Also, test the other functions of the observer.

2. The SingleTrafficLightSimulation is, at the moment, the only possible simulation. It is rather hard-wired to other classes, making it difficult to realize other simulations using the realized device. For instance, a simulation of a four-way traffic light for an intersection of two streets could be realized using the existing device implementations.
A colleague suggests realizing a generic Simulation class and letting the actual simulation configurations, such as SingleTrafficLightSimulation or FourWayIntersectionSimulation be extensions of that class as in the Decorator or Strategy design patterns. Select the appropriate pattern for this task. Create a design and an implementation following this pattern. Adapt the SingleTrafficLightSimulation accordingly and realize a  FourWayIntersectionSimulation. Test both classes (using the history observer).

3. Each simulation needs to create multiple instances of the devices. Also, additional tasks need to be performed for each device upon creation. Could this problem be solved with a Factory Method, an Abstract Factory, or a variant of one of these patterns? Realize an appropriate device creation and test it.

In addition, realize a UML class diagram in PlantUML to model your final design. Use stereotypes to highlight the pattern roles of model elements like classes in the design.
