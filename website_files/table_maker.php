<?php
include 'res/connect.php';
# Make tables
# Initializes all database tables
$sql = 'CREATE TABLE Users (
User_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
FName VARCHAR(45) NOT NULL,
LName VARCHAR(45) NOT NULL,
Phone_NO INT(10) NOT NULL,
Email VARCHAR(60) NOT NULL,
Username VARCHAR(45) NOT NULL UNIQUE,
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

$sql = 'CREATE VIEW User_View AS
        SELECT FName, LName, Phone_No, Email, Username, Password, User_Type
        FROM Users';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "View User_View created successfully";
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

$sql = 'CREATE VIEW Hotel_View AS
        SELECT Hotel_Name, Hotel_City, Hotel_State, Hotel_Country
        FROM Hotel';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "View Hotel_View created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Employees (
    User_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Hotel_ID INT UNSIGNED NOT NULL,
    Employee_JobType VARCHAR(45) NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID),
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID)
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

$sql = 'CREATE VIEW Employee_View AS
        SELECT Users.FName, Users.LName, Users.Phone_No, Users.Email, Users.Username, Users.Password, Employees.Employee_JobType
        FROM Users Inner Join Employees ON Users.user_ID = Employees.user_ID';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "View Employee_View created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Customer (
    User_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Booking_NO INT UNSIGNED,
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID)
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

$sql = 'CREATE TABLE Room (
    Room_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Hotel_ID INT UNSIGNED NOT NULL,
    Room_Num INT(5) UNSIGNED NOT NULL,
    Price FLOAT UNSIGNED NOT NULL,
    Capacity FLOAT UNSIGNED NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Room created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Booking (
    Booking_NO INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Room_ID INT UNSIGNED NOT NULL,
    User_ID INT UNSIGNED NOT NULL,
    `Start_Date` DATETIME NOT NULL,
    End_Date DATETIME NOT NULL,
    FOREIGN KEY (Room_ID) REFERENCES Room(Room_ID),
    FOREIGN KEY (User_ID) REFERENCES Customer(User_ID)
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
    User_ID INT UNSIGNED NOT NULL,
    Rating INT(2) UNSIGNED NOT NULL,
    `Description` VARCHAR(300) NOT NULL,
    Review_Date DATETIME NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID),
    FOREIGN KEY (User_ID) REFERENCES Customer(User_ID)
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
    Booking_NO INT UNSIGNED NOT NULL,
    ST_ID INT UNSIGNED NOT NULL,
    Service_Date DATETIME NOT NULL,
    FOREIGN KEY (Booking_NO) REFERENCES Booking(Booking_NO),
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

$sql = 'CREATE TABLE Service_Assignment (
    SA_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Service_ID INT UNSIGNED NOT NULL,
    User_ID INT UNSIGNED NOT NULL,
    FOREIGN KEY (Service_ID) REFERENCES Hotel_Service(Service_ID),
    FOREIGN KEY (User_ID) REFERENCES Employees(User_ID)
    )';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Table Service Assignment created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE TABLE Receptionist (
    User_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Shift_Start_Time TIME NOT NULL,
    Shift_End_Time TIME NOT NULL,
    FOREIGN KEY (User_ID) REFERENCES Employees(User_ID)
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
    User_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Speciality VARCHAR(45) NOT NULL,
    FOREIGN KEY (User_ID) REFERENCES Employees(User_ID)
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
    User_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `Role` VARCHAR(45) NOT NULL,
    FOREIGN KEY (User_ID) REFERENCES Employees(User_ID)
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