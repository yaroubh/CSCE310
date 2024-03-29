<!---------------------------------------------------------------------------------------------- 
Author of code: Jacob Enerio, Uchenna Akahara, Yaroub Hussein, Krish Chhabra

Jacob Enerio was responsible for coding everything related to including res/connect.php, Bookings and Review_View, which include lines 13-16, 128-228, and 281-296.
Uchenna Akahara was responsible for coding everything related to Reviews, which include lines 230-279.
Yaroub Hussein was responsible for coding everything related to Registration, Login, and Profile editing, which include lines 17-126.
Krish Chhabra was responsible for coding everything related to Services, which include lines 298-533.

This file initializes SQL tables, views, indexes, and triggers.

----------------------------------------------------------------------------------------------->

<?php
include_once 'res/connect.php';
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

$sql = 'CREATE VIEW IF NOT EXISTS User_View AS
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

$sql = 'CREATE VIEW IF NOT EXISTS Hotel_View AS
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
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID) ON DELETE CASCADE
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

$sql = 'CREATE VIEW IF NOT EXISTS Employee_View AS
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

$sql = 'CREATE INDEX IF NOT EXISTS idx_room_room_num ON Room (Room_Num)';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Index idx_room_room_num created successfully";
    } else {
        echo "Error creating index: " . $conn->error;
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
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID) ON DELETE CASCADE,
    CONSTRAINT Date_Consistency CHECK (Start_Date <= End_Date)
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

$sql = "
    CREATE OR REPLACE TRIGGER  Solo_Booking  BEFORE INSERT ON Booking 
    FOR EACH ROW
    BEGIN
    IF EXISTS (SELECT * FROM Booking WHERE NEW.Room_ID = Booking.Room_ID AND (NEW.Start_Date <= Booking.End_Date AND Booking.Start_Date <= New.End_Date)) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Dates should not overlap for the booking of the same room';
    END IF;
    END;";

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Trigger Solo_Booking created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = "
    CREATE OR REPLACE TRIGGER  Solo_Booking_Update BEFORE UPDATE ON Booking 
    FOR EACH ROW
    BEGIN
    IF EXISTS (SELECT * FROM Booking WHERE NEW.Room_ID = Booking.Room_ID AND NEW.Booking_NO != Booking.Booking_NO AND (NEW.Start_Date <= Booking.End_Date AND Booking.Start_Date <= New.End_Date)) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Dates should not overlap for the booking of the same room';
    END IF;
    END;";

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Trigger Solo_Booking_Update created successfully";
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
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID) ON DELETE CASCADE
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

