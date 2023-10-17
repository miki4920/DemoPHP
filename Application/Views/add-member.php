<main class="container">
    <div class="jumbotron">
        <h1 class="h3 mb-3 mt-3 font-weight-normal">Please enter member information</h1>
        <form action="/api/member" method="post">
            <div class="form-group">
                <label for="memberName">Member Name</label>
                <input type="text" id="memberName" name="member_name" class="form-control"
                       placeholder="Enter School Name" required autofocus>
                <label for="memberEmail">Member Email</label>
                <input type="text" id="memberEmail" name="member_email" class="form-control"
                       placeholder="Enter Member Email" required autofocus>
                <label for="schoolSelect">Member School(s)</label>
                <select class="selectpicker form-control" multiple data-live-search="true" id="schoolSelect" name="schools[]">
                    <?php if (!empty($schools)) {
                        foreach ($schools as $school): ?>
                            <option value="<?php echo htmlspecialchars($school['id']); ?>">
                                <?php echo htmlspecialchars($school['school_name']); ?>
                            </option>
                        <?php endforeach;
                    } ?>
                </select>
            </div>
            <div class="alert alert-dismissible fade" role="alert" id="messageBox" style="display:none;">
                <span id="messageContent"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Create New</button>
        </form>
    </div>
</main>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>