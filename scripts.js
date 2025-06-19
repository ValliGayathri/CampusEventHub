document.getElementById('upcomingEventsBtn').addEventListener('click', function() {
    document.getElementById('eventList').classList.remove('hidden');
    fetchEvents('upcoming');
});

document.getElementById('pastEventsBtn').addEventListener('click', function() {
    document.getElementById('eventList').classList.remove('hidden');
    fetchEvents('past');
});

function fetchEvents(type) {
    fetch(`retrieve_student.php?type=${type}`)
        .then(response => response.json())
        .then(events => {
            const eventList = document.getElementById('eventList');
            eventList.innerHTML = '';
            events.forEach(event => {
                const eventElement = document.createElement('div');
                eventElement.innerHTML = `
                    <h3>${event.eventName}</h3>
                    <p><strong>Date:</strong> ${event.eventDate}</p>
                    <p>Description: ${event.eventDescription}</p>
                    ${type === 'upcoming' && event.googleFormLink ? `<p><a href="${event.googleFormLink}" target="_blank">Register Here</a></p>` : ''}
                    <hr>
                `;
                eventList.appendChild(eventElement);
            });
        });
}
