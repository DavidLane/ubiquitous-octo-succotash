import './bootstrap';
import { createApp } from 'vue'
import PayrollCalculator from './Components/PayrollCalculator.vue'

const app = createApp({})
app.component('PayrollCalculator', PayrollCalculator)
app.mount('#app')