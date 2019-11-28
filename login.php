<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">Login</title>
    </head>
    <body>
        <!-- Content-->
        <h2 style="text-align:center;">Login Page</h2>
        <div id="alert"></div>
        <form id="form" class="offset-sm-4 col-sm-4">
            <div class="form-group">
                <label>Username</label>
                <input id="username" type="text" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input id="password" type="password" class="form-control" placeholder="Enter password" required>
                <small id="hint" class="form-text text-muted">Never let anyone else know your password.</small>
            </div>
            <button id="login" type="submit" class="btn btn-primary btn-dark offset-sm-2">Login</button>
            <button id="signup" type="submit" class="btn btn-primary btn-dark offset-sm-2" onclick="window.location='signup.php';">Sign Up</button>
        </form>
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
            $('#login').click(function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "cgi-bin/login.cgi",
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    success: function(data){
                        if(data.includes("Error")){
                            $('#alert').empty();
                            $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Incorrect username/password</div>');
                        } else {
                            $.ajax({
                                type: "post",
                                contentType: "application/json", 
                                url: "utils/session.php",
                                data: JSON.stringify({
                                    username: $('#username').val(),
                                })
                            }).done(function(data){
                                alert("success session");
                                window.location.replace("http://undcemcs02.und.edu/~benjamin.stafford/index.php");
                            }).fail(function(data){
                                alert("failed session");
                            });
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