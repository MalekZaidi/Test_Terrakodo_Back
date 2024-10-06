@extends('backoffice.back')

@section('content')
<div class="container mt-5">
    <h1>Calendrier des Événements</h1>
    <div id="calendar"></div>
</div>

<!-- Modal pour afficher les détails de l'événement -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventTitle">Détails de l'Événement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-6">
            <label for="eventName" class="form-label">Nom de l'Événement</label>
            <input type="text" id="eventName" class="form-control" disabled />
          </div>
        </div>
        <div class="row g-6">
          <div class="col mb-0">
            <label for="eventDate" class="form-label">Date</label>
            <input type="text" id="eventDate" class="form-control" disabled />
          </div>
          <div class="col mb-0">
            <label for="eventDescription" class="form-label">Description</label>
            <textarea id="eventDescription" class="form-control" rows="3" disabled></textarea>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col mb-0">
            <label for="eventAddress" class="form-label">Adresse</label>
            <input type="text" id="eventAddress" class="form-control" disabled />
          </div>
        </div>

        <!-- Section pour Google Maps -->
        <div class="row mt-3">
          <div class="col mb-0">
            <label class="form-label">Localisation sur Google Maps</label>
            <iframe id="googleMapFrame" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Fermer
        </button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($evenements),
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventClick: function(info) {
                // Afficher le modal et les détails de l'événement
                document.getElementById('eventTitle').innerText = info.event.title;
                document.getElementById('eventName').value = info.event.title;
                document.getElementById('eventDate').value = info.event.start.toLocaleDateString();
                document.getElementById('eventDescription').value = info.event.extendedProps.description || 'Aucune description disponible';
                
                var eventLocation = info.event.extendedProps.adresse || 'Non spécifiée';
                document.getElementById('eventAddress').value = eventLocation;

                // Générer le lien Google Maps sans API Key
                var googleMapUrl = 'https://www.google.com/maps?q=' + encodeURIComponent(eventLocation) + '&output=embed';
                document.getElementById('googleMapFrame').src = googleMapUrl;

                var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                eventModal.show();
            },
            selectable: true,
            editable: true,
        });
        calendar.render();
    }
});
</script>
@endsection
