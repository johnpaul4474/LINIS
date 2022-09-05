require('./bootstrap')

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import { createApp } from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StockRoom from './pages/StockRoom'
import SelectArea from './pages/SelectArea'

const app = createApp({})

app.component('stock-room', StockRoom)
app.component('select-area', SelectArea)
app.use(VueAxios, axios)
app.mount('#app')