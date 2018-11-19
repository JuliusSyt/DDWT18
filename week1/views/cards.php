<!-- Series count -->
<?php
include '../model.php';
$total_number_of_series = number_of_series(pdo)
?>


<div class="card">
    <div class="card-header">
        Series
    </div>
    <div class="card-body">
        <p class="count">Series overview already has</p>
        <h2>$total_number_of_series</h2>
        <p>series listed</p>
        <a href="/DDWT18/week1/add/" class="btn btn-primary">List yours</a>
    </div>
</div>