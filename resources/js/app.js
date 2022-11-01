require('./bootstrap');

import {createApp} from 'vue'
import App from './App.vue'
import router from '../router'
import axios from 'axios'
import 'jquery/src/jquery.js'
import "bootstrap/dist/js/bootstrap.js"
import "bootstrap/dist/css/bootstrap.min.css"
window.$ = window.jQuery = require('jquery')
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faThumbsUp, faThumbsDown, faHeart } from '@fortawesome/free-solid-svg-icons'
library.add(faThumbsUp, faThumbsDown, faHeart)

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.config.globalProperties.$router = router
app.use(router)
.component('font-awesome-icon', FontAwesomeIcon)
.mount('#app')