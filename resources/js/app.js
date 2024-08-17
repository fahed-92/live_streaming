import './bootstrap';
import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Alpine = Alpine;
Alpine.start();

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
});

console.log('Echo instance created');
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('Pusher connected');
});

let localStream;
const peers = {};
const roomId = document.querySelector('meta[name="room-id"]').content;

// WebRTC configuration
const config = {
    iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
};

async function setupWebRTC() {
    // try {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        const localVideo = document.getElementById('local-video');
        localVideo.srcObject = localStream;

        window.Echo.channel(`room.${roomId}`)
            .listen('WebRTCSignal', (event) => {
                handleSignal(event.data);
            })
            .listen('UserJoinedRoom', (event) => {
                addPeer(event.user.id);

            })
            .listen('UserLeftRoom', (event) => {
                removePeer(event.user.id);

            });

    // } catch (error) {
    //     console.error('Error accessing media devices.', error);
    // }
}

function addPeer(userId) {
    if (peers[userId]) return; // Prevent duplicate connections

    const peerConnection = new RTCPeerConnection(config);
    peers[userId] = peerConnection;

    peerConnection.onicecandidate = (event) => {
        if (event.candidate) {
            console.log('Sending ICE candidate:', event.candidate);
            sendSignal({ candidate: event.candidate, userId });
        }
        else if (data.candidate) {
            console.log('Adding ICE candidate:', data.candidate);
            peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate))
                .catch(error => console.error('Error adding ICE candidate:', error));
        }
    };

    peerConnection.ontrack = (event) => {
        let remoteVideo = document.getElementById(`remote-video-${userId}`);
        if (!remoteVideo) {
            remoteVideo = document.createElement('video');
            remoteVideo.id = `remote-video-${userId}`;
            remoteVideo.autoplay = true;
            remoteVideo.classList.add('video-box');
            document.getElementById('remote-video').appendChild(remoteVideo);
        }
        remoteVideo.srcObject = event.streams[0];
    };

    localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

    // Inform the server about the new peer
    fetch(`/room/${roomId}/new-peer`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ userId })
    });

}

function removePeer(userId) {
    if (peers[userId]) {
        peers[userId].close();
        delete peers[userId];
        const remoteVideo = document.getElementById(`remote-video-${userId}`);
        if (remoteVideo) {
            remoteVideo.remove();
        }
    }
}

function handleSignal(data) {
    const { userId } = data;
    const peerConnection = peers[userId];

    if (data.offer) {
        peerConnection.setRemoteDescription(new RTCSessionDescription(data.offer))
            .then(() => peerConnection.createAnswer())
            .then(answer => peerConnection.setLocalDescription(answer))
            .then(() => sendSignal({ answer: peerConnection.localDescription, userId }));
    } else if (data.answer) {
        peerConnection.setRemoteDescription(new RTCSessionDescription(data.answer));
    } else if (data.candidate) {
        peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
    }
}

function sendSignal(data) {
    console.log('Sending signal:', data);
    fetch(`/room/${roomId}/signal`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(data),
    });
}

setupWebRTC();

// document.getElementById('mute-button').addEventListener('click', () => {
//     const audioTracks = localStream.getAudioTracks();
//     audioTracks.forEach(track => track.enabled = !track.enabled);
// });

document.addEventListener('livewire:load', function () {
    window.Echo.channel(`room.${roomId}`)
        .listen('RaiseHandRequested', (event) => {
            Livewire.emit('handRaised');
        })
        .listen('HandResponse', (event) => {
            Livewire.emit('handRaised');
        });
});

window.Echo.channel('chat')
    .listen('App\\\\Events\\\\MessageSent', (event) => {
        console.log('New message received:', event.message);
    });
