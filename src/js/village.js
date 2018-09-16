import $ from 'jquery';
import axios from 'axios';

axios.defaults.baseURL = '/plemiona/api';

window.$ = $;
window.axios = axios;

import Village from './components/Village';

window.intervals = [];
window.village = new Village();