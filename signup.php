<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">Sign Up</title>
    </head>
    <body>
        <!-- Content-->
        <h2 style="text-align:center;">Sign Up Page</h2>
        <div id="alert"></div>
        <form id="form" class="offset-sm-4 col-sm-4">
            <div class="form-group">
                <label>Name</label>
                <input id="name" type="text" class="form-control" placeholder="Enter name" required/>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input id="username" type="text" class="form-control" placeholder="Enter username" required/>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input id="password" type="password" class="form-control" placeholder="Enter password" required/>
                <small id="hint" class="form-text text-muted">Never let anyone else know your password.</small>
            </div>
            <div class="form-group">
                <label>Administrator</label>
                <select id="admin" class="custom-select">
                    <option value="volvo">Yes</option>
                    <option value="saab">No</option>
                </select>
            </div>
            <button id="signup" type="submit" class="btn btn-primary btn-dark offset-sm-4 col-sm-4">Sign Up</button>
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
            $('#signup').click(function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "cgi-bin/signup.cgi",
                    data: {
                        "name": $('#name').val(),
                        "username": $('#username').val(),
                        "password": $('#password').val(),
                        "admin": $('#admin').val()
                    },
                    success: function(data){
                        location.replace("login.php");
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