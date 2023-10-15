
<?php 
session_start(); 
$color="navbar-dark cyan darken-3";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="SHORTCUT ICON" href="images/fibble.png" type="image/x-icon" />
    <link rel="ICON" href="images/fibble.png" type="image/ico" />

    <title>Grp61 - OwnerShip Transfer</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

    <style>
      /* Apply styling to the select element */
      select#item {
        width: 80%; 
        padding: 5px;
        border: 1px solid #ccc;
        border-radius:2px;
      }

      
      select#item option {
        padding: 5px;
      }
</style>

  </head>
  <?php
    if( $_SESSION['role']==0 || $_SESSION['role']==1  ){
      
  ?>
  <body class="violetgradient">
    <?php include 'navbar.php'; ?>
    <center>
        <div class="customalert">
            <div class="alertcontent">
                <div id="alertText"> &nbsp </div>
                <img id="qrious">
                <div id="bottomText" style="margin-top: 10px; margin-bottom: 15px;"> &nbsp </div>
                <button id="closebutton" class="formbtn"> Done </button>
            </div>
        </div>
    </center>

    <div class="bgroles">
      <center>
        <div class="mycardstyle">
            <div class="greyarea">
                <h5> Please fill the following information  </h5>
                <form id="form2" autocomplete="off">
                    <div class="formitem">
                        <label type="text" class="formlabel"> Received Product ID </label>
                        <input type="text" class="forminput" id="prodid" onkeypress="isInputNumber(event)" required>
                        <label class=qrcode-text-btn style="width:4%;display:none;">
                            <input type=file accept="image/*" id="selectedFile" style="display:none" capture=environment onchange="openQRCamera(this);" tabindex=-1>
                        </label>
                        <button class="qrbutton2" onclick="document.getElementById('selectedFile').click();" style="margin-bottom: 5px;margin-top: 5px;">
                        <i class='fa fa-qrcode'></i> Scan QR
		                </button
                    </div>
                    <div class="formitem">
                        <?php 
                            include 'connectdb.php';
                            $conn = openConnection();
                            $userUsername = $_SESSION['username'];
                            $userUserId = $_SESSION['email'];
                            $role = $_SESSION['role'];
                            $role = $role + 1;
                            $sql = "SELECT email,username FROM users where role='$role'";
                            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        ?>

                        <label for="prodlocation" class="formlabel">Transfer Ownership</label>
                        <select name="item" id="item" >
                            <option  value="">Select New Owner</option>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                echo "<option id='item' value='" . $row['username'] . "'>" . $row['email'] . "</option>";
                            }
                            ?>
                        </select>

                        <input type="hidden" class="forminput" id="role" value="<?php echo $_SESSION['role']; ?>" required>
                        <input type="hidden" class="forminput" id="email" value="<?php echo $_SESSION['email']; ?>" required>
                    </div>

                    <button class="formbtn" id="mansub" type="submit">Update</button>
                </form>
            </div>
      </center>
    <?php
    }else{
        include 'redirection.php';
        redirect('index.php');
    }
    ?>

    <div class='box'>
       <div class='wave -one'></div>
      <div class='wave -two'></div>
      <div class='wave -three'></div>
    </div>
    
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Material Design Bootstrap-->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <!-- Web3.js -->
    <script src="web3.min.js"></script>

    <!-- QR Code Library-->
    <script src="./dist/qrious.js"></script>

    <!-- QR Code Reader -->
	<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>

    <script src="app.js"></script>

    <!-- Web3 Injection -->
    <script>
      // Initialize Web3
      if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://127.0.0.1:7545'));
      } else {
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://127.0.0.1:7545'));
      }

      // Set the Contract
    var contract = new web3.eth.Contract(contractAbi, contractAddress);



    $("#manufacturer").on("click", function(){
        $("#districard").hide("fast","linear");
        $("#manufacturercard").show("fast","linear");
    });

    $("#distributor").on("click", function(){
        $("#manufacturercard").hide("fast","linear");
        $("#districard").show("fast","linear");
    });

    $("#closebutton").on("click", function(){
        $(".customalert").hide("fast","linear");
    });


    $('#form1').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodname = $('#prodname').val();
        console.log(prodname);
        var today = new Date();
        var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        
        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.newItem(prodname, thisdate).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              var msg="<h5 style='color: #53D769'><b>Item Added Successfully</b></h5><p>Product ID: "+receipt.events.Added.returnValues[0]+"</p>";
              qr.value = receipt.events.Added.returnValues[0];
              $bottom="<p style='color: #FECB2E'> You may print the QR Code if required </p>"
              $("#alertText").html(msg);
              $("#qrious").show();
              $("#bottomText").html($bottom);
              $(".customalert").show("fast","linear");
          });
          //console.log(receipt);
        });
        $("#prodname").val('');
        
    });

    // Code for detecting location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
    function showPosition(position) {
        var autoLocation = "New Owner ID";
        $("#prodlocation").val(autoLocation);
    }


