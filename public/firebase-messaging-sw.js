importScripts('https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.10.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
  //  apiKey: "AIzaSyBeUfNpOFN9ZyUvpZqzGBhzRjTnZY6A_DA",
    'messagingSenderId': '469444076609'
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here

    var notification = {
        order_id : payload.data.order_id ,
        title : payload.data.title ,
        sub_title : payload.data.sub_title ,
        human_date : payload.data.human_date ,
        read_at : payload.data.read_at ,
        url :payload.data.url ,
    };

    const notificationTitle = notification.title;
    const notificationOptions = {
        body: notification.sub_title,
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);

});

self.addEventListener('notificationclick', function(event) {
    const urlToOpen = new URL("/admin/orders", self.location.origin).href;
    return clients.openWindow(urlToOpen);
    
    const promiseChain = clients.matchAll({
        type: 'window',
        includeUncontrolled: true
    }).then((windowClients) => {
        let matchingClient = null;

    for (let i = 0; i < windowClients.length; i++) {
        const windowClient = windowClients[i];
        if (windowClient.url === urlToOpen) {
            matchingClient = windowClient;
            break;
        }
    }

    if (matchingClient) {
        return matchingClient.focus();
    } else {
        return clients.openWindow(urlToOpen);
    }
});

    event.waitUntil(promiseChain);
});


/*************************/
