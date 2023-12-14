<?php
require 'vendor/autoload.php';

Error_reporting(E_ERROR | E_PARSE);     //para madisplay yung error sa app

use MongoDB\Client;       //para gumana yung mongodb sa php

// MongoDB Atlas connection
$uri = "mongodb+srv://empirorgodz:5s5gFYrpblgsiHz5@cluster0caps.acf3erq.mongodb.net/"; // Replace with your MongoDB Atlas URI
$databaseName = "ABMS"; // Replace with your database name

// MongoDB Atlas connection
$client = new Client($uri);

// Select your database and collection
$db = $client->selectDatabase($databaseName);
$collection = $db->selectCollection('RENTERS');

// Retrieve the submitted username and password
$username = $_POST['user'];
$password = $_POST['pass']; 

// Query the database to check if the user exists and the password is correct
$user = $collection->findOne(['username' => $username, 'password' => $password]);

if ($user) {
    // User is authenticated
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Blue Background Page</title>
      <style>
        body {
          background: linear-gradient(to bottom, #002e84, #5e8bda); /* Gradient color */
          width: 100%;
          height: 100%;
          color: white;
          font-family: "Times New Roman", Times, serif; /* Times New Roman font */
          margin: 0;
          font-size:30px;
          padding: 20px;
          text-align: center; /* Center align the content */
        }
        /* Style the button separately */
        button {
          padding: 30px 45px; /* Larger padding to increase button size */
          background-color: #ffffff;
          font-color: #1e3c72;
          border-radius: 20px;
          cursor: pointer;
          text-decoration: none; /* Remove underline on hover */
          font-size: 28px; /* Increase font size */
          margin-top: 20px; /* Add margin to the button */
        }
        /* Style the button hover effect */
        button:hover {
          background-color: #f0f0f0;
        }
      </style>
    </head>
    <body>
      <br><br><br><br><br><br><br><br><br><br><br><br><br>
      <h1 style="color:black;"> Login successful! </h1>
      <!-- Use a div or a different container instead of a button inside an anchor tag -->
      <div>
        <a href="../api/index.php" >
          <button>Proceed</button>
        </a>
      </div>
    </body>
    </html>
            ';
} else {
    // Invalid login
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Blue Background Page</title>
      <style>
        body {
          background-color: #2a5298; /* Light blue background */
          color: white;
          font-family: "Times New Roman", Times, serif; /* Times New Roman font */
          margin: 0;
          font-size:30px;
          padding: 20px;
          text-align: center; /* Center align the content */
        }
        /* Style the button separately */
        button {
          padding: 30px 45px; /* Larger padding to increase button size */
          background-color: #ffffff;
          font-color: #1e3c72;
          border-radius: 20px;
          cursor: pointer;
          text-decoration: none; /* Remove underline on hover */
          font-size: 28px; /* Increase font size */
          margin-top: 20px; /* Add margin to the button */
        }
        /* Style the button hover effect */
        button:hover {
          background-color: #f0f0f0;
        }
      </style>
    </head>
    <body>
      <br><br><br><br><br><br><br><br><br><br><br><br><br>
      <h1 style="color:black;"> Invalid username or password. </h1>
      <!-- Use a div or a different container instead of a button inside an anchor tag -->
      <div>
        <a href="../index.html" >
          <button>Go Back</button>
        </a>
      </div>
    </body>
    </html>
            ';
}
