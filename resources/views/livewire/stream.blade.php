<div>
    <style>
        .video-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .video-box {
            flex: 1;
            min-width: 200px;
            min-height: 150px;
            background-color: #000;
            position: relative;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <h2 class="text-lg font-semibold">Live Stream for {{ $room->name }}</h2>

    <div class="video-container" id="video-container">
        <div id="creator-video" class="video-box">
            <video id="local-video" autoplay></video>
        </div>

        @foreach ($attendees as $attendee)
            @if($attendee->user->id == \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier())
            @else
            <div id="remote-video-container-{{ $attendee->user->id }}" class="video-box">
                <video id="remote-video-{{ $attendee->user->id }}" autoplay></video>
            </div>
            @endif
        @endforeach
    </div>
</div>

{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function () {--}}
{{--        const attendees = @json($attendees);--}}
{{--        updateRemoteVideos(attendees);--}}
{{--    });--}}
{{--</script>--}}
