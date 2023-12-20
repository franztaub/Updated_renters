<?php
require 'vendor/autoload.php';

error_reporting(E_ERROR | E_PARSE);     //para madisplay yung error sa app

use MongoDB\BSON\Binary; //mag hahandle ng binary data
use MongoDB\Client;     //para gumana yung mongodb sa php

// Replace with your MongoDB Atlas connection string
$connectionString = "mongodb+srv://empirorgodz:5s5gFYrpblgsiHz5@cluster0caps.acf3erq.mongodb.net/";

// Initialize variables para sa mga message
$error_message = "";
$success_message = "";

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
        $age = "Age";
        $email = "";
        $contactno = "";
        $address = "Address";
        $password = "";
        $room_ID = "Room Id";
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
        $room = "Room Id";
        $num = "Contact No.";
        $water = "Water Bill";
        $electric = "Electric Bill";
        $rent = "Rent";
        $date = "";
        $status = "Status";

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Initialize variables
$message = "";
    $tmpName = $_FILES['userImage']['tmp_name'];
    $fileName = $_FILES['userImage']['name'];

    // Check if the file exists before attempting to read its contents
    if (file_exists($tmpName)) {
        // Convert the image file to binary
        $binaryData = file_get_contents($tmpName);
        // Continue with the rest of your code...
    } else {
        // Handle the case where the file does not exist

    }

    // Extract other form data
    $username = $_POST['pay_names'];
    $name = $_POST['name'];
    $timestamp = $_POST['dateTimeTextbox'];

    // Prepare document for MongoDB insertion
    $document = [
        'username' => $username,
        'name' => $name,
        'timestamp' => $timestamp,
        'image' => new MongoDB\BSON\Binary($binaryData, MongoDB\BSON\Binary::TYPE_GENERIC)  // Store the binary data in MongoDB
    ];

    // Insert document into MongoDB collection
    $result = $collectionB->insertOne($document);

    

    // Return a response to the frontend
    if ($result->getInsertedCount() > 0) {
        $message = "Registration successful!";
    } else {
        $message = "Registration failed. Please try again.";
    }
} else {
    
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Simply Amazed HTML Template by Tooplate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../home/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../home/fontawesome/css/all.min.css" type="text/css" /> 
    <link rel="stylesheet" href="../home/css/slick.css" type="text/css" />   
    <link rel="stylesheet" href="../home/css/tooplate-simply-amazed.css" type="text/css" />
<!--

Tooplate 2123 Simply Amazed

https://www.tooplate.com/view/2123-simply-amazed

-->

<style>

.error-label {
          color: red;
      }
      .success-label {
          color: green;
      }

    .nav-link {
        font-family: 'Poppins', sans-serif;
        /* Add any additional styling you want for the navigation links */
    }

    .readonly-text {
        border: none;
        background-color: transparent;
        outline: none;
        width: auto;
        padding: 0;
        font-size: 17px;
        color: #000000;
        font-weight:bold;
        font-family: 'Poppins', sans-serif;
    }

    .form-group {
        margin-bottom: 5px;
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .form-group label {
        color: white;
        flex-basis: 30%; /* Adjust the width of the label column */
        margin-right: 20px; /* Adjust the right margin */
    }

    .form-group input {
        width: 100%;
        flex-basis: 70%; /* Adjust the width of the input column */
        margin-left: 0px; /* Adjust the left margin */
    }

    @media (max-width: 768px) {
        /* Adjust styles for screens up to 768px wide */
        .form-group label {
            flex-basis: 40%;
        }

        .form-group input {
            flex-basis: 60%;
        }
    }

    @media (max-width: 576px) {
        /* Adjust styles for screens up to 576px wide */
        .form-group label {
            flex-basis: 50%;
        }

        .form-group input {
            flex-basis: 50%;
        }
    }
</style>

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
        <div style="display: block; background: linear-gradient(to bottom, #002e84, #5e8bda);" class="banner-section section parallax-window" data-parallax="scroll" id="section-1">
                <div class="container">
                    <div class="item">
                        <div ><span><img src="../home/logo.png"  width="400" height="400"></span></div>
                        <div ><p style="font-size: 1.5em; font-style: italic; color:white; font-family:Poppins;">"Quality Service at its finest"</p></div>
                    </div>

                </div>
            </div>
        
            <section style="display: none; background: linear-gradient(to top, #002e84, #5e8bda);" class="work-section section" data-parallax="scroll" id="section-2">
                <div class="container">
                <div class="title">
                        <h1 style="font-weight: bold; color:white; font-family:Poppins;">Personal Info</h1>
                    </div>
                <form action="index.php" method="POST">
                <br>
                <label for="username" style="color:white; font-family:Poppins;">Username:</label>&nbsp;&nbsp;
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
          <label style="color:white;" readonly class="readonly-text">Name:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="name" name="name" placeholder="Name" value="<?= $name ?>"  readonly class="readonly-text" />
          <br>
          <label style="color:white; font-family:Poppins;">Age:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="age" name="age" placeholder="Age" value="<?= $age ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white; font-family:Poppins;">Email:</label>&nbsp;&nbsp;
          <br>
          <input style="font-family:Poppins;" type="text" id="email" name="email" placeholder="Email" value="<?= $email ?>" />
          <br>
          <label style="color:white; font-family:Poppins;">Contact:</label>&nbsp;&nbsp;
          <br>
          <input style="font-family:Poppins;" type="text" id="contact" name="contact" placeholder="Contact No." value="<?= $contactno ?>" />
          <br>
          <label style="color:white;">Address:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="address" name="address" placeholder="Address"  value="<?= $address ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Password:</label>&nbsp;&nbsp;
          <br>
          <input type="password" id="pass" name="pass" placeholder="" value="<?= $password ?>" readonly class="readonly-text"/>
          <br>
          <label style="color:white;">Room Id:</label>&nbsp;&nbsp;
          <br>
          <input type="text" id="room" name="room" placeholder="Room Id"  value="<?= $room_ID ?>" readonly class="readonly-text"/>
          <br>   
	<br>
        <button type="submit" id="displayButton" name="display" class="btn btn-primary" style="font-family: 'Poppins', sans-serif;">Display</button>
        <button type="submit" id="updateButton" name="update" class="btn btn-primary" style="font-family: 'Poppins', sans-serif;">Update</button>
          
        </form>   
                </div>
            </section>

            <section style="display: none; background: linear-gradient(to bottom, #002e84, #5e8bda);" class="gallery-section section parallax-window" data-parallax="scroll" id="section-3">
                <div class="container">
                <div class="title">
                        <h1 style="font-weight: bold; color:black; font-family: 'Poppins', sans-serif;">Transaction History</h1>
                    </div>
   <form action="index.php" method="POST">
   <div class="form-group">
                <label style="color:white; font-family: Poppins" readonly class="readonly-text">Username:</label>&nbsp;&nbsp;
                <br>
                <label style="color:white;"readonly class="readonly-text">Room Id:</label>
            </div>
            <div class="form-group">
                <input type="text" id="names" name="names" placeholder="name"  readonly class="readonly-text"/>
                <br>
                <input type="text" id="roomid" name="roomid" placeholder="Room Id" value="<?= $room ?>"  readonly class="readonly-text" />
            </div>
          <script>
					// Retrieve the name from localStorage
					var name = localStorage.getItem("user");
			
					// Display the name on page2.html
					if (name) {
						document.getElementById("names").value = name;
					}
		    </script>
          <div class="form-group">
                <label style="color:white;" readonly class="readonly-text">Name:</label>
                <br>
                <label style="color:white;" readonly class="readonly-text">Water Bill:</label>&nbsp;&nbsp;
          </div>
          <div class="form-group">
                <br>
                <input type="text" id="n" name="n" placeholder="name"  value="<?= $n  ?>" readonly class="readonly-text"/>
                <br>
                <input type="text" id="water" name="water" placeholder="Water Bill" value="<?= $water ?>" readonly class="readonly-text" />
          </div>
          <div class="form-group">
                <label style="color:white;" readonly class="readonly-text">Contact No.:</label>&nbsp;&nbsp;
                <br>
                <label style="color:white;" readonly class="readonly-text">Rent:</label>&nbsp;&nbsp;
                <br>
          </div>
          <div class="form-group">
                <input type="text" id="num" name="num" placeholder="Contact No." value="<?= $num ?>" readonly class="readonly-text"/>
                <br>
                <input type="text" id="rent" name="rent" placeholder="Rent"  value="<?= $rent ?>" readonly class="readonly-text"/>
                </div>
          <div class="form-group">
                <label style="color:white;" readonly class="readonly-text">Electric Bill:</label>&nbsp;&nbsp;
                <br>
                <label style="color:white;" readonly class="readonly-text">Status:</label>&nbsp;&nbsp;
                <br>
          </div>
          <div class="form-group">
                <input type="text" id="electric" name="electric" placeholder="Electric Bill" value="<?= $electric ?>" readonly class="readonly-text"/>
                <br>
                <input type="text" id="status" name="status" placeholder="status" value="<?= $status ?>" readonly class="readonly-text"/>
                <br>
          </div>
          <div class="form-group">
                <label style="color:white;" readonly class="readonly-text">Date:</label>&nbsp;&nbsp;
                <br>        
          </div>
          <div class="form-group">
                <input type="datetime-local" id="date" name="date" placeholder="Date" value="<?= $date ?>" readonly class="readonly-text"/>
                <br>
          </div>
        <br>
          <div class="form-group d-flex align-items-center justify-content-center">
                <button type="submit" id="display" name="show" class="btn btn-primary" style="font-family: 'Poppins'">Display</button>
          </div>
   
          
        </form>   
        
                </div>
            </section>

            <section style="display: none; background: linear-gradient(to top, #002e84, #5e8bda);" class="contact-section section" data-parallax="scroll" id="section-4">

            <br><label id="error-label" class="error-label"><?php echo $error_message; ?></label><br>
        <label id="success-label" class="success-label"><?php echo $success_message; ?></label><br>


                <div class="container">

               
                    <div class="title">
                        <h1 style="font-weight: bold; color:white; font-family: 'Poppins', sans-serif;" >Pay Now</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-5 col-md-6 mb-4 contact-form">
                            <div class="form tm-contact-item-inner">
                                
                            <form ID="paymentForm" method="POST" enctype="multipart/form-data">
                            
                                <!-- ... other form fields ... -->
                                <input type="text" id="pay_names" name="pay_names" placeholder="name"  readonly class="readonly-text" style="display: none;"/>
                                <br>
                                <script>
                                        // Retrieve the name from localStorage
                                        var name = localStorage.getItem("user");
                                
                                        // Display the name on page2.html
                                        if (name) {
                                            document.getElementById("pay_names").value = name;
                                        }
                                </script>
                                    <br>
                                    <label style="color:white;" readonly class="readonly-text">Your Name:</label>&nbsp;&nbsp;
                                    <br>
                                    <input type="text" id="name" name="name" placeholder="Name" />
                                    <input type="text" id="dateTimeTextbox" name="dateTimeTextbox" readonly style="display: none;">
                                    <script>
                                        function updateDateTime() {
                                        // Get the current date and time
                                        var currentDate = new Date();

                                        // Format the date and time
                                        var formattedDateTime = currentDate.toLocaleString();

                                        // Update the value of the textbox
                                        document.getElementById('dateTimeTextbox').value = formattedDateTime;
                                        }

                                        // Call the function initially and set an interval to update every second
                                        updateDateTime();
                                        setInterval(updateDateTime, 1000);
                                    </script>
                                    <br>
                                    <label style="color:white;" readonly class="readonly-text">Upload your receipt here</label>
                                    <input style="color:white;" id="userImage" name="userImage" type="file" class="form-control">
                                    <br>
                                <button type="submit" id="new" onclick="uploadPayment()" style="font-family: 'Poppins', sans-serif;">Upload Now</button>

                                <br><br>
                                        <!-- Display the success or error message -->
                                        <?php if (isset($message) && !empty($message)): ?>
                                            <p style="color:yellowgreen;"><?php echo $message; ?></p>
                                        <?php endif; ?>
                            </form> 
                                    
                            
                                
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