$sql = 'CREATE INDEX IF NOT EXISTS idx_users_username ON Users (Username)';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Index idx_users_username created successfully";
    } else {
        echo "Error creating index: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = 'CREATE INDEX IF NOT EXISTS idx_hotel_hotel_name ON Hotel (Hotel_Name)';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Index idx_hotel_hotel_name created successfully";
    } else {
        echo "Error creating index: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

// create view of the rating, description and date columns from review table.
$sql = "CREATE VIEW IF NOT EXISTS Review_View 
AS SELECT Reviews.Review_ID, Users.User_ID, Users.username, Hotel.Hotel_ID, Hotel.Hotel_Name, Reviews.Rating, Reviews.Description, Reviews.Review_Date FROM Reviews
INNER JOIN Users on Users.User_ID = Reviews.User_ID
INNER JOIN Hotel on Hotel.Hotel_ID = Reviews.Hotel_ID";
echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "View Review_View created successfully";
    } else {
        echo "Error creating view: " . $conn->error;
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
    Booking_NO INT UNSIGNED,
    ST_ID INT UNSIGNED NOT NULL,
    Service_Date DATETIME NOT NULL,
    FOREIGN KEY (Booking_NO) REFERENCES Booking(Booking_NO) ON DELETE CASCADE,
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
    FOREIGN KEY (Service_ID) REFERENCES Hotel_Service(Service_ID) ON DELETE CASCADE,
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

// create view for service operations
$sql = 'CREATE VIEW IF NOT EXISTS Service_View AS
        SELECT Hotel_Service.Service_ID AS Service_ID, Hotel_Service.Service_Date AS Service_Date, Service_Type.ST_ID AS ST_ID,
               Service_Type.Service_Type AS Service_Type, Service_Type.Price AS Price, Service_Assignment.SA_ID AS SA_ID,
               Service_Assignment.User_ID AS Emp_ID, Users.FName AS Emp_FName, Users.LName AS Emp_LName, Users.Email AS Emp_Email,
               Booking.Booking_NO AS Booking_NO, Booking.User_ID AS Cust_ID, Booking.Start_Date AS Start_Date, Booking.End_Date AS End_Date,
               Room.Room_ID AS Room_ID, Room.Room_Num AS Room_Num, Hotel.Hotel_ID AS Hotel_ID, Hotel.Hotel_Name AS Hotel_Name,
               Hotel.Hotel_City AS Hotel_City, Hotel.Hotel_State AS Hotel_State, Hotel.Hotel_Country AS Hotel_Country
        FROM ((((((Hotel_Service LEFT JOIN Service_Type       ON Hotel_Service.ST_ID = Service_Type.ST_ID)
                                 LEFT JOIN Service_Assignment ON Hotel_Service.Service_ID = Service_Assignment.Service_ID)
                                 LEFT JOIN Users              ON Service_Assignment.User_ID = Users.User_ID)
                                 LEFT JOIN Booking            ON Hotel_Service.Booking_NO = Booking.Booking_NO)
                                 LEFT JOIN Room               ON Booking.Room_ID = Room.Room_ID)
                                 LEFT JOIN Hotel              ON Room.Hotel_ID = Hotel.Hotel_ID)';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "View Service_View created successfully";
    } else {
        echo "Error creating view: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

// creating index for service view
$sql = 'CREATE INDEX IF NOT EXISTS idx_service_service_id ON Hotel_Service (Service_ID)';

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Index idx_hotel_hotel_name created successfully";
    } else {
        echo "Error creating index: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

// create trigger on service date for hotel service
$sql = "CREATE OR REPLACE TRIGGER Service_Date_Check BEFORE INSERT ON Hotel_Service 
        FOR EACH ROW
        BEGIN
        IF EXISTS (SELECT * FROM Booking WHERE NEW.Booking_NO = Booking.Booking_NO AND (NEW.Service_Date < Booking.Start_Date OR NEW.Service_Date > Booking.End_Date)) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Service must be scheduled during the booking it is linked to';
        END IF;
        END;";

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Trigger Service_Date_Check created successfully";
    } else {
        echo "Error creating trigger: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = "CREATE OR REPLACE TRIGGER Service_Date_Check_Update BEFORE UPDATE ON Hotel_Service 
        FOR EACH ROW
        BEGIN
        IF EXISTS (SELECT * FROM Booking WHERE NEW.Booking_NO = Booking.Booking_NO AND (NEW.Service_Date < Booking.Start_Date OR NEW.Service_Date > Booking.End_Date)) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Service must be scheduled during the booking it is linked to';
        END IF;
        END;";

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Trigger Service_Date_Check_Update created successfully";
    } else {
        echo "Error creating trigger: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

// create trigger on hotel id for service assignment
$sql = "CREATE OR REPLACE TRIGGER Service_Assign_Check BEFORE INSERT ON Service_Assignment 
        FOR EACH ROW
        BEGIN
        IF NOT EXISTS ((SELECT Hotel_ID FROM Employees WHERE NEW.User_ID = Employees.User_ID)
                       INTERSECT
                       (SELECT Hotel_ID FROM Room WHERE Room.Room_ID IN
                        (SELECT Room_ID FROM Booking WHERE Booking.Booking_NO IN
                         (SELECT Booking_NO FROM Hotel_Service WHERE NEW.Service_ID = Hotel_Service.Service_ID)))
                      ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Employee assigned to service must work at the hotel the service occurs at';
        END IF;
        END;";

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Trigger Service_Assign_Check created successfully";
    } else {
        echo "Error creating trigger: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = "CREATE OR REPLACE TRIGGER Service_Assign_Update_Check BEFORE UPDATE ON Service_Assignment 
        FOR EACH ROW
        BEGIN
        IF NOT EXISTS ((SELECT Hotel_ID FROM Employees WHERE NEW.User_ID = Employees.User_ID)
                       INTERSECT
                       (SELECT Hotel_ID FROM Room WHERE Room.Room_ID IN
                        (SELECT Room_ID FROM Booking WHERE Booking.Booking_NO IN
                         (SELECT Booking_NO FROM Hotel_Service WHERE NEW.Service_ID = Hotel_Service.Service_ID)))
                      ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Employee assigned to service must work at the hotel the service occurs at';
        END IF;
        END;";

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Trigger Service_Assign_Update_Check created successfully";
    } else {
        echo "Error creating trigger: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

// create trigger on double assignment for service assignment
$sql = "CREATE OR REPLACE TRIGGER Double_Assign_Check BEFORE INSERT ON Service_Assignment
        FOR EACH ROW
        BEGIN
        IF EXISTS (SELECT * FROM Service_Assignment WHERE NEW.Service_ID = Service_Assignment.Service_ID AND NEW.User_ID = Service_Assignment.User_ID) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Employee cannot be assigned same service multiple times';
        END IF;
        END;";

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Trigger Double_Assign_Check created successfully";
    } else {
        echo "Error creating trigger: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";

$sql = "CREATE OR REPLACE TRIGGER Double_Assign_Update_Check BEFORE UPDATE ON Service_Assignment 
        FOR EACH ROW
        BEGIN
        IF EXISTS (SELECT * FROM Service_Assignment WHERE NEW.Service_ID = Service_Assignment.Service_ID AND NEW.User_ID = Service_Assignment.User_ID) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Employee cannot be assigned same service multiple times';
        END IF;
        END;";

echo "<p>";
try {
    if ($conn->query($sql) === TRUE) {
        echo "Trigger Double_Assign_Update_Check created successfully";
    } else {
        echo "Error creating trigger: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";
?>