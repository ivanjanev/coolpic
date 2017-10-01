<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 18-Dec-16
 * Time: 19:26
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Jquery -->
    <script src="js/jquery-3.1.1.js"></script>

    <!--Bootstrap-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom css  -->
    <link rel="stylesheet" href="css/main.css">


    <title>Image Canvas</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titleDiv text-center">
                    <img src="img/coolPIC.png">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="previewDiv">
                    <img src="#" id="imgPreview">
                    <h3 class="no_img_error hidden">Ве молиме одберете слика</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="uploadDiv">
                    <form action="upload.php" method="POST" enctype="multipart/form-data" id="#uploadForm">
                        <!-- upload btn -->
                        <div class="image-upload">
                            <label for="imgUpload">
                                <img src="img/placeholder.png" class="upload_placeholder" title="Одбери слика"/>
                            </label>
                            <input type="file" name="img" accept="image/*" id="imgUpload">
                        </div>
                        <!-- end upload btn -->
                        <br/>
                        <div class="col-xs-12">
							<label class="filter">
								<input type="radio" name="filter" class="radio_button" value="none">
								<img src="img/filters/none.jpg"><br/>
								<label>Original</label>
							</label>
							<label class="filter">
								<input type="radio" name="filter" class="radio_button" value="sepia">
								<img src="img/filters/sepia.jpg"><br/>
								<label>Sepia</label>
							</label>
							<label class="filter">
								<input type="radio" name="filter" class="radio_button" value="blur">
								<img src="img/filters/blur.jpg"><br/>
								<label>Blur</label>
							</label>
							<label class="filter">
								<input type="radio" name="filter" class="radio_button" value="brighten">
								<img src="img/filters/brighten.jpg"><br/>
								<label>Brighten</label>
							</label>
							<label class="filter">
								<input type="radio" name="filter" class="radio_button" value="grayscale">
								<img src="img/filters/grayscale.jpg"><br/>
								<label>Grayscale</label>
							</label>
							<label class="filter">
								<input type="radio" name="filter" class="radio_button" value="negative">
								<img src="img/filters/negative.jpg"><br/>
								<label>Negative</label>
							</label>
							<label class="filter">
								<input type="radio" name="filter" class="radio_button" value="edges">
								<img src="img/filters/edges.jpg"><br/>
								<label>Edges</label>
							</label>
							<label class="filter">
								<input type="radio" name="filter" class="radio_button" value="colorExt">
								<img src="img/filters/colorExt.jpg"><br/>
								<label>Color Ext</label>
							</label>
                            <label class="filter">
                                <input type="radio" name="filter" class="radio_button" value="mirror">
                                <img src="img/filters/mirror.jpg"><br/>
                                <label>Mirror</label>
                            </label>
							<label class="filter">
								<input type="radio"  name="filter"  class="radio_button" value="channels" data-toggle="collapse" data-target="#demo">
								<img src="img/filters/channels.jpg"><br/>
								<label>Channels</label>
							</label>
						</div>
						<div class="col-xs-12">
							<div id="demo" class="collapse">
								<hr/>
								<label class="filter">
									<input type="radio" name="filter" class="radio_button" value="red">
									<img src="img/filters/red_channel.jpg"><br/>
									<label>Red</label>
								</label>
								<label class="filter">
									<input type="radio" name="filter" class="radio_button" value="green">
									<img src="img/filters/green_channel.jpg"><br/>
									<label>Green</label>
								</label>
								<label class="filter">
									<input type="radio" name="filter" class="radio_button" value="blue">
									<img src="img/filters/blue_channel.jpg"><br/>
									<label>Blue</label>
								</label>
							</div>
						</div>
                        <br/><br/>
                        <input type="submit" id="submit_filter" value="Submit">
                    </form>
                    <input type="button" value="Download" id="downloadBtn" class="btn btn-primary">
                </div>
            </div>
        </div>
        <div class="row color_palette" style="margin-bottom:50px;">
            <div class="col-md-1 color_div" id="1" style="border-radius: 15px 0 0 15px;">

            </div>
            <div class="col-md-1 color_div" id="2">

            </div>
            <div class="col-md-1 color_div" id="3">

            </div>
            <div class="col-md-1 color_div" id="4">

            </div>
            <div class="col-md-1 color_div" id="5">

            </div>
            <div class="col-md-1 color_div" id="6">

            </div>
            <div class="col-md-1 color_div" id="7">

            </div>
            <div class="col-md-1 color_div" id="8">

            </div>
            <div class="col-md-1 color_div" id="9">

            </div>
            <div class="col-md-1 color_div" id="10">

            </div>
            <div class="col-md-1 color_div" id="11">

            </div>
            <div class="col-md-1 color_div" id="12" style="border-radius: 0 15px 15px 0;">

            </div>
        </div>
    </div>


    <script src="js/script.js"></script>
</body>
</html>
