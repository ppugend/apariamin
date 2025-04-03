<?php
date_default_timezone_set('UTC');
$utc_time = date('Y-m-d H:i:s');

// 한국 시간 (UTC+9)
$local_time = date('Y-m-d H:i:s', time() + 9 * 3600);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTC and Local Time</title>
</head>
<body>
    <h1>UTC and Local Time</h1>

    <label for="time-select">Select Time Zone:</label>
    <select id="time-select">
        <option value="utc">UTC</option>
        <option value="local">Seoul</option>
    </select>

    <div id="time-display">
        <p id="utc-time">UTC Time: <?php echo $utc_time; ?></p>
        <p id="local-time" style="display:none;">Local Time: <?php echo $local_time; ?></p>
    </div>

    <script>
        const timeSelect = document.getElementById('time-select');
        const utcTime = document.getElementById('utc-time');
        const localTime = document.getElementById('local-time');

        timeSelect.addEventListener('change', function () {
            if (this.value === 'utc') {
                utcTime.style.display = 'block';
                localTime.style.display = 'none';
            } else if (this.value === 'local') {
                utcTime.style.display = 'none';
                localTime.style.display = 'block';
            }
        });
    </script>
</body>
</html>
