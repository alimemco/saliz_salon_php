<?php

include 'salizConnection.php';

$TOKEN = "AliRnpVAgT8AV195s";

class SalizDatabaseManager
{

    //TABLE CREATOR
    function createCategoryTable()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $sqlQ = "CREATE TABLE category (
      ID INT AUTO_INCREMENT PRIMARY KEY,
      name TEXT,
      image TEXT
)COLLATE='utf8mb4_unicode_520_ci';";


        if ($conn->query($sqlQ)) {
            return "*** [ category ] created successfully ***";
        } else {
            return "[ category ]  ERROR | EXIST OR NOT CREATED";
        }
    }

    function createPostsTable()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $sqlQ = "CREATE TABLE posts (
      ID INT AUTO_INCREMENT PRIMARY KEY,
      Category_ID INT,
      title TEXT,
      category TEXT,
      price TEXT,
      image TEXT
)COLLATE='utf8mb4_unicode_520_ci';";


        if ($conn->query($sqlQ)) {
            return "*** [ posts ] created successfully ***";
        } else {
            return "[ posts ]  ERROR | EXIST OR NOT CREATED";
        }
    }

    function createOpenTimesTable()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $sqlQ = "CREATE TABLE times (
      ID INT AUTO_INCREMENT PRIMARY KEY,
      day_of_week INT ,
      day TEXT,
      hour TEXT,
      reserved TEXT
)
COLLATE='utf8mb4_unicode_520_ci';";


        if ($conn->query($sqlQ)) {
            return "*** [ times ] created successfully ***";
        } else {
            return "[ times ]  ERROR | EXIST OR NOT CREATED";
        }
    }

    function createReserveTable()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $sqlQ = "CREATE TABLE reserve (
      ID INT AUTO_INCREMENT PRIMARY KEY,
      userID INT DEFAULT 0,
      timeID TEXT,
      dayName TEXT,
      dayOfMonth TEXT,
      monthName TEXT,
      hour TEXT,
      price TEXT,
      services TEXT,
      status TEXT
)
COLLATE='utf8mb4_unicode_520_ci';";

        if ($conn->query($sqlQ)) {
            return "*** [ reserve ] created successfully ***";
        } else {
            return "[ reserve ]  ERROR | EXIST OR NOT CREATED";
        }
    }

    function createUserTable()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $sqlQ = "CREATE TABLE users (
      ID INT AUTO_INCREMENT PRIMARY KEY,
      first_name TEXT,
      last_name TEXT,
      phone TEXT,
      password TEXT,
      level TEXT,
      power INT
)
COLLATE='utf8mb4_unicode_520_ci';";


        if ($conn->query($sqlQ)) {
            return "*** [ users ] created successfully ***";
        } else {
            return "[ users ] ERROR | EXIST OR NOT CREATED";
        }
    }

    function createServicesTable()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $query = "CREATE TABLE services (
      ID INT AUTO_INCREMENT PRIMARY KEY,
      name TEXT,
      price TEXT,
      period TEXT,
      range_price TEXT
)
COLLATE='utf8mb4_unicode_520_ci';";


        if ($conn->query($query)) {
            return "*** [ services ] created successfully ***";
        } else {
            return "[ services ] ERROR | EXIST OR NOT CREATED";
        }
    }

    function createBannerTable()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $query = "CREATE TABLE banner (
      ID INT AUTO_INCREMENT PRIMARY KEY,
      url TEXT,
      position INT 
)
COLLATE='utf8mb4_unicode_520_ci';";


        if ($conn->query($query)) {
            return "*** [ banner ] created successfully ***";
        } else {
            return "[ banner ] ERROR | EXIST OR NOT CREATED";
        }
    }

    //ADD TO SERVER
    function addCategory($name, $image)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $validate = "SELECT `serial_number` FROM `hijack` WHERE name='$name'";

        if ($result = $conn->query($validate)) {

            if (mysqli_num_rows($result) > 0) {


                $res[] = array(
                    "success" => "false",
                    "message" => "exist"
                );

            } else {

                $query = "INSERT INTO `category`( `name`,`image`)
                     VALUES(
                     '$name', '$image')";


                if ($result = $conn->query($query)) {
                    $res[] = array(
                        "success" => "true",
                        "message" => "successfully"
                    );

                } else {

                    $res[] = array(
                        "success" => "false",
                        "message" => "INSERT " . mysqli_error($conn)
                    );
                }
            };


        } else {

            $res[] = array(
                "success" => "false",
                "message" => mysqli_error($conn)
            );
        }


        return $res;
    }

    function addReserve($timeID, $phone, $dayName, $dayOfMonth, $monthName, $hour, $price, $services)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $user_check_query = "SELECT ID FROM users WHERE phone='$phone' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $userId = $user['ID'];

            $query = "INSERT INTO `reserve`( `userID`,`timeID`,`dayName`,`dayOfMonth`,`monthName`,`hour`,`price`,`services`,`status`)
                     VALUES(
                    '$userId','$timeID', '$dayName', '$dayOfMonth' , '$monthName' ,'$hour' , '$price' ,'$services','pending')";


            if ($result = $conn->query($query)) {
                if ($result) {
                    //  $success = $this->set_reserved_time(true,$timeID);

                    $res[] = array(
                        "success" => true,
                        "message" => "successfully"
                    );


                } else {
                    $res[] = array(
                        "success" => false,
                        "message" => mysqli_error($conn)
                    );
                }


            } else {

                $res[] = array(
                    "success" => "false",
                    "message" => "INSERT " . mysqli_error($conn)
                );
            };


        } else {
            $res[] = array(
                "success" => false,
                "message" => "USER not found " . mysqli_error($conn)
            );
        }

        return $res;
    }

    //USER MANAGER
    function register($first_name, $last_name, $phone, $password)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");
        $hash = md5($password);
        $res = array();

        $user_check_query = "SELECT * FROM users WHERE phone='$phone' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {

            $res[] = array(
                "success" => "false",
                "message" => "userExist"
            );
        } else {

            $query = "INSERT INTO `users` ( `first_name`,`last_name`,`phone`,`password`,`level`)
                     VALUES(
                     '$first_name', '$last_name' , '$phone' ,'$hash' , 'NEW_COMER' )";


            if ($result = $conn->query($query)) {
                $res[] = array(
                    "success" => "true",
                    "message" => "successfully"
                );

            } else {

                $res[] = array(
                    "success" => "false",
                    "message" => "INSERT " . mysqli_error($conn)
                );
            };

        }

        return $res;
    }

    function login($phone, $password)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");
        $hash = md5($password);

        $user_check_query = "SELECT * FROM users WHERE phone='$phone' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {

            $password_check_query = "SELECT * FROM users WHERE phone='$phone' AND password = '$hash' LIMIT 1";
            $result = mysqli_query($conn, $password_check_query);
            $pass = mysqli_fetch_assoc($result);

            $row = array();

            if ($pass) {
                $row[] = array(
                    "first_name" => $pass['first_name'],
                    "last_name" => $pass['last_name'],
                    "level" => $pass['level']
                );

                $res[] = array(
                    "success" => true,
                    "message" => "success",
                    "items" => $row
                );
            } else {
                $res[] = array(
                    "success" => false,
                    "message" => "passwordNotMatch"
                );
            }

        } else {
            $res[] = array(
                "success" => false,
                "message" => "userNotFound"
            );
        }

        return $res;
    }

    function editUser($first_name, $last_name, $phone, $new_phone, $password)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");
        $hash = md5($password);

        if (isset($password)) {
            $query = "UPDATE users SET first_name='$first_name',last_name='$last_name',phone='$new_phone',password='$hash' WHERE phone='$phone'";
        } else {
            $query = "UPDATE users SET first_name='$first_name',last_name='$last_name',phone='$new_phone' WHERE phone='$phone'";
        }

        if ($result = $conn->query($query)) {
            $res[] = array(
                "success" => "true",
                "message" => "successfully"

            );

        } else {

            $res[] = array(
                "success" => "false",
                "message" => "EDIT " . mysqli_error($conn)
            );
        };


        return $res;


    }

    function checkAdmin($phone)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $query = "SELECT * FROM users WHERE phone='$phone' AND level='ADMIN'";


        if ($result = $conn->query($query)) {
            if (mysqli_num_rows($result) > 0) {
                $res[] = array(
                    "success" => "true",
                    "message" => "successfully"

                );
            } else {
                $res[] = array(
                    "success" => "false",
                    "message" => "error"

                );
            }

        } else {

            $res[] = array(
                "success" => "false",
                "message" => "EDIT " . mysqli_error($conn)
            );
        };


        return $res;


    }

    //GET INFORMATION
    function getCategory()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $mySql = "SELECT * FROM `category`";

        $rows = array();
        $res = array();

        if ($result = $conn->query($mySql)) {

            if (mysqli_num_rows($result) > 0) {

                while ($res = $result->fetch_assoc()) {
                    $rows[] = array(

                        "ID" => $res['ID'],
                        "name" => $res['name'],
                        "image" => $res['image']
                    );

                }

                $res[] = array(
                    "success" => "true",
                    "message" => "successfully",
                    "items" => $rows
                );

            } else {
                $res[] = array(
                    "success" => "false",
                    "message" => "is empty"
                );
            };


        } else {
            $res[] = array(
                "success" => "false",
                "message" => mysqli_error($conn)
            );
        }


        return $res;
    }
    function getUsers()
    {
        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $mySql = "SELECT * FROM `users` ORDER BY `power` DESC";

        $rows = array();
        $res = array();

        if ($result = $conn->query($mySql)) {

            if (mysqli_num_rows($result) > 0) {

                while ($res = $result->fetch_assoc()) {
                    $rows[] = array(
                        "ID" => $res['ID'],
                        "USERNAME" => $res['phone'],
                        "first_name" => $res['first_name'],
                        "last_name" => $res['last_name'],
                        "level" => $res['level']
                    );

                }

                $res[] = array(
                    "success" => "true",
                    "message" => "successfully",
                    "items" => $rows
                );

            } else {
                $res[] = array(
                    "success" => "false",
                    "message" => "is empty"
                );
            };


        } else {
            $res[] = array(
                "success" => "false",
                "message" => mysqli_error($conn)
            );
        }


        return $res;
    }

    function getTimes($day)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $mySql = "SELECT * FROM `times` WHERE `day`='$day'";

        $rows = array();
        $res = array();

        if ($result = $conn->query($mySql)) {

            if (mysqli_num_rows($result) > 0) {

                while ($res = $result->fetch_assoc()) {
                    $rows[] = array(
                        "ID" => $res['ID'],
                        "day" => $res['day'],
                        "hour" => $res['hour'],
                        "reserved" => $res['reserved']
                    );

                }

                $res[] = array(
                    "success" => true,
                    "message" => "successfully",
                    "items" => $rows
                );

            } else {
                $res[] = array(
                    "success" => false,
                    "message" => "empty",
                    "error" => mysqli_error($conn)
                );
            };


        } else {
            $res[] = array(
                "success" => "false",
                "message" => mysqli_error($conn)
            );
        }


        return $res;
    }

    function getUserReserveList($phone)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $rows = array();
        $res = array();
        $userID = 0;

        $query = "SELECT `ID` FROM `users` WHERE `phone`=$phone order by `ID` DESC ";

        if ($result = $conn->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $userID = $row["ID"];
            }

            $queryReserve = "SELECT * FROM `reserve` WHERE `userID`='$userID' ORDER BY `ID` DESC ";
            if ($resultReserve = $conn->query($queryReserve)) {
                if (mysqli_num_rows($resultReserve) > 0) {
                    while ($res = $resultReserve->fetch_assoc()) {
                        $rows[] = array(
                            "ID" => $res['ID'],
                            "dayName" => $res['dayName'],
                            "dayOfMonth" => $res['dayOfMonth'],
                            "monthName" => $res['monthName'],
                            "hour" => $res['hour'],
                            "price" => $res['price'],
                            "services" => $res['services'],
                            "status" => $res['status']
                        );
                    }
                    $res[] = array(
                        "success" => "true",
                        "message" => "successfully",
                        "items" => $rows
                    );

                } else {
                    $res[] = array(
                        "success" => "false",
                        "message" => "empty"
                    );
                };


            } else {
                $res[] = array(
                    "success" => "false",
                    "message" => mysqli_error($conn)
                );
            }

        } else {
            $res[] = array(
                "success" => "false",
                "message" => "empty"
            );
        }

        return $res;
    }

    function getPosts()
    {


        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $listItems = array();

        for ($i = 0; $i < 3; $i++) {

            $ID = $i + 1;

            $query = "SELECT * FROM `posts` WHERE `Category_ID`=$ID ";
            $res = $conn->query($query);
            $rows = array();

            while ($result = $res->fetch_assoc()) {
                $rows[] = array(
                    "Category_ID" => $result['Category_ID'],
                    "ID" => $result['ID'],
                    "title" => $result['title'],
                    "category" => $result['category'],
                    "price" => $result['price'],
                    "image" => $result['image']
                );
            }

            $title = null;

            if ($i == 0) {
                $title = "جدیدترین ها";
            } else if ($i == 1) {
                $title = "محصولات";
            } else if ($i == 2) {
                $title = "پر فروش ترین";
            }

            $listItems[$i] = array(
                "title" => $title,
                "items" => $rows
            );
        }

        return $listItems;
    }

    function getServices()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $rows = array();
        $res = array();

        $query = "SELECT * FROM `services` ";

        if ($result = $conn->query($query)) {
            if (mysqli_num_rows($result) > 0) {

                while ($res = $result->fetch_assoc()) {
                    $rows[] = array(
                        "ID" => $res['ID'],
                        "name" => $res['name'],
                        "price" => $res['price'],
                        "period" => $res['period'],
                        "range_price" => $res['range_price']
                    );
                }
                $res[] = array(
                    "success" => "true",
                    "message" => "successfully",
                    "items" => $rows
                );

            } else {
                $res[] = array(
                    "success" => "false",
                    "message" => "empty"
                );
            };


        } else {
            $res[] = array(
                "success" => "false",
                "message" => mysqli_error($conn)
            );
        }


        return $res;
    }

    //GET INFORMATION ADMIN
    function get_orders_admin()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $rows = array();
        $res = array();

        $query = "SELECT * FROM `reserve` ORDER BY `ID` DESC";

        if ($result = $conn->query($query)) {
            if (mysqli_num_rows($result) > 0) {

                while ($res = $result->fetch_assoc()) {
                    $userID = $res['userID'];
                    $query = "SELECT * FROM `users` WHERE `ID`='$userID'";

                    if ($result_user = $conn->query($query)) {
                        if (mysqli_num_rows($result_user) > 0) {
                            while ($res_user = $result_user->fetch_assoc()) {
                                $rows[] = array(
                                    "ID" => $res['ID'],
                                    "userID" => $res['userID'],
                                    "TIME_ID" => $res['timeID'],
                                    "dayName" => $res['dayName'],
                                    "dayOfMonth" => $res['dayOfMonth'],
                                    "monthName" => $res['monthName'],
                                    "hour" => $res['hour'],
                                    "price" => $res['price'],
                                    "services" => $res['services'],
                                    "status" => $res['status'],

                                    "first_name" => $res_user['first_name'],
                                    "last_name" => $res_user['last_name'],
                                    "phone" => $res_user['phone'],
                                    "level" => $res_user['level']
                                );
                            }
                        }
                    }

                }
                $res[] = array(
                    "success" => true,
                    "message" => "successfully",
                    "items" => $rows
                );

            } else {
                $res[] = array(
                    "success" => false,
                    "message" => "empty"
                );
            };


        } else {
            $res[] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }


        return $res;
    }


    function get_times_admin()
    {
        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $items = [];

        $day_1 = [];
        $day_2 = [];
        $day_3 = [];
        $day_4 = [];
        $day_5 = [];
        $day_6 = [];
        $day_7 = [];

        $row_1 = array();
        $row_2 = array();
        $row_3 = array();
        $row_4 = array();
        $row_5 = array();
        $row_6 = array();
        $row_7 = array();

        $query = "SELECT * FROM `times` ORDER BY `day_of_week`";

        if ($result = $conn->query($query)) {
            if (mysqli_num_rows($result) > 0) {

                while ($res = $result->fetch_assoc()) {

                    switch ($res['day_of_week']) {
                        case "1":
                            $row_1[] = $this->push_to_row($res);
                            $day_1 = $this->push_to_day($res, $row_1);

                            break;

                        case "2":
                            $row_2[] = $this->push_to_row($res);
                            $day_2 = $this->push_to_day($res, $row_2);

                            break;


                        case "3":
                            $row_3[] = $this->push_to_row($res);
                            $day_3 = $this->push_to_day($res, $row_3);

                            break;

                        case "4":
                            $row_4[] = $this->push_to_row($res);
                            $day_4 = $this->push_to_day($res, $row_4);

                            break;

                        case "5":
                            $row_5[] = $this->push_to_row($res);
                            $day_5 = $this->push_to_day($res, $row_5);
                            break;


                        case "6":
                            $row_6[] = $this->push_to_row($res);
                            $day_6 = $this->push_to_day($res, $row_6);

                            break;

                        case "7":
                            $row_7[] = $this->push_to_row($res);
                            $day_7 = $this->push_to_day($res, $row_7);

                            break;
                    }
                }


                if ($day_1 != null)
                    array_push($items, $day_1);

                if ($day_2 != null)
                    array_push($items, $day_2);

                if ($day_3 != null)
                    array_push($items, $day_3);

                if ($day_4 != null)
                    array_push($items, $day_4);

                if ($day_5 != null)
                    array_push($items, $day_5);

                if ($day_6 != null)
                    array_push($items, $day_6);

                if ($day_7 != null)
                    array_push($items, $day_7);

                $res = [
                    "success" => "true",
                    "message" => "successfully",
                    "items" => $items

                ];

            } else {
                $res = [
                    "success" => "false",
                    "message" => "empty"
                ];
            };


        } else {
            $res = [
                "success" => "false",
                "message" => mysqli_error($conn)
            ];
        }


        return $res;
    }

    function get_banner_admin()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $rows = array();
        $result = array();

        $query = "SELECT * FROM `banner` ORDER BY `ID` DESC";

        if ($query_result = $conn->query($query)) {
            if (mysqli_num_rows($query_result) > 0) {

                while ($item = $query_result->fetch_assoc()) {
                    $rows[] = array(
                        "ID" => $item['ID'],
                        "name" => $item['name'],
                        "url" => $item['url'],
                        "position" => $item['position']
                    );
                }

                $result[] = array(
                    "success" => true,
                    "message" => "all items received",
                    "items" => $rows
                );

            } else {
                $result[] = array(
                    "success" => false,
                    "message" => "empty"
                );
            }

        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }
        return $result;
    }

    function getManageTimes2()
    {
        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");


        $res = array();
        $day = array();
        $per = array();
        $query = "";


        for ($i = 1; $i <= 7; $i++) {
            switch ($i) {
                case 1:
                    $query = $this->queryDayList("Saturday");
                    break;
                case 2:
                    $query = $this->queryDayList("Sunday");
                    break;
                case 3:
                    $query = $this->queryDayList("Monday");
                    break;
                case 4:
                    $query = $this->queryDayList("Tuesday");
                    break;
                case 5:
                    $query = $this->queryDayList("Wednesday");
                    break;
                case 6:
                    $query = $this->queryDayList("Thursday");
                    break;
                case 7:
                    $query = $this->queryDayList("Friday");
                    break;
            }

            if ($result = $conn->query($query)) {
                if (mysqli_num_rows($result) > 0) {

                    $day_name = "";
                    $per = array();
                    while ($res = $result->fetch_assoc()) {

                        $day_name = $res['day'];

                        $per[] = array("ID" => $res['ID'],
                            "day" => $res['day'],
                            "hour" => $res['hour'],
                            "reserved" => $res['reserved']);
                    }

                    $day[] = array("dayName" => $day_name,
                        "subItem" => $per);

                    $res[] = array(
                        "success" => "true",
                        "message" => "successfully",
                        "items" => $day
                    );

                } else {
                    $res[] = array(
                        "success" => "false",
                        "message" => "empty"
                    );
                };


            } else {
                $res[] = array(
                    "success" => "false",
                    "message" => mysqli_error($conn)
                );
            }
        }


        return $res;
    }


    //ADD INFORMATION ADMIN
    function add_banner_admin($url)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $result = array();

        $query = "INSERT INTO `banner` (`url`) VALUES ('$url' )";

        if ($res = $conn->query($query)) {
            if (mysqli_affected_rows($conn) > 0) {
                $result [] = array(
                    "success" => true,
                    "message" => "successfully"
                );
            } else {
                $result [] = array(
                    "success" => false,
                    "message" => "empty"
                );
            }


        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }
        return $result;
    }

    function add_time_admin($day_of_week, $hour)
    {
        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $result = array();

        $day = $this->get_day_name_from_dayOfWeek($day_of_week);

        $query = "INSERT INTO `times` (`day_of_week`,`day`, `hour`, `reserved`) VALUES ('$day_of_week','$day' , '$hour', 'false')";

        if ($res = $conn->query($query)) {
            $row_affected = mysqli_affected_rows($conn);
            if ($res && $row_affected > 0) {
                $result [] = array(
                    "success" => true,
                    "message" => "successfully",
                    "affected" => mysqli_affected_rows($conn)
                );
            } else {
                $result [] = array(
                    "success" => false,
                    "message" => "error |" . mysqli_error($conn)
                );
            }


        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }
        return $result;
    }

    //EDIT INFORMATION ADMIN
    function edit_banner_admin($url, $position)
    {

        $conn = OpenConnection();
        mysqli_query($conn, "SET NAMES utf8");

        $result = array();

        $query = "INSERT INTO `banners` (`url`, `position`) VALUES ('$url' , '$position')";

        if ($res = $conn->query($query)) {
            if (mysqli_num_rows($res) > 0) {
                $result [] = array(
                    "success" => true,
                    "message" => "item change successfully"
                );
            } else {
                $result [] = array(
                    "success" => false,
                    "message" => "empty"
                );
            }


        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }
        return $result;
    }

    function edit_user_level($id, $user_level)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $result = array();

        $query = "UPDATE `users` SET `level` = '$user_level' WHERE `users`.`ID` = '$id'";

        if ($res = $conn->query($query)) {
            if (mysqli_affected_rows($conn) > 0) {
                $result [] = array(
                    "success" => true,
                    "message" => "successfully"
                );
            } else {
                $result [] = array(
                    "success" => false,
                    "message" => "تغییری اعمال نشد"
                );
            }


        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }
        return $result;
    }

    function edit_order_admin($id, $timeId, $status)
    {
        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $result = array();

        $query = "UPDATE `reserve` SET `status`='$status' WHERE `ID`='$id'";

        if ($res = $conn->query($query)) {
            if ($res) {
                switch ($status) {
                    case "pending":
                    case "denied":
                    case "done":
                        $success = $this->set_reserved_time("false", $timeId);
                        break;

                    case "finalized":
                        $success = $this->set_reserved_time("true", $timeId);
                        break;

                    default:
                        $success = false;


                }
                if ($success) {
                    $result[] = $this->get_orders_admin_after_edit();
                } else {
                    $result [] = array(
                        "success" => false,
                        "message" => "reserved time not changed !"
                    );
                }


            } else {
                $result [] = array(
                    "success" => false,
                    "message" => "not edited"
                );
            }
        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }
        return $result;
    }

    function edit_time_admin($id, $hour, $reserved)
    {
        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $result = array();

        $query = "UPDATE `times` SET `hour`='$hour',`reserved`='$reserved' WHERE `ID`='$id'";

        if ($res = $conn->query($query)) {
            if ($res) {

                $result [] = array(
                    "success" => true,
                    "message" => "successfully"
                );
            } else {
                $result [] = array(
                    "success" => false,
                    "message" => "not edited"
                );
            }
        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }
        return $result;
    }

    //DELETE INFORMATION ADMIN
    function delete_banner($ID)
    {
        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $result = array();

        $query = "DELETE FROM `banner` WHERE `banner`.`ID` = '$ID'";

        if ($res = $conn->query($query)) {
            if (mysqli_affected_rows($conn) > 0) {
                $result [] = array(
                    "success" => true,
                    "message" => "item removed successfully"
                );
            } else {
                $result [] = array(
                    "success" => false,
                    "message" => "empty"
                );
            }

        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }
        return $result;
    }

    function delete_time($ID)
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $result = array();

        $query = "DELETE FROM `times` WHERE `times`.`ID` = '$ID'";

        if ($res = $conn->query($query)) {
            $affected = mysqli_affected_rows($conn);
            if ($res && $affected > 0) {

                $result [] = array(
                    "success" => true,
                    "message" => "item removed successfully",
                    "affected" => $affected
                );
            } else {
                $result [] = array(
                    "success" => false,
                    "message" => $affected." rows affected",
                    "res" => $res,
                    "affected" => $affected
                );
            }

        } else {
            $result [] = array(
                "success" => false,
                "message" => mysqli_error($conn)
            );
        }

        return $result;
    }

    function get_orders_admin_after_edit()
    {

        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $rows = array();

        $query = "SELECT * FROM `reserve` ORDER BY `ID` DESC";

        if ($result = $conn->query($query)) {
            if (mysqli_num_rows($result) > 0) {

                while ($res = $result->fetch_assoc()) {
                    $userID = $res['userID'];
                    $query = "SELECT * FROM `users` WHERE `ID`='$userID'";

                    if ($result_user = $conn->query($query)) {
                        if (mysqli_num_rows($result_user) > 0) {
                            while ($res_user = $result_user->fetch_assoc()) {
                                $rows[] = array(
                                    "ID" => $res['ID'],
                                    "userID" => $res['userID'],
                                    "TIME_ID" => $res['timeID'],
                                    "dayName" => $res['dayName'],
                                    "dayOfMonth" => $res['dayOfMonth'],
                                    "monthName" => $res['monthName'],
                                    "hour" => $res['hour'],
                                    "price" => $res['price'],
                                    "services" => $res['services'],
                                    "status" => $res['status'],

                                    "first_name" => $res_user['first_name'],
                                    "last_name" => $res_user['last_name'],
                                    "phone" => $res_user['phone'],
                                    "level" => $res_user['level']
                                );
                            }
                        }
                    }

                }
                $res = [
                    "success" => "true",
                    "message" => "successfully",
                    "items" => $rows
                ];

            } else {
                $res = [
                    "success" => "false",
                    "message" => "empty"
                ];
            };


        } else {
            $res = [
                "success" => "false",
                "message" => mysqli_error($conn)
            ];
        }


        return $res;
    }

    function set_reserved_time($reserved, $id)
    {
        $conn = OpenSalizCon();
        mysqli_query($conn, "SET NAMES utf8");

        $query = "UPDATE `times` SET `reserved` = '$reserved' WHERE `times`.`ID` = '$id'";

        if ($res = $conn->query($query)) {

            if ($res)
                return true;
            else
                return false;


        } else {
            return false;
        }
    }


    function queryDayList($day_name)
    {
        return "SELECT * FROM `times`  WHERE `day`='$day_name' ORDER BY `ID`";
    }

    function push_to_row($res)
    {

        return [
            "ID" => $res['ID'],
            "day_of_week" => $res['day_of_week'],
            "day" => $res['day'],
            "hour" => $res['hour'],
            "reserved" => $res['reserved']
        ];
    }

    function push_to_day($res, $row)
    {

        $day = [
            "day" => $res['day'],
            "child" => $row
        ];

        return $day;
    }

    function get_day_name_from_dayOfWeek($day_of_week)
    {
        switch ($day_of_week) {
            case 1 :
                return "Saturday";
                break;

            case 2 :
                return "Sunday";
                break;

            case 3 :
                return "Monday";
                break;

            case 4 :
                return "Tuesday";
                break;

            case 5 :
                return "Wednesday";
                break;

            case 6 :
                return "Thursday";
                break;

            case 7 :
                return "Friday";
                break;
        }
    }
}