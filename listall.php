<?php
    session_start();
    echo $_SESSION['username'];
    if(isset($_SESSION['username'])){
        echo $_SESSION['username'];
    } else {
        header("Location: login.php");
    }
?>
<!doctype html>
    <head>
        <?php
            include 'required.php';
        ?>
        <title id="title">Home</title>
        <script type="text/javascript">
            $.ajax({
                type: "get",
                url: "cgi-bin/search.cgi",
                success: function(data){
                    $('#book-table-body').empty();                
                    $('#book-table-body').append(data);
                },
                error: function(data){
                    $('#book-table-body').empty();    
                    $('#book-table-body').append(data);
                }
            });
            $.ajax({
                type: "get",
                url: "cgi-bin/listcustomers.cgi",
                data: {
                    username: "<?php echo $_SESSION['username']; ?>"
                },
                success: function(data){
                    $('#customer-table-body').empty();                
                    $('#customer-table-body').append(data);
                },
                error: function(data){
                    $('#customer-table-body').empty();    
                    $('#customer-table-body').append(data);
                }
            });
        </script>
    </head>
    <body>
        <?php
            include 'navbar.php';
        ?>
        <h2 style="text-align:center;">Welcome to the bookstore!</h2>

        <table class="table table-striped table-dark col-sm-6 offset-sm-4" style="margin-top: 2%;">
            <thead>
                <tr>
                    <th scope="col">ISBN</th>
                    <th scope="col">Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Subject(s)</th>
                </tr>
            </thead>
            <tbody id="book-table-body">
                
            </tbody>
        </table>

        <table class="table table-striped table-dark col-sm-6 offset-sm-4" style="margin-top: 2%;">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Admin</th>
                    <th scope="col">Purchases</th>
                </tr>
            </thead>
            <tbody id="customer-table-body">
                
            </tbody>
        </table>
        
        <div id="display-source"></div>
        <?php
            include 'footer.php';
        ?>
        <script>
            $('#source').click(function(e){
                e.preventDefault();
                let pass = $('#pass').val();
                $.ajax({
                    type: "get",
                    url: "cgi-bin/source.cgi",
                    data: {filename: "index", password: pass},
                    success: function(data){
                        if(data){
                            $('body').empty();    
                            $('body').append("<pre>" + data + "</pre>");
                        } else {
                            $('#alert').empty();
                            $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Login error when displaying source!</div>');                   
                        }
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
