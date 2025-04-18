document.getElementById('searchInput').addEventListener('input', searchEvents);
document.getElementById('categoryFilter').addEventListener('change', searchEvents);

function searchEvents() {
  const term = document.getElementById('searchInput').value;
  const category = document.getElementById('categoryFilter').value;

  fetch(`search.php?term=${encodeURIComponent(term)}&category=${encodeURIComponent(category)}`)
    .then(response => response.json())
    .then(events => {
      const eventList = document.getElementById('eventList');
      eventList.innerHTML = events.map(event => `
        <div class="event-card">
          <h3>${event.title}</h3>
          <p>Date: ${event.event_date}</p>
          <p>Location: ${event.location}</p>
        </div>
      `).join('');
    });
}