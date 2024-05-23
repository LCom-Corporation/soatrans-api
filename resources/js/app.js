import './bootstrap';

console.log('Hello World from app.js');
window.Echo.channel('setPlace.1')
    .subscribe('SetPlaceEvent', (e) => {
        console.log("event received");
    })
    .listen('SetPlaceEvent', (e) => {
        console.log(e);
});