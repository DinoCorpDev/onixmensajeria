import firebase from 'firebase/compat/app';
import 'firebase/compat/auth';
import 'firebase/compat/firestore';

const config= {
    apiKey: "AIzaSyDqqjmXP9GB4p0oo3RZQ81b80O8FRvsB68",
    authDomain: "testuploadimages-6c250.firebaseapp.com",
    projectId: "testuploadimages-6c250",
    storageBucket: "testuploadimages-6c250.appspot.com",
    messagingSenderId: "348891363162",
    appId: "1:348891363162:web:65931ff4d096cba7d36563"
};

firebase.initializeApp(config);