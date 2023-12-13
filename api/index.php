<?php
require 'vendor/autoload.php';

error_reporting(E_ERROR | E_PARSE);     //para madisplay yung error sa app

use MongoDB\Client;     //para gumana yung mongodb sa php

// Replace with your MongoDB Atlas connection string
$connectionString = "mongodb+srv://empirorgodz:5s5gFYrpblgsiHz5@cluster0caps.acf3erq.mongodb.net/";

try {
    $client = new Client($connectionString);
    $collection = $client->ABMS->RENTERS; // Replace with your database and collection names
    $collectionA = $client->ABMS->TRANSACTIONS; // Replace with your database and collection names
    $collectionB = $client->ABMS->PAYMENTS; // Replace with your database and collection names

 
    if (isset($_POST['username'])) {
        $Username = $_POST['username'];
        $filter = ['username' => $Username];
        $userInfo = $collection->findOne($filter);

        // Continue with the rest of your code
        $name = $userInfo['name'];
        $age = $userInfo['age'];
        $email = $userInfo['email'];
        $contactno = $userInfo['contactno'];
        $address = $userInfo['address'];
        $password = $userInfo['password'];
        $room_ID = $userInfo['room_ID'];
        $ebill = $userInfo['ebill'];
        $wbill = $userInfo['wbill'];
   
    } else {
        // Handle the case where "Username" is not set in the POST request
        // You can display an error message or take appropriate action.
        $name = "no info";
        $age = "";
        $email = "";
        $contactno = "";
        $address = "";
        $password = "";
        $room_ID = "";
        $ebill = "";
        $wbill = "";

    }

    if (isset($_POST['display'])) {
        // Handle the "Display" button click
        // You can keep your existing display logic here
    } elseif (isset($_POST['update'])) {
        $qUsername = $_POST['username'];
        // Handle the "Update" button click
        $qemail = $_POST['email'];
        $qcontactno = $_POST['contact'];
        

        // Create an update filter based on the username
        $filter = ['username' => $qUsername];

        // Create an update document with the new values
        $updateDocument = [
            '$set' => [
                'email' => $qemail,
                'contactno' => $qcontactno
            ]
        ];

        // Perform the update in the MongoDB database
        $result = $collection->updateOne($filter, $updateDocument);

        if ($result->getModifiedCount() > 0) {
            // The update was successful
            echo "User information updated successfully!";
        } else {
            // The update did not modify any documents (username not found)
            echo "User not found or no changes were made.";
        }
    
    } elseif (isset($_POST['show'])) {
        $names = $_POST['names'];
        $filter = ['username' => $names];
        $user = $collectionA->findOne($filter);

        // Continue with the rest of your code
        $n = $user['name'];
        $room = $user['room_ID'];
        $num = $user['contact_no'];
        $water = $user['Water_bill'];
        $electric = $user['electricity_bill'];
        $rent = $user['rent'];
        // Assuming $user['date'] contains a MongoDB Date type
        $mongoDate = $user['date'];

        // Convert MongoDB Date to PHP DateTime object
        $dateTime = $mongoDate->toDateTime();

        // Format the date to yyyy-mm-ddThh:mm
        $formattedDate = $dateTime->format('Y-m-d\TH:i');

        // Assign the formatted date to the $date variable
        $date = $formattedDate;

        $status = $user['status'];
   
    } else {
        // Handle the case where "Username" is not set in the POST request
        // You can display an error message or take appropriate action.
        $n = "no info";
        $room = "";
        $num = "";
        $contact = "";
        $water = "";
        $electric = "";
        $rent = "";
        $date = "";
        $status = "";

    }

} catch (MongoDB\Driver\Exception\Exception $e) {
    $name = "cannot connect";
    $age = "";
    $email = "";
    $contactno = "";
    $address = "";
    $password = "";
    $room_ID = "";
}

// Handle file upload
if ($_FILES['userImage']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['userImage']['tmp_name'];
    $fileName = $_FILES['userImage']['name'];

    // Convert the image file to binary
    $binaryData = file_get_contents($tmpName);

    // Extract other form data
    $username = $_POST['username'];
    $name = $_POST['name'];
    $timestamp = $_POST['timestamp'];

    // Prepare document for MongoDB insertion
    $document = [
        'name' => $name,
        'timestamp' => $timestamp,
        'image' => new MongoDB\BSON\Binary($binaryData, MongoDB\BSON\Binary::TYPE_GENERIC)  // Store the binary data in MongoDB
    ];

    // Insert document into MongoDB collection
    $result = $collectionB->insertOne($document);

    // Return a response to the frontend
    if ($result->getInsertedCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Payment and image uploaded successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload payment and image.']);
    }
} else {
    
}

