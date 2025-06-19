document.addEventListener('DOMContentLoaded', function() {
    setMinDateForDateInput();

    const viewClubEventsLink = document.getElementById('viewClubEventsLink');
    const viewCollegeEventsLink = document.getElementById('viewCollegeEventsLink');
    const postEventBtn = document.getElementById('postEventBtn');
    const viewEventsBtn = document.getElementById('viewEventsBtn');

    viewClubEventsLink.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('eventFormContainer').classList.add('hidden');
        document.getElementById('eventListContainer').classList.add('hidden');
        document.getElementById('allEventListContainer').classList.remove('hidden');
        document.getElementById('collegeEventListContainer').classList.add('hidden');
    });

    viewCollegeEventsLink.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('eventFormContainer').classList.add('hidden');
        document.getElementById('eventListContainer').classList.add('hidden');
        document.getElementById('allEventListContainer').classList.add('hidden');
        document.getElementById('collegeEventListContainer').classList.remove('hidden');
    });

    postEventBtn.addEventListener('click', function() {
        document.getElementById('eventFormContainer').classList.remove('hidden');
        document.getElementById('eventListContainer').classList.add('hidden');
        document.getElementById('allEventListContainer').classList.add('hidden');
        document.getElementById('collegeEventListContainer').classList.add('hidden');
    });

    viewEventsBtn.addEventListener('click', function() {
        document.getElementById('eventFormContainer').classList.add('hidden');
        document.getElementById('eventListContainer').classList.remove('hidden');
        document.getElementById('allEventListContainer').classList.add('hidden');
        document.getElementById('collegeEventListContainer').classList.add('hidden');
        fetchCoordinatorEvents();
    });

    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        postEvent();
    });
});

function setMinDateForDateInput() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('eventDate').setAttribute('min', today);
}

function postEvent() {
    const form = document.getElementById('eventForm');
    const formData = new FormData(form);

    fetch('post_event.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
        form.reset();
        document.getElementById('eventFormContainer').classList.add('hidden');
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function fetchCoordinatorEvents() {
    const username = document.getElementById('username').value;
    fetch(`retrieve_events.php?username=${username}`)
    .then(response => response.json())
    .then(events => {
        const eventList = document.getElementById('eventList');
        eventList.innerHTML = '';
        events.forEach(event => {
            const eventElement = createEventElement(event);
            eventList.appendChild(eventElement);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function createEventElement(event) {
    const eventElement = document.createElement('div');
    eventElement.classList.add('event');
    eventElement.innerHTML = `
        <h3>${event.eventName}</h3>
        <p>Date: ${event.eventDate}</p>
        <p>${event.eventDescription}</p>
        <a href="${event.googleFormLink}" target="_blank">Google Form Link</a>
    `;
    return eventElement;
}
