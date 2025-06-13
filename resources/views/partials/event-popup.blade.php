<div class="map-popup">
    <h3>{{ $event->name }}</h3>
    <p>{{ Str::limit($event->description, 40) }}</p>
    <p><strong>Venue:</strong> {{ $event->venue->venue_name ?? 'N/A' }}</p>
    <a href="{{ route('event.show', $event->id) }}" target="_blank">View Details</a>
</div>