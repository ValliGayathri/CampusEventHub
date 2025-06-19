document.addEventListener('DOMContentLoaded', function() {
    setMinDateForDateInput();

    const postEventBtn = document.getElementById('postEventBtn');
    const viewEventsBtn = document.getElementById('viewEventsBtn');

    postEventBtn.addEventListener('click', function() {
        document.getElementById('eventFormContainer').classList.remove('hidden');
        document.getElementById('eventListContainer').classList.add('hidden');
    });

    viewEventsBtn.addEventListener('click', function() {
        document.getElementById('eventFormContainer').classList.add('hidden');
        document.getElementById('eventListContainer').classList.remove('hidden');
        fetchClubEvents();
    });

    function fetchClubEvents() {
        fetch('retrieve_club.php')
            .then(response => response.json())
            .then(events => {
                const eventList = document.getElementById('eventList');
                eventList.innerHTML = '';

                const today = new Date().toISOString().split('T')[0];
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
                        <p><strong>Time:</strong> ${event.eventTime}</p>
                        <p><strong>Venue:</strong> ${event.eventVenue}</p>
                        <p><strong>Description:</strong> ${event.eventDescription}</p>
                        ${event.googleFormLink ? `<p><a href="${event.googleFormLink}" target="_blank">Google Form</a></p>` : ''}
                        <button class="delete-btn" data-event-name="${event.eventName}">Delete</button>
                    `;
                    eventList.appendChild(eventElement);
                });

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const eventName = this.getAttribute('data-event-name');
                        if (confirm('Are you sure you want to delete this event?')) {
                            deleteEvent(eventName);
                        }
                    });
                });
            })
            .catch(error => console.error('Error fetching club events:', error));
    }

    function deleteEvent(eventName) {
        fetch('delete_clubevent.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                eventName: eventName
            })
        })
        .then(response => response.text())
        .then(message => {
            alert(message);
            fetchClubEvents(); 
        })
        .catch(error => console.error('Error deleting event:', error));
    }

    function setMinDateForDateInput() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const minDate = `${year}-${month}-${day}`;
        document.getElementById('eventDate').setAttribute('min', minDate);
    }
});