?>

<style>
    .readonly-text {
        border: none;
        background-color: transparent;
        outline: none;
        width: auto;
        padding: 0;
        font-size: 17px;
        color: #000000;
        font-weight:bold;
    }
</style>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Simply Amazed HTML Template by Tooplate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../home/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../home/fontawesome/css/all.min.css" type="text/css" /> 
    <link rel="stylesheet" href="../home/css/slick.css" type="text/css" />   
    <link rel="stylesheet" href="../home/css/tooplate-simply-amazed.css" type="text/css" />
<!--

Tooplate 2123 Simply Amazed

https://www.tooplate.com/view/2123-simply-amazed

-->



</head>

<body>
    <div id="outer">
        <header class="header order-last" id="tm-header">
            <nav class="navbar">
                <div class="collapse navbar-collapse single-page-nav">
                <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="#section-1"><span class="icn"><i class="fas fa-th-large"></i></span>Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#section-2" onclick="showSection('section-2')"><span class="icn"><i class="fas fa-user-tie"></i></span>Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#section-3" onclick="showSection('section-3')"><span class="icn"><i class="fas fa-tasks"></i></span>Transaction History</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#section-4" onclick="showSection('section-4')"><span class="icn"><i class="fas fa-tag"></i></span>Upload Receipts</a>
    </li>
    </ul>
    </div>
    <a id="logoutButton" class="btn btn-danger" style="left:80px; top:20px; color:white; font-size: 35px;"><i class="fas fa-times"></i> LOGOUT</a>
    <script>
    document.getElementById('logoutButton').addEventListener('click', function() {
      var confirmation = confirm("Are you sure you want to Log out?");
      
      if (confirmation) {
        // Perform logout action here or redirect to logout page
        // For example: window.location.href = "logout.php";
        window.location.href = "../index.html";
      } else {
        console.log("Logout action canceled");
      }
    });
    </script>
            </nav>
        </header>
    <!-- Ito nman yung mga  button sa home page-->
        <button class="navbar-button collapsed" type="button">      
            <span class="menu_icon">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </span>
        </button>
        
        <main id="content-box" class="order-first">
            <div style="display: block;" class="banner-section section parallax-window" data-parallax="scroll" data-image-src="../home/img/section-1-bg.jpg" id="section-1">
                <div class="container">
                    <div class="item">
                        <div ><span><img src="../home/logo.png"  width="400" height="400"></span></div>
                        <div ><p style="font-size: 1.5em; font-style: italic; color:white;">"Quality Service at its finest"</p></div>
                    </div>

                </div>
            </div>
        
            <section style="display: none;" class="work-section section" data-parallax="scroll" data-image-src="../home/img/4.jpg" id="section-2">
                <div class="container">
                <div class="title">
                        <h1 style="font-weight: bold; color:white;">Personal Info</h1>
                    </div>
                <form action="index.php" method="POST">
                <br>
                <label for="username" style="color:white;">Username:</label>&nbsp;&nbsp;
                <br>
          <input type="text" id="username" name="username" placeholder="Username" readonly class="readonly-text" />
          <script>
					// Retrieve the name from localStorage
					var name = localStorage.getItem("user");
			
					// Display the name on page2.html
					if (name) {
						document.getElementById("username").value = name;
					}
		    </script>
          <br>
          <label style="color:white;">Name:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="name" name="name" placeholder="Name" value="<?= $name ?>"  readonly class="readonly-text" />
          <br>
          <label style="color:white;">Age:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="age" name="age" placeholder="Age" value="<?= $age ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Email:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="email" name="email" placeholder="Email" value="<?= $email ?>" />
          <br>
          <label style="color:white;">Contact:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="contact" name="contact" placeholder="Contact No." value="<?= $contactno ?>" />
          <br>
          <label style="color:white;">Address:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="address" name="address" placeholder="Address"  value="<?= $address ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Password:</label>&nbsp;&nbsp;
          <br>
          <input type="password" id="pass" name="pass" placeholder="Password" value="<?= $password ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Room Id:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="room" name="room" placeholder="Room Id"  value="<?= $room_ID ?>" readonly class="readonly-text"/>
          <br>   
	<br>
        <button type="submit" id="displayButton" name="display" class="btn btn-primary">Display</button>
        <button type="submit" id="updateButton" name="update" class="btn btn-primary">Update</button>
          
        </form>   
                </div>
            </section>

            <section style="display: none;" class="gallery-section section parallax-window" data-parallax="scroll" data-image-src="../home/img/1.jpg" id="section-3">
                <div class="container">
                <div class="title">
                        <h1 style="font-weight: bold; color:black;">Transaction History</h1>
                    </div>
   <form action="index.php" method="POST">
                <label style="color:white;">Username:</label>&nbsp;&nbsp;
                <br>
          <input type="text" id="names" name="names" placeholder="name"  readonly class="readonly-text"/>
          <script>
					// Retrieve the name from localStorage
					var name = localStorage.getItem("user");
			
					// Display the name on page2.html
					if (name) {
						document.getElementById("names").value = name;
					}
		    </script>
          <br>
          <label style="color:white;">Name:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="n" name="n" placeholder="name"  value="<?= $n  ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Room Id:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="roomid" name="roomid" placeholder="Room Id" value="<?= $room ?>"  readonly class="readonly-text" />
          <br>
          <label style="color:white;">Contact No.:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="num" name="num" placeholder="Contact No." value="<?= $num ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Water Bill:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="water" name="water" placeholder="Email" value="<?= $water ?>" readonly class="readonly-text" />
          <br>
          <label style="color:white;">Electric Bill:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="electric" name="electric" placeholder="Electric Bill" value="<?= $electric ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Rent:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="rent" name="rent" placeholder="Rent"  value="<?= $rent ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Date:</label>&nbsp;&nbsp;
          <br>
          <input type="datetime-local" id="date" name="date" placeholder="Date" value="<?= $date ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Status:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="status" name="status" placeholder="status" value="<?= $status ?>" readonly class="readonly-text"/>
          <br>

	<br>
    <button type="submit" id="display" name="show" class="btn btn-primary">Display</button>                  
   
          
        </form>   
        
                </div>
            </section>

            <section style="display: none;" class="contact-section section" data-parallax="scroll" data-image-src="../home/img/3.jpg" id="section-4">
                <div class="container">
                    <div class="title">
                        <h1 style="font-weight: bold; color:white;">Pay Now</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-6 mb-4 contact-form">
                            <div class="form tm-contact-item-inner">
                                
                            <form id="paymentForm" enctype="multipart/form-data">
                                <!-- ... other form fields ... -->
                                <div class="form-group">
                                    <br>
                                    <label style="color:white;">Your Name:</label>&nbsp;&nbsp;
                                    <br>
                                    <input type="text" id="pay_name" name="pay_name" placeholder="Name" value="<?= $email ?>" />
                                    <br>
                                    <br>
                                    <label style="color:white;">Upload your receipt here</label>
                                    <input style="color:white;" id="userImage" name="userImage" type="file" class="form-control">
                                </div>
                                <button type="button" onclick="uploadPayment()">Upload Now</button>
                            </form> 
                                    
                            <script>
    function uploadPayment() {
    var formData = new FormData(document.getElementById("paymentForm"));

    // Add additional data to formData
    var name = document.getElementById("pay_name").value;
    formData.append("name", name);

    // Add current time (UNIX timestamp) as a Date object to formData
    var currentTime = new Date();
    formData.append("timestamp", currentTime.toISOString()); // Convert Date to ISO format

    // Perform AJAX upload or submit the form to handle the file on the server
    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server
        console.log(data);

        if (data.success) {
            // If upload is successful, clear the text and file input fields
            document.getElementById("pay_name").value = '';
            document.getElementById("userImage").value = '';
        }
    })
    .catch(error => {
       
    });
    }


</script>
                                
                            </div>
                        </div>
                      
                    </div>                
                </div>
               
            </section>
        </main>
       

    </div>
    <script src="../home/js/jquery-3.3.1.min.js"></script>
    <script src="../home/js/bootstrap.bundle.min.js"></script>
    <script src="../home/js/jquery.singlePageNav.min.js"></script>
    <script src="../home/js/slick.js"></script>
    <script src="../home/js/parallax.min.js"></script>
    <script src="../home/js/templatemo-script.js"></script>

    <script>
    function showSection(sectionId) {
        // Hide all sections
        var sections = document.querySelectorAll('section');
        sections.forEach(function(section) {
            section.style.display = 'none';
        });
        
        // Display the selected section
        var selectedSection = document.getElementById(sectionId);
        if (selectedSection) {
            selectedSection.style.display = 'block';
        }
    }
</script>



</body>
</html>
