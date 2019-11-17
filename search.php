<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">Search books</title>

    </head>
    <body>
        <?php
            include 'navbar.php';
        ?>
        <!-- Content-->
        <div class="container">
            <div class="row">
                <div class="col-sm" style="text-align: center;">
                    <h2 id="search-title" style="padding:10px;">Search for a book</h2>
                </div>
            </div>
        </div>
        <div id="alert"></div>
        <form id="form">
            <div id="subject" class="col-sm-8 offset-sm-2 bg-dark text-white" style="margin-bottom: 2%;"><h3 style="text-align:center;">Subjects:</h3></div>
            <small id="search-error" class="form-text text-muted" style="color: red;"></small>
            <input id="search-input" type="text" placeholder="Search . . . "/>
            <button id="clear" type="submit" class="col-sm-2 offset-sm-3 btn btn-dark">Clear all</button>
            <button id="search" type="submit" class="col-sm-2 offset-sm-2 btn btn-dark">Search</button>
            <button id="purchase" type="submit" class="col-sm-2 offset-sm-2 btn btn-dark">Purchase</button>
            <table class="table table-striped table-dark col-sm-6 offset-sm-3" style="margin-top: 2%;">
                <thead>
                    <tr>
                        <th scope="col">Select</th>
                        <th scope="col">Matches</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Title</th>
                        <th scope="col">Price</th>
                        <th scope="col">Subject(s)</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    
                </tbody>
            </table>
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
                    data: {filename: "search"},
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
            
            $("#search").click(function(e){
                e.preventDefault();
                let search = $('#search-input');
                $.ajax({
                    type: "get",
                    url: "cgi-bin/search.cgi",
                    data: {"search": search},
                    success: function(data){
                        $('#table-body').empty();                
                        $('#table-body').append(data);
                    },
                    error: function(data){
                        $('#table-body').empty();    
                        $('#table-body').append(data);
                    }
                });
            });

            $("#purchase").click(function(e){
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "cgi-bin/purchase.cgi",
                    data: {"isbn": isbn},
                    success: function(data){
                        $('#alert').empty();
                        $('#alert').append('<div class="alert alert-success" class="col-sm-8 offset-sm-2" role="alert">Successfully purchases books</div>');
                    },
                    error: function(data){
                        $('#alert').empty();
                        $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Error when attempting to purchase books!</div>');
                    }
                });
            });

            $('#clear').click(function(e){
                e.preventDefault();
                var url = "cgi-bin/clear.cgi";
                console.log(url);
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data){
                        $('#alert').empty();
                        $('#alert').append('<div class="alert alert-success" class="col-sm-8 offset-sm-2" role="alert">Successfully cleared the database!</div>');
                    },
                    error: function(data){
                        $('#alert').empty();
                        $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Error when attempting to clear the database!</div>');
                    }
                });
            });
        </script>
    </body>
</html>