import './bootstrap';
import $ from 'jquery';
import toastr from 'toastr';
import '../../node_modules/bootstrap/dist/js/bootstrap.bundle.js'
import '../../node_modules/apexcharts/dist/apexcharts.js';

window.$ = $;
window.toastr = toastr;

window.database_url = `https://poultrygrowthtracker-default-rtdb.asia-southeast1.firebasedatabase.app/`;
window.token = 'AIzaSyDK-_ai-UnsI0AnsFCBC4SpR0r__GjW5e4';