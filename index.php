<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <br />
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" class="form-control" /><br />
        <button type="submit" name="upload" class="form-control">Upload</button>
    </form>
    <?php
        include "storage.php";
        include "DbConnect.php";
        
        $storage = new storage();
        // $storage->createBucket("hanzala");
        // $storage->listBucket();
        // print_r($_FILES);exit;
        if(isset($_POST["upload"])){
            $db = new DbConnect();
            $conn = $db->connect();
            $sql = "INSERT INTO files(Name,Size,Update_at) values(:name, :size, now())";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":name",$_FILES["file"]["name"]);
            $stmt->bindParam(":size",$_FILES["file"]["size"]);
            $stmt->execute();
            $storage->uploadObject("hanzalaalam",$_FILES["file"]["name"],$_FILES["file"]["tmp_name"]);
        }
        // $storage->deleteObject("hanzalaalam","bad-removebg-preview.png");
        // $storage->deleteBucket("hanzala");
        $storage->listObjects("hanzalaalam");
        // $storage->downloadObject("hanzalaalam","bad-removebg-preview.png","C:\\xampp\\htdocs\\folonicmov\\bad-removebg-preview.png");
        $img = $storage->imageUrl("hanzalaalam","bad-removebg-preview.png");
        ?><br />
    <img src="<?=$img?>" width="300" />
    <h1>Hanzala is the Beast</h1>
</body>
</html>