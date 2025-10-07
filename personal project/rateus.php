<?php
/* Template Name: Rate Us */
get_header();
?>
<main>
    <div class="card">
        <h1>Rate Us</h1>
        <p>We value your feedback! Please rate your experience with our Personal Finance Tracker below:</p>
        <form>
            <label for="rating">Your Rating:</label>
            <select id="rating" name="rating">
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Very Poor</option>
            </select>
            <br><br>
            <label for="comments">Comments:</label><br>
            <textarea id="comments" name="comments" rows="4" cols="40"></textarea>
            <br><br>
            <button type="submit">Submit</button>
        </form>
    </div>
</main>
<?php
get_footer();
?>