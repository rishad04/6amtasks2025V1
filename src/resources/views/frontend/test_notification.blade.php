<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simulated Real-time Notifications</title>
</head>

<body>
    <h1>Real-time Notifications (Simulated)</h1>
    <div id="notifications"></div>

    <script>
        let lastMessage = '';

        function checkForNotification() {
            fetch('/get-latest-notification')
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    if (data.message && data.message !== lastMessage) {
                        const box = document.getElementById('notifications');
                        box.innerHTML = `<p>${data.message}</p>` + box.innerHTML;
                        lastMessage = data.message;
                    }
                });
        }

        // Check every 3 seconds
        setInterval(checkForNotification, 3000);

        // First check on load
        checkForNotification();
    </script>
</body>

</html>
