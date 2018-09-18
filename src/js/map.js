import $ from 'jquery';
import axios from 'axios';

axios.defaults.baseURL = '/plemiona/api';

window.$ = $;
window.axios = axios;

import Expedition from './components/Expedition';

window.intervals = [];
window.expedition = new Expedition();
