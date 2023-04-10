// Import Firebase
import { initializeApp } from "firebase/app";

// Firebase configuration
const firebaseConfig = {
    apiKey: process.env.MIX_FIREBASE_API_KEY,
    authDomain: process.env.MIX_FIREBASE_AUTH_DOMAIN,
    databaseURL: process.env.MIX_FIREBASE_DATABASE_URL,
    projectId: process.env.MIX_FIREBASE_PROJECT_ID,
    storageBucket: process.env.MIX_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: process.env.MIX_FIREBASE_MESSAGING_SENDER_ID,
    appId: process.env.MIX_FIREBASE_APP_ID,
    measurementId: process.env.MIX_FIREBASE_MEASUREMENT_ID,
};

// Initialize Firebase
const firebaseApp = initializeApp(firebaseConfig);

export default firebaseApp;
