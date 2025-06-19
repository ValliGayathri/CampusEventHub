<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login_faculty.php');
    exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Event Posting</title>
    <style>
        /* Your existing styles */
        body {
            background-color: #f2f7f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('bgimg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .header {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #2e7383;
            margin-bottom: 0;
        }
        .header h1 {
            font-size: 3em;
            margin: 0;
        }
        .nav-container {
            display: flex;
            justify-content: center;
            padding: 40px 0;
            font-size: larger;
            width: 100%;
        }
        .nav-container a, .nav-container button {
            color: #2e7383;
            text-decoration: none;
            padding: 10px;
            margin: 0 5px;
            box-shadow: 0 4px 8px rgb(26, 132, 146);
            background: none;
            border: none;
            cursor: pointer;
            font-size: larger;
        }
        .nav-container a:hover, .nav-container button:hover {
            background-color: #b7f1ec;
        }
        .nav-button{
            width: 250px;
            height: 50px;
            border-radius: 0px;
        }
        .container {
            width: 500px;
            padding: 30px;
            text-align: center;
            margin: 0 auto;
            margin-top: 20px;
            color: white;
            background-color: rgba(29, 112, 102, 0.3);
            transition: box-shadow 0.3s ease;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgb(26, 132, 146);
        }
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }
        button {
            background-color: rgb(26, 132, 146);
            width: 100%;
            border: none;
            padding: 10px;
            border-radius: 5px;
            height: 40px;
            color: white;
            font-size: larger;
            cursor: pointer;
            margin: 10px 0;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        button:hover {
            background-color: rgba(26, 244, 219, 0.441);
            box-shadow: 0 0 10px rgba(29, 112, 102, 0.441);
        }
        .hidden {
            display: none;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: larger;
            color: white;
        }
        input[type="text"], input[type="date"], input[type="password"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .event-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .event {
            width: 100%;
            background-color: rgba(29, 112, 102, 0.3);
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
        }
        .event h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: white;
        }
        .event p {
            font-size: 1em;
            margin-bottom: 5px;
            color: white;
        }
        .event a {
            color: #1f3f3d;
            text-decoration: none;
        }
        .event a:hover {
            text-decoration: underline;
        }
        .event.past-event {
            background-color: rgba(236, 100, 92, 0.3);
        }
        .event.upcoming-event {
            background-color: rgba(144, 238, 144, 0.3);
        }
        .delete-btn {
            background-color: #2e7383;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #f2f7f5;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>CAMPUS EVENT HUB</h1>
    <div class="nav-container">
        <a href="Homepage.html">Home</a>
        <a href="clubevent.html">Club Events</a>
        <a href="clgevents.html">College Events</a>
        <button id="changePasswordBtn" class="nav-button">Change Password</button>
        <a href="login.html">Logout</a>
    </div>
</div>
<div class="container">
    <div class="button-container">
        <button id="postEventBtn">Post an Event</button>
        <button id="viewEventsBtn">View My Events</button>
    </div>

    <div id="eventFormContainer" class="hidden">
            <h1>Post an Event</h1>
            <form id="eventForm">
                <input type="hidden" id="username1" name="username" value="<?php echo $username; ?>">
                <input type="hidden" id="club1" name="club" value="<?php echo $club; ?>">
                <div class="form-group">
                    <label for="eventName">Event Name</label>
                    <input type="text" id="eventName" name="eventName" required>
                </div>
                <div class="form-group">
                    <label for="eventDate">Event Date</label>
                    <input type="date" id="eventDate" name="eventDate" required>
                </div>
                <div class="form-group">
                    <label for="eventTime">Event Time</label>
                    <input type="time" id="eventTime" name="eventTime" required>
                </div>
                <div class="form-group">
                    <label for="eventVenue">Event Venue</label>
                    <input type="text" id="eventVenue" name="eventVenue" required>
                </div>
                <div class="form-group">
                    <label for="eventDescription">Event Description</label>
                    <textarea id="eventDescription" name="eventDescription" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="googleFormLink">Google Form Link (Optional)</label>
                    <input type="text" id="googleFormLink" name="googleFormLink">
                </div>
                <button type="submit">Post Event</button>
            </form>
        </div>

    <div id="changePasswordFormContainer" class="hidden">
        <h1>Change Password</h1>
        <form id="changePasswordForm">
            <input type="hidden" id="username" name="username" value="<?php echo $username; ?>">
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input type="password" id="currentPassword" name="currentPassword" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit">Change Password</button>
        </form>
    </div>

    <div id="eventListContainer" class="hidden">
        <h2>My Events</h2>
        <div class="event-container" id="eventList"></div>
    </div>
</div>

<script>
    document.getElementById('postEventBtn').addEventListener('click', function() {
        document.getElementById('eventFormContainer').classList.toggle('hidden');
        document.getElementById('eventListContainer').classList.add('hidden');
        document.getElementById('changePasswordFormContainer').classList.add('hidden');
    });

    document.getElementById('viewEventsBtn').addEventListener('click', function() {
        fetch('retrieve_club.php')
            .then(response => response.json())
            .then(events => {
                const eventList = document.getElementById('eventList');
                eventList.innerHTML = '';

                const today = new Date().toISOString().split('T')[0];
                events.sort((a, b) => new Date(b.eventDate) - new Date(a.eventDate));

                events.forEach(event => {
                    const eventElement = document.createElement('div');
                    eventElement.classList.add('event');
                    if (event.eventDate < today) {
                        eventElement.classList.add('past-event');
                    } else {
                        eventElement.classList.add('upcoming-event');
                    }
                    eventElement.innerHTML = `
                        <h3>${event.eventName}</h3>
                        <p><strong>Date:</strong> ${event.eventDate}</p>
                        <p><strong>Description:</strong> ${event.eventDescription}</p>
                        ${event.googleFormLink ? `<p><a href="${event.googleFormLink}" target="_blank">Google Form</a></p>` : ''}
                        <button class="delete-btn" data-id="${event.id}">Delete</button>
                    `;
                    eventList.appendChild(eventElement);
                });

                document.getElementById('eventFormContainer').classList.add('hidden');
                document.getElementById('eventListContainer').classList.remove('hidden');
                document.getElementById('changePasswordFormContainer').classList.add('hidden');
            })
            .catch(error => console.error('Error fetching events:', error));
    });

    document.getElementById('eventList').addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-btn')) {
            const eventId = event.target.getAttribute('data-id');
            const confirmation = confirm('Are you sure you want to delete this event?');

            if (confirmation) {
                fetch('delete_clubevent.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: eventId })
                })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                    document.getElementById('viewEventsBtn').click();
                })
                .catch(error => console.error('Error deleting event:', error));
            }
        }
    });

    function setMinDateForDateInput() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const minDate = `${year}-${month}-${day}`;
        document.getElementById('eventDate').setAttribute('min', minDate);
    }

    document.getElementById('changePasswordBtn').addEventListener('click', function() {
        document.getElementById('changePasswordFormContainer').classList.toggle('hidden');
        document.getElementById('eventFormContainer').classList.add('hidden');
        document.getElementById('eventListContainer').classList.add('hidden');
    });

    document.addEventListener('DOMContentLoaded', function() {
        setMinDateForDateInput();

        document.getElementById('eventForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            fetch('clubpost_event.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result);
                document.getElementById('eventForm').reset();
            })
            .catch(error => console.error('Error posting event:', error));
        });

        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            fetch('change_password2.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result);
                document.getElementById('changePasswordForm').reset();
                document.getElementById('changePasswordFormContainer').classList.add('hidden');
            })
            .catch(error => console.error('Error changing password:', error));
        });
    });
</script>

</body>
</html>
