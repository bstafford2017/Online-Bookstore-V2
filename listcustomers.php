<?php
    session_start();
    echo $_SESSION['username'];
    if(isset($_SESSION['username'])){
        echo $_SESSION['username'];
    } else {
        header("Location: login.php";
    }
?>
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
                    $('#table-body').empty();    
                    $('#table-body').append(data);
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
        <table class="table table-striped table-dark col-sm-6 offset-sm-3" style="margin-top: 2%;">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Purchases</th>
                </tr>
            </thead>
            <tbody id="table-body">
                
            </tbody>
        </table>
        <form class="col-sm-4 offset-sm-4">
            <label>Source Password:</label>
            <input id="pass" type="password" class="form-control" style="display: inline" required/>
            <button id="source" type="submit" class="col-sm-2 offset-sm-5 btn btn-dark">Display</button>
        </form>
        <div id="display-source"></div>
        <?php
            include 'footer.php';
        ?>
        <script type="text/javascript">
            $('#source').click(function(e){
                e.preventDefault();
                let pass = $('#pass').val();
                $.ajax({
                    type: "get",
                    url: "cgi-bin/source.cgi",
                    data: {filename: "create", password: pass},
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