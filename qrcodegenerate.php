<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            margin:0;
            background-color:#ecfab6;
        }
    </style>
</head>
<body>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-outline-secondary">
                        <div class="card-header">
                            <h3 class="mb-0">User Information</h3>

                            <?php 
                            $first_name = "Swornabindu";
                            $last_name = "Bardiya";
                            $email = "sb@gmail.com";
                            $company = "pramsoft";
                            $website = "https://www.google.com";

                            if(isset ($_POST["btnsubmit"])){
                                $first_name = $_POST["first_name"];
                                $last_name = $_POST["last_name"];
                                $email = $_POST["email"];
                                $company = $_POST["company"];
                                $website =$_POST ["website"];
                            
                                echo "<pre>";
                                var_dump($_POST);
                                echo"</pre>";
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <form action="qrcodegenerate.php" method="post" autocomplete="off" class="form">
                                <div class="form-group row">
                                    <label for="" class="col-lg-3 col-form-label form-control-label">First name</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" value="<?php echo $first_name;?>" name="first_name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-lg-3 col-form-label form-control-label">Last name</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" value="<?php echo $last_name;?>" name="last_
                                        name">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="" class="col-lg-3 col-form-label form-control-label">Email</label>
                                    <div class="col-lg-9">
                                        <input type="email" class="form-control" value="<?php echo $email;?>" name="email">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="" class="col-lg-3 col-form-label form-control-label">Company</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" value="<?php echo $company;?>" name="company">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-lg-3 col-form-label form-control-label">Website</label>
                                    <div class="col-lg-9">
                                        <input type="url" class="form-control" value="<?php echo $website;?>" name="website">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" name="btnsubmit" value="Generate QR Code">
                                    </div>
                                </div>
                            </form>
                            <?php
                            include "phpqrcode/qrlib.php";
                            $PNG_TEMP_DIR ='temp/';
                            if(!file_exists($PNG_TEMP_DIR)){
                                mkdir($PNG_TEMP_DIR);
                                }
                            // $filename= $PNG_TEMP_DIR. 'test.png';
                            if(isset($_POST["btnsubmit"])) {
                                $codeString = $_POST["first_name"]."\n";
                                $codeString .= $_POST["last_name"]."\n";
                                $codeString .=$_POST["email"]."\n";
                                $codeString .=$_POST["company"]."\n";
                                $codeString .= $_POST ["website"];

                                $filename = $PNG_TEMP_DIR .'test' .
                                md5($codeString). '.png';
                                QRcode :: png ($codeString, $filename);

                                echo '<img src="' . $PNG_TEMP_DIR . basename($filename) . '" />';

                            }
                            ?>

                            <?php
if (extension_loaded('gd') && function_exists('imagecreatetruecolor')) {
    echo "GD Library Enabled";
} else {
    echo "GD NOT Enabled";
}
?>

                        </div>

                    </div>

                </div>

            </div>

            </div>

        </div>
    </div>
</body>
</html>