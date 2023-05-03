<?php
include_once 'res/connect.php';
# Make tables
# Initializes all database tables with a sample dataset
function make_user($conn, $id, $fname, $lname, $phone_num, $email, $username, $password, $userType) {
    $sql = "INSERT INTO Users
    VALUES ('$id', '$fname', '$lname', '$phone_num', '$email', '$username', '$password', '$userType')";
    echo "<p>";
    try {
        if ($conn->query($sql) === TRUE) {
            echo "Added User " . $fname . " " . $lname . " successfully";
        } else {
            echo "Error creating user: " . $conn->error;
        }
    } catch (Exception $ex) {
            echo $ex;
            return false;
    }
    echo "</p>";
    return true;
}

function make_customer($conn, $id, $fname, $lname, $phone_num, $email, $username, $password) {
    $made_user = make_user($conn, $id, $fname, $lname, $phone_num, $email, $username, $password, "Customer");
    if ($made_user === false) {
        return false;
    }
}

function make_employee($conn, $id, $fname, $lname, $phone_num, $email, $username, $password, $hotel_id, $employee_type) {
    $made_user = make_user($conn, $id, $fname, $lname, $phone_num, $email, $username, $password, "Employee");
    if ($made_user === false) {
        return false;
    }

    $sql = "INSERT INTO Employees
    VALUES ('$id', '$hotel_id', '$employee_type')";
    echo "<p>";
    try {
        if ($conn->query($sql) === TRUE) {
            echo "Added Employee " . $fname . " " . $lname . " successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }
    } catch (Exception $ex) {
            echo $ex;
            return false;
    }
    echo "</p>";
    return true;
}

function make_hotel($conn, $id, $name, $city, $state, $country) {
    $sql = "INSERT INTO Hotel
    VALUES ('$id', '$name', '$city', '$state', '$country')";
    echo "<p>";
    try {
        if ($conn->query($sql) === TRUE) {
            echo "Added Hotel " . $name . " successfully";
        } else {
            echo "Error creating hotel: " . $conn->error;
        }
    } catch (Exception $ex) {
            echo $ex;
            return false;
    }
    echo "</p>";
    return true;
}

function make_room($conn, $hotel_id, $room_num, $price, $capacity) {
    $sql = "INSERT INTO Room (Hotel_ID, Room_Num, Price, Capacity)
    VALUES ('$hotel_id', '$room_num', '$price', '$capacity')";
    echo "<p>";
    try {
        if ($conn->query($sql) === TRUE) {
            echo "Added Room " . $room_num  . " at Hotel" . $hotel_id . " successfully";
        } else {
            echo "Error creating room: " . $conn->error;
        }
    } catch (Exception $ex) {
            echo $ex;
            return false;
    }
    echo "</p>";
    return true;
}

function make_review($conn, $review_id, $hotel_id, $user_id, $rating, $desc, $date){
    $sql = "INSERT INTO Reviews (Review_ID, Hotel_ID, User_ID, Rating, Description, Review_Date)
    VALUES ('$review_id', '$hotel_id', '$user_id', '$rating', '$desc', '$date')";
    echo "<p>";
    try {
        if ($conn->query($sql) === TRUE) {
            echo "Added Review " . $review_id  . " at Hotel" . $hotel_id . " successfully";
        } else {
            echo "Error creating review: " . $conn->error;
        }
    } catch (Exception $ex) {
            echo $ex;
            return false;
    }
    echo "</p>";
    return true;
}

function make_booking($conn, $room_id, $user_id, $start_date, $end_date) {
    $sql = "INSERT INTO Booking (Booking_NO, Room_ID, User_ID, Start_Date, End_Date)
    VALUES (null, '$room_id', '$user_id', '$start_date', '$end_date')";
    echo "<p>";
    try {
        if ($conn->query($sql) === TRUE) {
            echo "Added Booking for room " . $room_id  . " for user " . $user_id . " successfully";
        } else {
            echo "Error creating review: " . $conn->error;
        }
    } catch (Exception $ex) {
            echo $ex;
            return false;
    }
    echo "</p>";
    return true;
}

make_hotel($conn, 1, "BCS Hotel", "BCS", "Texas", "United States");
make_hotel($conn, 2, "Magico", "Monte Cristo", "Livorno", "Italy");
make_hotel($conn, 3, "Houstonia", "Houston", "Texas", "United States");



make_customer($conn, 1, "Sam", "Sammy", '1234567890', "Sam.Sammy@tamu.edu", "Sammy1", "1Sammy");
make_customer($conn, 2, "Bob", "Bobby", '0123456789', "BobbyBob@tamu.edu", "Bob2", "Bobby2");
make_employee($conn, 3, "Joe", "Bobby", '0001112222', "BobbyBob@tamu.edu", "Bob3", "Bobby3", 1, "Receptionist");
make_employee($conn, 4, "Robby", "Roe", '0221110000', "RowRowRob@tamu.edu", "RobRoe", "Robby3", 1, "Receptionist");
make_employee($conn, 5, "Yoyo", "Jojo", '0550005555', "YYJJ@tamu.edu", "YY55", "55JJ", 2, "Receptionist");
make_employee($conn, 6, "Tian", "Tiap", '0334445555', "adminTNTP@tamu.edu", "Admin", "Totally_Not_The_Password", 1, "Administrator");
make_employee($conn, 7, "Lorali", "Jones", '0001113333', "Lorali1@tamu.edu", "Loarli1", "LP1", 1, "Service_Worker");
make_employee($conn, 8, "Loralil", "Jones", '0001113334', "Lorali2@tamu.edu", "Loarli2", "LP2", 1, "Service_Worker");
make_employee($conn, 9, "Loralia", "Jones", '0001113335', "Lorali3@tamu.edu", "Loarli3", "LP3", 2, "Service_Worker");
make_employee($conn, 10, "Loralip", "Jones", '0001113336', "Lorali4@tamu.edu", "Loarli4", "LP4", 2, "Service_Worker");

make_review($conn, 1, 1, 1, 4, "Overall Good. Would come again", '2023-05-02 12:45:36');
make_review($conn, 2, 2, 2, 5, "Such a wonderful experience. The family loved.", '2022-05-12 13:55:12');

# Randomly generate rooms
for ($i = 1; $i < 4; $i++) {
    $floors = rand(2, 5);
    for ($j = 1; $j <= $floors; $j++) {
        $rooms = rand(5, 25);
        for ($k = 1; $k <= $rooms; $k++) {
            $room_floor_end = $k;
            if ($k < 10) {
                $room_floor_end = "0" . $k;
            }
            make_room($conn, $i, $j . "" . $room_floor_end, rand(10, 10000) / 100, rand(1, 9));
        }
    }
}

make_booking($conn, 1, 1, "2022-05-12 13:55:12", "2022-05-15 13:55:12");
make_booking($conn, 1, 2, "2022-05-17 10:10:10", "2022-05-19 10:10:10");
make_booking($conn, 2, 2, "2022-05-30 10:10:10", "2022-06-17 11:11:11");
