import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";
import { getAuth, GoogleAuthProvider, signInWithPopup } from 'firebase/auth';

const firebaseConfig = {
    apiKey: "AIzaSyCDVMdN13iUKp1pqoz5KRUYNYTNE8np3aw",
    authDomain: "diplomaproj-8c680.firebaseapp.com",
    projectId: "diplomaproj-8c680",
    storageBucket: "diplomaproj-8c680.firebasestorage.app",
    messagingSenderId: "141727866261",
    appId: "1:141727866261:web:f789eedcac2c534cbd2a9c",
    measurementId: "G-B32MYXT980"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const provider = new GoogleAuthProvider();
const messaging = getMessaging(app);

export { messaging, getToken, onMessage, auth, provider, signInWithPopup };
