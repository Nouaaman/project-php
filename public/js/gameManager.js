//getting game id form url else redirect to home page
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let idGame = ''
if (urlParams.has('idGame')) {
    idGame =urlParams.get('idGame')
}
else{
    window.location = '/';
}


/* connect to server */
const conn = new WebSocket('ws://project-php:8282');


