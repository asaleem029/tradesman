<?php include 'header.php' ?>

<form action="includes/user.php" method="post" class="form-signin" role="form">
    <input type="hidden" name="action_type" value="RATE_TRADEMAN">

    <h3>Rate Trademan</h3>

    <div class="form-group">
        <input class="form-control" type="number" name="code" placeholder="Enter Code">
    </div>

    <br>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <h3>Rate:</h3>
            </div>

            <div class="col" style="min-width: 295px !important;">
                <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="text">1 star</label>
                </div>
            </div>
        </div>
    </div>

    <br>

    <button class="btn btn-primary" type="submit">Submit</button>
</form>

<?php include 'footer.php' ?>