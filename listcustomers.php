<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">List Customers</title>
        <script type="text/javascript">
            $.ajax({
                type: "get",
                url: "cgi-bin/listcustomers.cgi",
                success: function(data){
                    $('#results').empty();    
                    $('#results').append(data);
                },
                error: function(data){
                    $('#alert').empty();
                    $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Error when attempting to list customers!</div>');
                }
            });
        </script>
    </head>
    <body>
        <?php
            include 'navbar.php';
        ?>
        <!-- Content-->
        <div id="alert"></div>
        <div id="results"></div>
        <p><a id="source" href="#">View Source</a></p>
        <div id="display-source"></div>
        <?php
            include 'footer.php';
        ?>
        <script type="text/javascript">
            $('#source').click(function(e){
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "cgi-bin/source.cgi",
                    data: {filename: "listbooks"},
                    success: function(data){
                        $('body').empty();    
                        $('body').append("<pre>" + data + "</pre>");
                    },
                    error: function(data){
                        $('body').empty();    
                        $('body').append("<pre>" + data + "</pre>");
                    }
                });
            });
        </script>
    </body>
</html>