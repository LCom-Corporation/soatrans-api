import './bootstrap';

window.Echo.private('setPlace.1')
    .subscribe('.placing', (e) => {
        console.log("test");
    })
    .listen('SetPlaceEvent', (e) => {
        console.log(e);
});