<pre>
<?php
    //TODO: Figure out how to get this to work
    echo class_exists('ZipArchive');
    $classid = $_GET['class'];
    $assignmentid=$_GET['assignment'];
    echo "Got class $classid and assignment $assignmentid";
    $zip = new ZipArchive();
    echo "zip created\n";
    $download = "assignment_$assignmentid.zip";
    if($zip-> open($download, ZipArchive::CREATE)){
        echo "zip opened\n";
        $folderToZip = "class_data/$classid/assignments/assignment_$assignmentid/*";
        foreach(glob($folderToZip) as $file)
        {
            if($zip->addFile($file)){
                echo "$file added to zip\n";
            }
        }
        if($zip->close()){
            echo "zip closed\n";
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=$download");
            header("Content-Length: " . filesize($download));
            header("Location: $download");
        }

    }


?>

</pre>