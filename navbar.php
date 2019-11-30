<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-left: 10%;margin-right: 10%;">
    <a class="navbar-brand" href="index.php">My Bookstore</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a id="home" class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a id="create" class="nav-link" href="create.php">Create</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="search.php">Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listbooks.php">List Books</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listcustomers.php">List Customers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listall.php">List All</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a id="signout" class="nav-link" href="#">Sign Out</a>
            </li>
        </ul>
    </div>
</nav>

<script type="text/javascript">
    $('#signout').click(function(e){
        e.preventDefault();
        $.ajax({
            type: "get",
            contentType: "application/json",
            url: "utils/destroy.php",
            success: function(){
                console.log("Successfully destroyed session!");
                window.location.replace("login.php");
            },
            error: function(){
                console.log("Error in destroying session!");
            }
        });
    });
</script>