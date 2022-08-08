require('./bootstrap')

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import { createApp } from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StockRoom from './pages/StockRoom'

const app = createApp({})

app.component('stock-room', StockRoom)
app.use(VueAxios, axios)
app.mount('#app')