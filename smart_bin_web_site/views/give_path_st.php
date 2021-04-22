<form action="give_path.php" method="POST">
    <fieldset>
        <div class="form-group">
            <input id = "af_lat" class="form-control" name="af_lat" placeholder="Latitude" type="class_name" required>
            <input id = "af_lng" class="form-control" name="af_lng" placeholder="Longitude" type="class_name" required>
        </div>
        <div class="form-group">
            <input class="form-control" name="fill_req" placeholder="Fill Requirement" type="class_name" required>
        </div>
        <div class = "form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden = "true" class="glyphicon glyphicon"></span>
                    SUBMIT
            </button>
        </div>
    </fieldset>
</form>
<h3><center>Please Select Location From the MAP Below : </center></h3>
<div id='map'></div>
<script src="js/add_bin_script.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPUQPno2i_CwN8oHisxCakqHJRj79K9U8&callback=initMap"> </script>
