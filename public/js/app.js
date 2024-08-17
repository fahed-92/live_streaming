// import './bootstrap';
//
// import Alpine from 'alpinejs';
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
// import { fabric } from 'fabric';
//
//
// window.Alpine = Alpine;
//
// Alpine.start();
//
// window.Pusher = Pusher;
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
//
// let localStream;
// let peerConnection;
// const roomId = document.querySelector('meta[name="room-id"]').content;
//
// // WebRTC configuration
// const config = {
//     iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
// };
//
// async function setupWebRTC() {
//     peerConnection = new RTCPeerConnection(config);
//
//     peerConnection.onicecandidate = (event) => {
//         if (event.candidate) {
//             sendSignal({ candidate: event.candidate });
//         }
//     };
//
//     peerConnection.ontrack = (event) => {
//         const remoteVideo = document.getElementById('remote-video');
//         remoteVideo.srcObject = event.streams[0];
//     };
//
//     try {
//         localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
//         const localVideo = document.getElementById('local-video');
//         localVideo.srcObject = localStream;
//         localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));
//     } catch (error) {
//         console.error('Error accessing media devices.', error);
//     }
//
//     // Listen for signaling data
//     window.Echo.channel(`room.${roomId}`)
//         .listen('WebRTCSignal', (event) => {
//             handleSignal(event.data);
//         });
// }
//
// function handleSignal(data) {
//     if (data.offer) {
//         peerConnection.setRemoteDescription(new RTCSessionDescription(data.offer))
//             .then(() => peerConnection.createAnswer())
//             .then(answer => peerConnection.setLocalDescription(answer))
//             .then(() => sendSignal({ answer: peerConnection.localDescription }));
//     } else if (data.answer) {
//         peerConnection.setRemoteDescription(new RTCSessionDescription(data.answer));
//     } else if (data.candidate) {
//         peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
//     }
// }
//
// function sendSignal(data) {
//     fetch(`/room/${roomId}/signal`, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//         },
//         body: JSON.stringify(data),
//     });
// }
//
// // Initialize WebRTC
// setupWebRTC();
//
// // Mute/Unmute button logic
// document.getElementById('mute-button').addEventListener('click', () => {
//     const audioTracks = localStream.getAudioTracks();
//     audioTracks.forEach(track => track.enabled = !track.enabled);
// });
//
// // Raise Hand button logic
// document.getElementById('raise-hand-button').addEventListener('click', () => {
//     sendSignal({ raiseHand: true });
// });
// // document.addEventListener('DOMContentLoaded', function() {
// //     if (window.fabric) {
// //         var canvas = new fabric.Canvas('whiteboard-container');
// //     } else {
// //         console.error('Fabric.js is not loaded');
// //     }
// // });
