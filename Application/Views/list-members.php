<main class="container">
    <div class="jumbotron">
        <h1 class="h3 mb-3 mt-3 font-weight-normal">Search Members by School</h1>
        <form method="get" action="/api/member" id="searchForm">
            <div class="form-group">
                <label for="schoolSelect">Select School:</label>
                <select class="form-control" id="schoolSelect" name="school_id" required>
                    <option value="">--Select a school--</option>
                    <?php if (!empty($schools)) {
                        foreach ($schools as $school): ?>
                            <option value="<?php echo htmlspecialchars($school['id']); ?>">
                                <?php echo htmlspecialchars($school['school_name']); ?>
                            </option>
                        <?php endforeach;
                    } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div id="results">

        </div>
    </div>
</main>
