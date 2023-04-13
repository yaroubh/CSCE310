<?php
include 'connect.php';
# Make tables
# Initializes all database tables
$sql = 'CREATE TABLE Users (
User_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
FName VARCHAR(45) NOT NULL,
LName VARCHAR(45) NOT NULL,
Phone_NO INT(10) NOT NULL,
Email VARCHAR(60) NOT NULL,
Username VARCHAR(45) NOT NULL,
`Password` VARCHAR(45) NOT NULL,
User_Type VARCHAR(30) NOT NULL
)';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Users created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Hotel (
    Hotel_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Hotel_Name VARCHAR(45) NOT NULL,
    Hotel_City VARCHAR(45) NOT NULL,
    Hotel_State VARCHAR(45) NOT NULL,
    Hotel_Country VARCHAR(45) NOT NULL
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Hotel created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Employees (
    Employee_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Hotel_ID INT UNSIGNED NOT NULL,
    Employee_JobType VARCHAR(45) NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Employees created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Customer (
    Customer_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Booking_NO INT UNSIGNED
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Customer created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Booking (
    Booking_NO INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Hotel_ID INT UNSIGNED NOT NULL,
    Customer_ID INT UNSIGNED NOT NULL,
    Room_Num INT(4) UNSIGNED NOT NULL,
    `Start_Date` DATETIME NOT NULL,
    End_Date DATETIME NOT NULL,
    Price FLOAT UNSIGNED NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Booking created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'ALTER TABLE Customer
ADD FOREIGN KEY (Booking_NO) REFERENCES Booking(Booking_NO);
    ';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Customer added foreign key to booking successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Reviews (
    Review_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Hotel_ID INT UNSIGNED NOT NULL,
    Customer_ID INT UNSIGNED NOT NULL,
    Rating INT(2) UNSIGNED NOT NULL,
    `Description` VARCHAR(300) NOT NULL,
    Review_Date DATETIME NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Reviews created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Service_Type (
    ST_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Service_Type VARCHAR(45) NOT NULL,
    Price FLOAT UNSIGNED NOT NULL
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Service_Type created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Hotel_Service (
    Service_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Hotel_ID INT UNSIGNED NOT NULL,
    Customer_ID INT UNSIGNED NOT NULL,
    ST_ID INT UNSIGNED NOT NULL,
    Service_Date DATETIME NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID),
    FOREIGN KEY (ST_ID) REFERENCES Service_Type(ST_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Hotel_Service created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Receptionist (
    Employee_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Shift_Start_Time TIME NOT NULL,
    Shift_End_Time TIME NOT NULL,
    FOREIGN KEY (Employee_ID) REFERENCES Employees(Employee_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Receptionist created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Administrator (
    Employee_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Speciality VARCHAR(45) NOT NULL,
    FOREIGN KEY (Employee_ID) REFERENCES Employees(Employee_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Administrator created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Service_Worker (
    Employee_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Service_ID INT UNSIGNED,
    Role VARCHAR(45) NOT NULL,
    FOREIGN KEY (Employee_ID) REFERENCES Employees(Employee_ID),
    FOREIGN KEY (Service_ID) REFERENCES Hotel_Service(Service_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Service Worker created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

?>