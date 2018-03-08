
const int trigPin = 4;
const int echoPin = 5;
long duration;
int distance;
String serialMessage;

void setup() {
    pinMode(trigPin, OUTPUT);               // Sets the trigPin as an Output
    pinMode(echoPin, INPUT);                // Sets the echoPin as an Input
    Serial.begin(115200);                   // Starts the serial communication
}

boolean collisionDetection() {
    boolean collisionDetected = false;
    digitalWrite(trigPin, LOW);             // Clears the trigPin
    delayMicroseconds(2);
    digitalWrite(trigPin, HIGH);            // Sets the trigPin on HIGH state for 10 micro seconds
    delayMicroseconds(10);
    digitalWrite(trigPin, LOW);
    duration = pulseIn(echoPin, HIGH);      // Reads the echoPin, returns the sound wave travel time in microseconds
    distance = duration * 0.034 / 2;        // Calculate the distance
    if (distance < 30) {
        collisionDetected = true;
    }
    return collisionDetected;
}

void loop() {
    
    if (Serial.available() > 0) {
        serialMessage = Serial.readStringUntil('\n');
        if (collisionDetection()) {
            Serial.println(255);    // If a collision is detected, print error code
        } else {
            // Change this to whatever serial port the motor controller is on...
            Serial.println(serialMessage);
        }
    }
}
