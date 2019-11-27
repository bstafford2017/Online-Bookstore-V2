<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">Sign Up</title>
    </head>
    <body>
        <?php
            include 'navbar.php';
        ?>
        <!-- Content-->
        <div id="alert"></div>
        <form id="form">
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
            <button id="signup" type="submit" class="btn btn-primary">Sign Up</button>
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
                    data: {filename: "signup"},
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
            $('#signup').click(function(e){
                e.preventDefault();
                let name = $('#name');
                let username = $('#username');
                let password = $('#password');
                let admin = $('#admin');
                $.ajax({
                    type: "post",
                    url: "cgi-bin/login.cgi",
                    data: {"name": name, "username": username, "password": password, "admin": admin},
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