$('#form2').on('submit', function(event) {
    event.preventDefault(); // to prevent page reload when the form is submitted
    var prodid = $('#prodid').val();
    var role = $('#role').val();
    var email = $('#email').val();
    var value = "Customer";

    console.log(email);

    if (role == 0) {
        value = "Distributor";
    }

    // Fetch selected user information
    var userName = $('#item option:selected').text();
    var userId = $('#item').val();

    // First AJAX call to fetch owner value
    $.ajax({
        url: 'ownerShip.php', // Specify the URL of your PHP script
        method: 'POST',
        data: {
            email: email,
            productId: prodid
        },
        success: function(response) {
            console.log("Response is " + response);
            var owner = response;

            if (owner === "yes") {
                // Proceed with the Web3 code
                var today = new Date();
                var thisdate = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                var info = "<br><br><b>Date: " + thisdate + "</b><br><b>New Owner Name: " + userId + "</b><br><b>Owner Id: " + userName + "</b><br><b>Role: " + value + "</b>";
                web3.eth.getAccounts().then(async function(accounts) {
                    var receipt = await contract.methods.addState(prodid, info).send({ from: accounts[0], gas: 1000000 })
                        .then(receipt => {
                            var msg = "Item has been updated ";
                            $("#alertText").html(msg);
                            $("#qrious").hide();
                            $("#bottomText").hide();
                            $(".customalert").show("fast", "linear");

                            // Continue with the second AJAX request
                            $.ajax({
                                url: 'getProduct.php', // Specify the URL of your PHP script
                                method: 'POST',
                                data: {
                                    email: email,
                                    productId: prodid,
                                },
                                success: function(response) {
                                    console.log(response);
                                    if (response === 'Product not found 111') {
                                        console.log('Product not found');
                                    } else {
                                        var productName = response;
                                    }

                                    // After you get the product name, you can make the third AJAX request
                                    $.ajax({
                                        url: 'inserttoProduct.php', // Specify the URL of your PHP script
                                        method: 'POST',
                                        data: {
                                            email: userName,
                                            username: userId,
                                            prodname: productName.trimStart(),
                                            productId: prodid,
                                            role: Number(role) + 1
                                        },
                                        success: function(response) {
                                            console.log(response);
                                        },
                                        error: function(error) {
                                            console.error(error);
                                        }
                                    });
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            });
                        });
                });
                $("#prodid").val('');
            } else {
                console.log('Owner value is not 1. Web3 code not executed.', owner);
                var msg = "You are not the owner ";
                $("#alertText").html(msg);
                $("#qrious").hide();
                $("#bottomText").hide();
                $(".customalert").show("fast", "linear");
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
});


    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }


    function openQRCamera(node) {
		var reader = new FileReader();
		reader.onload = function() {
			node.value = "";
			qrcode.callback = function(res) {
			if(res instanceof Error) {
				alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
			} else {
				node.parentNode.previousElementSibling.value = res;
				document.getElementById('searchButton').click();
			}
			};
			qrcode.decode(reader.result);
		};
		reader.readAsDataURL(node.files[0]);
	}
  
// About
  function showAlert(message){
      $("#alertText").html(message);
      $("#qrious").hide();
      $("#bottomText").hide();
      $(".customalert").show("fast","linear");
    }

    $("#aboutbtn").on("click", function(){
        showAlert("P2P Ownership Verification against Fake Products");
     

    });

    </script>
  </body>
</html>
