<?php
if (isset($_FILES['sFile'])) {
    if ($_FILES['sFile']['size'] > 0) {
        echo base64_encode(file_get_contents($_FILES['sFile']['tmp_name']));
    }

    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Base 64 Encoder</title>
    <style>
        fieldset {
            border:1px solid gray;
            border-radius:5px;
            width:500px;
            margin-bottom:30px;
            word-wrap: break-word;
        }

        fieldset > div {
            max-width:500px;
            word-wrap: break-word;
            font-family:courier;
            font-size:9pt;
        }
    </style>
    <script src="jquery2.1.3.js"></script>
    <script>
    function progressHandlingFunction(e) {
        if(e.lengthComputable) {
            $('progress').attr({value:e.loaded, max:e.total});
        }
    }

    $(function () {
        $("#form1").on("change", "input[name=\"sFile\"]", function () {
            $("progress").show();
            var formData = new FormData($('#form1')[0]);
            $.ajax({
                url: 'index.php',  //Server script to process data
                type: 'POST',
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Check if upload property exists
                        myXhr.upload.addEventListener('progress', 
                            progressHandlingFunction, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },
                //Ajax events
                //beforeSend: beforeSendHandler,
                success: function (data) {
                    $("#result > div").html(data);
                },
                error: function () {
                    alert("An Error occured!");
                },
                // Form data
                data: formData,
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
    </script>
</head>
<body>
    <fieldset>
        <legend>Select File:</legend>
        <form id="form1" enctype="multipart/form-data">
            <input type="file" name="sFile">
        </form>
        <progress style="display:none;"></progress>
    </fieldset>
    <fieldset id="result">
        <legend>Base 64 Encode</legend>
        <div>
        </div>
    </fieldset>
</body>
</html>
