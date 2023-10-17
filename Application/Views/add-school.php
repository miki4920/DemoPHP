<main class="container">
    <div class="jumbotron">
        <h1 class="h3 mb-3 mt-3 font-weight-normal">Please enter school information</h1>
        <form action="/api/school" method="post">
            <div class="form-group">
                <label for="schoolName">School Name</label>
                <input type="text" id="schoolName" name="school_name" class="form-control"
                       placeholder="Enter School Name" required autofocus>
            </div>
            <div class="alert alert-dismissible fade" role="alert" id="messageBox" style="display:none;">
                <span id="messageContent"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Create New</button>
        </form>
    </div>
</main>