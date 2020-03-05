      <!-- Sticky Footer -->
    <!-- <footer class="sticky-footer">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright © Your Website 2019</span>
            </div>
        </div>
    </footer> -->
        <?php 
            /*
                System checks. Do not remove. Just move the closing comment at the bottom of this sentence and you're good to go.
            

            if(isset($_SESSION['userdata'])){ echo var_dump($_SESSION['userdata']); } 
            if(isset($_SESSION['logstat'])){ echo var_dump($_SESSION['logstat']); } 
            */
        ?>
        
        <script src="../assets/libs/jquery3/jquery-3.4.1.min.js"></script>
        <script src="../assets/libs/popper.js/popper.min.js"></script>
        <script src="../assets/libs/bootstrap41/js/bootstrap.min.js"></script>
        <script src="../assets/libs/jquery-ui/jquery-ui.min.js"></script>
        <script src="../assets/libs/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables/js/dataTables.bootstrap4.min.js"></script>
        <script src="../assets/libs/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
        
        <?php
            if(isset($_SESSION['viewType']) && $_SESSION['viewType'] == 'admin'){
                echo '<script src="../assets/js/admin.js"></script>
        <script src="../assets/libs/sbadmin/js/sb-admin.min.js"></script>';
            } 
            else 
            {
                echo    '<script src="../assets/js/client.js"></script>
        <script src="../assets/js/digiclock.js"></script>
        <script src="../assets/js/plugins.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                    $("#example, #adminlist").DataTable(
                        {
                            "pagingType" : "numbers",
                            "pageLength": 10
                        }
                    );
                    $("#empmlist, #empslist, #wcmlist, #wcslist").DataTable(
                        {
                            "pagingType" : "numbers",
                            "pageLength": 7
                        }
                    );
                    $("#opmlist, #opslist").DataTable(
                        {
                            "pagingType" : "numbers",
                            "pageLength": 5
                        }
                    );

                    // Popovers
                    $("[data-toggle=\'popover\']").popover();

                    // Datepicker                    
                    $("#tsstart, #tsend").datepicker({
                        defaultDate: null,
                        dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true
                    });

                    if($("#in0").length > 0 && $("#navlinks").length > 0){
                        $("#navlinks").hide();
                    } else {
                        $("#navlinks").show();
                    }
                
                /* Geo-mapping
                function getLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else {
                        console.log("Geolocation is not supported by this browser.");
                    }
                }

                function showPosition(position) {
                console.log("Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude); 
                }

                getLocation();
                */

            });
        </script>
        <script src="../assets/libs/pdfmake/pdfmake.min.js"></script>
        <script src="../assets/libs/pdfmake/vfs_fonts.js"></script>
        <script src="../assets/js/reportgen.js"></script>';
            }
        ?>

    </body>
</html>