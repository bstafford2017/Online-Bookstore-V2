<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">Login</title>
    </head>
    <body>
        <?php
            include 'navbar.php';
        ?>
        <!-- Content-->
        <div id="alert"></div>
        <form id="form">
            <div class="form-group">
                <label>Username</label>
                <input id="username" type="text" class="form-control" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input id="password" type="password" class="form-control" placeholder="Password">
                <small id="hint" class="form-text text-muted">Never let anyone else know your password.</small>
            </div>
            <button id="login" type="submit" class="btn btn-primary">Login</button>
        </form>
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
            $('#login').click(function(e){
                e.preventDefault();
                let username = $('#username');
                let password = $('#password');
                $.ajax({
                    type: "post",
                    url: "cgi-bin/login.cgi",
                    data: {"username": username,"password": password}
                    success: function(data){
                        if(data.stringify().contains("Error")){
                            $('#alert').empty();
                            $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Incorrect username/password</div>');
                        } else {
                            window.location.replace("../index.php");
                        }
                    },
                    error: function(data){
                        $('#alert').empty();
                        $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">System Error!</div>');
                    }
                });
            });
        </script>
    </body>
</html>