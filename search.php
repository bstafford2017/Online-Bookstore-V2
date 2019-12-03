<?php
    session_start();
    if(isset($_SESSION['username'])){

    } else {
        header("Location: login.php");
    }
?>
<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">Search books</title>
        <script type="text/javascript">
            $.ajax({
                type: "get",
                url: "cgi-bin/subject.cgi",
                success: function(data){
                    $(function(){
                        $('#subject').append(data);
                    });
                },
                error: function(data){
                    $(function(){
                        $('#subject').append(data);
                    });
                }
            });
        </script>
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
            <div class="row">
                <input id="search-input" type="text" class="col-sm-8 offset-sm-2" placeholder="Search by subjects . . . "/>
            </div>
            <div class="row" style="margin-top: 2%;">
                <button id="clear" type="submit" class="col-sm-2 offset-sm-2 btn btn-dark">Clear all</button>
                <button id="search" type="submit" class="col-sm-2 offset-sm-1 btn btn-dark">Search</button>
                <button id="purchase" type="submit" class="col-sm-2 offset-sm-1 btn btn-dark">Purchase</button>
            </div>
            <div class="row">
                <table id="table" class="table table-striped table-dark col-sm-6 offset-sm-3" style="margin-top: 2%;">
                    <thead>
                        <tr>
                            <th scope="col">Select</th>
                            <th scope="col">Matches</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Title</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subject(s)</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        
                    </tbody>
                </table>
            </div>
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
                    data: {filename: "search", password: pass},
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
            
            $("#search").click(function(e){
                e.preventDefault();

                let search = "";
                if($('#search-input').val()){
                    search = $('#search-input').val() + "+";
                }

                $("input:checkbox:checked").each(function(){
                    search = search + $(this).val() + "+";
                });

                search = search.substring(0, search.length - 1);
                
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
                let isbn = [];
                $('#table').find('input:checkbox:checked').each(function(){
                    let quantity = $(this).parents('tr').find('#quantity').val();
                    let i;
                    for(i = 0; i < quantity; i++){
                        isbn.push($(this).val());
                    }
                });
                let json = "isbn=<?php echo $_SESSION['username'];?>";
                for(let i = 0; i < isbn.length; i++){
                    json = json + "+" + isbn[i];
                }
                console.log(json);
                $.ajax({
                    type: "get",
                    url: "cgi-bin/purchase.cgi",
                    data: json,
                    success: function(data){
                        $('#alert').empty();
                        $('#alert').append('<div class="alert alert-success" class="col-sm-8 offset-sm-2" role="alert">Successfully purchases books!</div>');
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