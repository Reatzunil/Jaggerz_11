<?php
require_once 'includes/dbh.inc.php';

if(isset($_POST['accept_reservation'])) {
    // Retrieve reservation ID from the form
    $reservation_id = $_POST['reservation_id'];

    // Insert the reservation ID into the accepted_reservations table
    $sql = "INSERT INTO accepted_reservations (reservation_id) VALUES ($reservation_id)";
    if ($conn->query($sql) === TRUE) {
        echo "Reservation accepted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <title>Jagger Cuts and Tattoo:Administration Page</title>
    
    <!--website's icon-->
    <link rel="icon" type="image/png" href="images-folder/logo.png">

    <!--font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!---custom css file link---->
    <link rel="stylesheet" href="styles_copy.css">

</head>
<body>

<header class="header">
    <a href="#" class="logo">
        <img src="images-folder/logo.png" width="70px">
    </a>
    <nav class="navbar">
        <a href="#products">Product & Services</a>
        <a href="#booking" id="reservations-link">Reservations</a>
    </nav>
    <div class="additional-links"></div>
    <div class="icons">
        <div class="fas fa-bars" id="menu-btn"></div>
    </div>
    <div class="navbar1">
        <a href="index.php">Logout</a>
    </div>
</header>


<section class="products" id="products">

    <h1 class="heading"><span>products</span></h1>

    <div class="box-container">
        
        <div class="box">
            <div class="image">
                <img src="images-folder/product-1.jpg" width="250px" height="350px" alt="">
            </div>
            <div id="stockContainer">
                <div id="stockCount">0</div>
                <button id="incrementBtn">+</button>
            </div>
            <div class="button-container">
                <button class="reject-btn">Add</button>
            </div>
        </div>
    </div>

    <h1 class="heading"><span>Services</span></h1>

    <div class="box-container">
        
        <div class="box">
            <div class="image">
                <img src="images-folder/tattoo.jpg" width="250px" height="350px" alt="">
            </div>
            <div id="stockContainer">
                <div id="stockCount">0</div>
                <button id="incrementBtn">+</button>
            </div>
            <div class="button-container">
                <button class="reject-btn">Add</button>
            </div>
        </div>
    </div>
</section>

<section class="booking" id="booking" style="display:block;">

    <h2>Pending Reservations</h2>

    <div class="reservation-container">
        <div class="table-container">
            <table id="pendingTable">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Availability</th>
                <th>Time</th>
                <th>Services</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            
            <?php
            $sql_pending = "SELECT name, email, number, availability, time, services, image_path, reservation_id 
            FROM reservations 
            WHERE reservation_id NOT IN (SELECT reservation_id FROM accepted_reservations)";
            $result_pending = $conn->query($sql_pending);

            // Check if any rows were returned
            if ($result_pending->num_rows > 0) {
                // Loop through each row
                while ($row = $result_pending->fetch_assoc()) {
                    // Assign values to variables
                    $name = $row["name"];
                    $email = $row["email"];
                    $number = $row["number"];
                    $availability = $row["availability"];
                    $time = $row["time"];
                    $services = $row["services"];
                    $image_path = $row["image_path"];
                    $reservation_id = $row["reservation_id"];

                    // Display the data in table rows
                    echo "<tr>";
                    echo "<td>$name</td>";
                    echo "<td>$email</td>";
                    echo "<td>$number</td>";
                    echo "<td>$availability</td>";
                    echo "<td>$time</td>";
                    echo "<td>$services</td>";
                    echo "<td><img src='$image_path' alt='Image' width='100'></td>";
                    echo "<td>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='reservation_id' value='$reservation_id'>";
                    echo "<button type='submit' name='accept_reservation' class='accept-btn'>Accept</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                // If no rows were returned, display a message in a single row
                echo "<tr><td colspan='7'>No data available</td></tr>";
            }
            ?>
            </table>
        </div>

    </div>
</section>

<section class="booking" id="accepted" style="display:none;">

    <h2>Accepted Reservations</h2>

    <div class="reservation-container">
        <table id="acceptedTable">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Availability</th>
                <th>Time</th>
                <th>Services</th>
                <th>Image</th>
            </tr>
            <?php
            $sql_accepted = "SELECT name, email, number, availability, time, services, image_path 
            FROM reservations 
            WHERE reservation_id IN (SELECT reservation_id FROM accepted_reservations)";
            $result_accepted = $conn->query($sql_accepted);

            // Check if any rows were returned
            if ($result_accepted->num_rows > 0) {
                // Loop through each row
                while ($row = $result_accepted->fetch_assoc()) {
                    // Assign values to variables
                    $name = $row["name"];
                    $email = $row["email"];
                    $number = $row["number"];
                    $availability = $row["availability"];
                    $time = $row["time"];
                    $services = $row["services"];
                    $image_path = $row["image_path"];

                    // Display the data in table rows
                    echo "<tr>";
                    echo "<td>$name</td>";
                    echo "<td>$email</td>";
                    echo "<td>$number</td>";
                    echo "<td>$availability</td>";
                    echo "<td>$time</td>";
                    echo "<td>$services</td>";
                    echo "<td><img src='$image_path' alt='Image' width='100'></td>";
                    echo "</tr>";
                }
            } else {
                // If no rows were returned, display a message in a single row
                echo "<tr><td colspan='7'>No data available</td></tr>";
            }
            ?>
            </table>
        </div>
    </div>
</section>
    

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const productsSection = document.getElementById('products');
    const reservationsSection = document.getElementById('booking');
    const reservationsLink = document.querySelector('.navbar a[href="#booking"]');
    const productsLink = document.querySelector('.navbar a[href="#products"]');

    reservationsSection.style.display = 'none';
    productsSection.style.display = 'block';

    
    reservationsLink.addEventListener('click', function(event) {
        event.preventDefault();
        productsSection.style.display = 'none';
        reservationsSection.style.display = 'block';
    });

    reservationsSection.style.display = 'none';

    
    productsLink.addEventListener('click', function(event) {
        event.preventDefault(); 
        productsSection.style.display = 'block';
        reservationsSection.style.display = 'none';
    });
    
    const pendingTable = document.getElementById('pendingTable');
    const acceptedTable = document.getElementById('acceptedTable');

    // Add event listener to the pending table
    pendingTable.addEventListener('click', function(event) {
        const target = event.target;

        // Check if the clicked element is a button with the class 'accept-btn'
        if (target.classList.contains('accept-btn')) {
            // Get the row containing the clicked button
            const row = target.closest('tr');

            // Move the row to the accepted reservations section
            acceptedTable.appendChild(row);

            // Remove the accept button from the row
            row.querySelector('.accept-btn').remove();
        }
    });
});


document.addEventListener("DOMContentLoaded", function() {
    const productsSection = document.getElementById('products');
    const reservationsSection = document.getElementById('booking');
    const reservationsLink = document.querySelector('.navbar a[href="#booking"]');
    const additionalLinksContainer = document.querySelector('.additional-links');

    reservationsSection.style.display = 'none';
    productsSection.style.display = 'block';
    additionalLinksContainer.style.display = 'none';

    reservationsLink.addEventListener('click', function(event) {
        event.preventDefault();
        productsSection.style.display = 'none';
        reservationsSection.style.display = 'block';
        additionalLinksContainer.style.display = 'block';
    });

    const productsLink = document.querySelector('.navbar a[href="#products"]');
    
    productsLink.addEventListener('click', function(event) {
        event.preventDefault(); 
        productsSection.style.display = 'block';
        reservationsSection.style.display = 'none';
        additionalLinksContainer.style.display = 'none';
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const reservationsLink = document.querySelector('.navbar a[href="#booking"]');
    const acceptedLink = document.createElement('a');
    const additionalLinksContainer = document.querySelector('.additional-links');
    const acceptedSection = document.getElementById('accepted');
    const reservationsSection = document.getElementById('booking');

    acceptedLink.href = '#accepted';
    acceptedLink.textContent = 'Accepted';
    acceptedLink.classList.add('additional-link');
    
    additionalLinksContainer.appendChild(acceptedLink);

    reservationsLink.addEventListener('click', function() {
        acceptedSection.style.display = 'none';
        reservationsSection.style.display = 'block';
    });

    acceptedLink.addEventListener('click', function() {
        acceptedSection.style.display = 'block';
        reservationsSection.style.display = 'none';
    });

    let count = 0;
    const stockCountDiv = document.getElementById('stockCount');
    const incrementBtn = document.getElementById('incrementBtn');

    
    stockCountDiv.textContent = count;

    incrementBtn.addEventListener('click', function() {
        count++;
        stockCountDiv.textContent = count;
    });
});
</script>

<!----custom js file link---->
<script src="script.js"></script>

</body>
</html>