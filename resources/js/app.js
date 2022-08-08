require('./bootstrap')

import { createApp } from 'vue'
import StockRoom from './components/StockRoom'

const app = createApp({})

app.component('stock-room', StockRoom)

app.mount('#app')