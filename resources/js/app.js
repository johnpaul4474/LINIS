require('./bootstrap')

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import { createApp } from 'vue'
import StockRoom from './pages/StockRoom'

const app = createApp({})

app.component('stock-room', StockRoom)

app.mount('#app')