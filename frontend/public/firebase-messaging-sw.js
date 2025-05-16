importScripts('https://www.gstatic.com/firebasejs/9.21.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.21.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyCDVMdN13iUKp1pqoz5KRUYNYTNE8np3aw",
    authDomain: "diplomaproj-8c680.firebaseapp.com",
    projectId: "diplomaproj-8c680",
    storageBucket: "diplomaproj-8c680.firebasestorage.app",
    messagingSenderId: "141727866261",
    appId: "1:141727866261:web:f789eedcac2c534cbd2a9c",
    measurementId: "G-B32MYXT980"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/firebase-logo.png' // Optional
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
