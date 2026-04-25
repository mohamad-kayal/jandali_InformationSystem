<!DOCTYPE html>
<html>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <?php require_once('helpers.php'); echo csrf_input(); ?>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit_image">
</form>
</body>
</html>
<?php
require_once('helpers.php');  
if(isset($_POST["submit_image"])){
if(!verify_csrf($_POST)){
    echo 'Invalid request';
    exit;
}
$final_dir="";
$target_dir = "images/logos/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}
$safe_name = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($_FILES["fileToUpload"]["name"]));
$target_file = $target_dir . $safe_name;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". h($safe_name). " has been uploaded.";
        $final_dir="images/logos/" .$safe_name;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
if ($final_dir !== '') {
    db_execute($conn, "INSERT INTO logo VALUES (NULL, ?, ?)", "ss", ['someimg', $final_dir]);
}
}

?>
