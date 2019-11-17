<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">Search books</title>
        <script type="text/javascript">
            // Get all subjects on load
            $.ajax({
                type: "get",
                url: "cgi-bin/listbooks.cgi",
                success: function(data){
                    $(function(){
                        $('#table-body').append(data);
                    });
                },
                error: function(data){
                    $(function(){
                        $('#table-body').append(data);
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
        <div id="alert"></div>
        <form id="form">
            <table class="table table-striped table-dark col-sm-6 offset-sm-3" style="margin-top: 2%;">
                <thead>
                    <tr>
                        <th scope="col">Select</th>
                        <th scope="col">Book</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    
                </tbody>
            </table>
            <button id="update" type="submit" class="col-sm-2 offset-sm-3 btn btn-dark">Update</button>
            <button id="delete" type="submit" class="col-sm-2 offset-sm-2 btn btn-dark">Delete</button>
        </form>
        <p id="success" style="color: green;"></p>
        <p id="error" style="color: red;"></p>
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
            $('#update').click(function(e){
                e.preventDefault();
                let isbn = [];
                let price = [];
                $("input:checkbox:checked").each(function(){
                    isbn.push($(this).val());
                    price.push($(this).parents('tr').find('#price').val());
                });

                let json = "";
                for(let i = 0; i < isbn.length; i++){
                    json = json + isbn[i] + "=" + price[i] + "&";
                }
                // Remove last &
                json = json.substring(0, json.length - 1);

                $.ajax({
                type: "get",
                url: "cgi-bin/updateprice.cgi",
                data: json,
                success: function(data){
                    $('#alert').empty();
                    $('#alert').append('<div class="alert alert-success" class="col-sm-8 offset-sm-2" role="alert">Successfully updated price in the database!</div>');
                },
                error: function(data){
                    $('#alert').empty();
                    $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Error when attempting to update price in the database!</div>');
                }
                });
            });
            $('#delete').click(function(e){
                e.preventDefault();
                let isbn = [];
                $("input:checkbox:checked").each(function(){
                    isbn.push($(this).val());
                });
                let json = "";
                for(let i = 0; i < isbn.length; i++){
                    json = json + "isbn=" + isbn[i] + "&";
                }
                // Remove last &
                json = json.substring(0, json.length - 1);

                $.ajax({
                type: "get",
                url: "cgi-bin/delete.cgi",
                data: json,
                success: function(data){
                    $('#alert').empty();
                    $('#alert').append('<div class="alert alert-success" class="col-sm-8 offset-sm-2" role="alert">Successfully delete from the database!</div>');
                },
                error: function(data){
                    $('#alert').empty();
                    $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Error when attempting to delete from the database!</div>');
                }
                });
            });
        </script>
    </body>
</html>