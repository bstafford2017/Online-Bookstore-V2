<!doctype html>
    <head>
        <?php 
            include 'required.php';
        ?>
        <title id="title">Create</title>
    </head>
    <body>
        <?php
            include 'navbar.php';
        ?>
        
        <div id="header"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm" style="text-align: center;">
                    <h2 id="create-title" style="padding:10px;">Create a book submission</h2>
                </div>
            </div>
        </div>
        <div id="alert"></div>
        <form class="col-sm-4 offset-sm-4">
            <div class="form-group" >
                <label>Book Title</label>
                <input id="book-title" name="book-title" type="text" class="form-control" placeholder="i.e. Web Programming" required/>
                <p id="title-error" class="form-text text-muted" style="color: red;"></p>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input id="price" name="price" type="text" class="form-control" placeholder="i.e. 12.99" required/>
                <p id="price-error" class="form-text text-muted" style="color: red;"></p>
            </div>
            <div class="form-group">
                <label>ISBN</label>
                <input id="isbn" name="isbn" type="text" class="form-control" placeholder="i.e. 0123456789" required/>
                <p id="isbn-error" class="form-text text-muted" style="color: red;"></p>
            </div>
            <div class="form-group">
                <label>Subjects</label>
                <input id="subjects" name="subjects" type="text" class="form-control" placeholder="i.e. Engineering" required/>
                <p id="subjects-error" class="form-text text-muted" style="color: red;"></p>
            </div>
            <button id="submit" type="submit" class="col-sm-2 offset-sm-5 btn btn-dark">Create</button>
        </form>
        <p id="success" style="color: green;"></p>
        <p id="error" style="color: red;"></p>
        <p><a id="source" href="#">View Source</a></p>
        <div id="display-source"></div>
        <?php
            include 'footer.php';
        ?>
        <script>
            $('#source').click(function(e){
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "cgi-bin/source.cgi",
                    data: {filename: "create"},
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
            $('#submit').click(function(e){
                //e.preventDefault();
                let isbn = $('#submit').parents('form').find('#isbn').val();
                let title = $('#submit').parents('form').find('#book-title').val();
                let price = $('#submit').parents('form').find('#price').val();
                let subjects = $('#submit').parents('form').find('#subjects').val();
                title = title.replace(/ /g, "-");
                //subjects = subjects.replace(" ", "-");
                let json = "isbn=" + isbn + "&title=" + title + "&price=" + price + "&subjects=" + subjects;
                $.ajax({
                    type: "get",
                    url: "cgi-bin/create.cgi",
                    data: json,
                    success: function(data){
                        $('#alert').empty();
                        $('#alert').append('<div class="alert alert-success" class="col-sm-8 offset-sm-2" role="alert">Successfully created book!</div>');                    
                    },
                    error: function(data){
                        $('#alert').empty();
                        $('#alert').append('<div class="alert alert-danger" class="col-sm-8 offset-sm-2" role="alert">Error when attempting to create book!</div>');                   
                    }
                });
            });
        </script>
    </body>
</html>