<?include("global.php");

if(isset($_FILES['file'])){
        
    //upload pic
    if(isset($_FILES["file"])){
        
        
        for ($imageI=0;$imageI<count($_FILES["file"]);$imageI++){
            $random = generateRandomString();
            $target_dir = "./uploads/";
            $fileName_db = "Anomoz_".$random.basename($_FILES["file"]["name"][$imageI]);
            //echo $fileName_db
            $realname =  basename($_FILES["file"]["name"]);
            $target_file = $target_dir . "Anomoz_"."$random".basename($_FILES["file"]["name"][$imageI]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if($_FILES["file"]["tmp_name"][$imageI]!="") {
                
                $uploadOk = 1;
            
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $filename=basename( $_FILES["file"]["name"][$imageI]);
                    $uploadOk = 1;
                }
                // Check file size
                if ($_FILES["file"]["size"][$imageI] > 500000000000000000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if(false) {
                    //echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"][$imageI], $target_file)) {
                        //echo "The file ". basename( $_FILES["file"]["name"][$imageI]). " has been uploaded.";
                        $filename=basename( $_FILES["file"]["name"][$imageI]);
                        $uploadOk = 1;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            
            //$imageI = $imageI+1;
            echo json_encode(array("file"=>array("url"=>"./uploads/".$fileName_db, "id"=> $fileName_db)));
            return "";
        
        }
    }
   


    
    
    

}


?>