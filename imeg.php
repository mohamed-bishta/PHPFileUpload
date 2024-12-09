<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'):

    $upload_files = $_FILES['my_work'];

    $image_names = $upload_files['name'];
    $image_tmp_names = $upload_files['tmp_name'];
    $image_sizes = $upload_files['size'];
    $image_errors = $upload_files['error'];

    $allowed_file_extensions = array('jpg', 'gif', 'jpeg', 'png');

    if ($image_errors[0] == 4):
        echo '<div>No files were uploaded.</div>';
    else:
        $file_count = count($image_names);


        $all_images = array();

        for ($i = 0; $i < $file_count; $i++) {

            $errors = array();

            $image_extension = strtolower(pathinfo($image_names[$i], PATHINFO_EXTENSION));

            $image_rand_name = rand(0, 1000000000000000) . '.' . $image_extension;

            if ($image_sizes[$i] > 100000):
                $errors[] = '<div>The file size exceeds the allowed limit (100KB).</div>';
            endif;

            if (!in_array($image_extension, $allowed_file_extensions)):
                $errors[] = '<div>The file type is not allowed.</div>';
            endif;

            if (empty($errors)):

                // Try uploading the file
                if (move_uploaded_file($image_tmp_names[$i], $_SERVER['DOCUMENT_ROOT'] . '/git/myimeg/up/' . $image_rand_name)):

                    echo '<div style="background-color: #EEE; padding: 10px; margin-bottom: 10px;">';
                    echo "File number " . ($i + 1) . " uploaded successfully.";
                    echo '<div style="background-color: #EEE; padding: 10px; margin-bottom: 10px;">';
                    echo '<div>File name: ' . $image_names[$i] . '</div>';
                    echo '<div>Random name: ' . $image_rand_name . '</div>';
                    echo '</div>';
                    echo '</div>';

                    // إضافة الاسم العشوائي للمصفوفة
                    $all_images[] = $image_rand_name;

                else:

                    echo '<div style="background-color: #EEE; padding: 10px; margin-bottom: 10px;">';
                    echo "File number " . ($i + 1) . " uploaded successfully.";
                    echo '<div style="background-color: #EEE; padding: 10px; margin-bottom: 10px;">';
                    echo '<div>File name: ' . $image_names[$i] . '</div>';
                    echo '</div>';
                    echo '<div>An error occurred while uploading file number ' . ($i + 1) . '</div>';
                    echo '</div>';

                endif;

            else:

                // Display errors if there are any
                echo "Errors in file number " . ($i + 1) . ":<br>";
                foreach ($errors as $error):
                    echo $error . "<br>";
                endforeach;
            endif;
        }

    endif;

    // طباعة جميع أسماء الملفات بعد رفعها
    $image_files = implode(',', $all_images);

    echo $image_files;

endif;

?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="my_work[]" multiple="multiple">
    <input type="submit" value="Upload Files">
</form>
