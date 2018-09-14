import $ from 'jquery';
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost/plemiona/api';

window.$ = $;
window.axios = axios;

import Village from './components/Village';

window.village = new Village();
