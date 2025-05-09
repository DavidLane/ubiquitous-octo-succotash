<template>
    <div class="p-4 max-w-md mx-auto">
      <h2 class="text-xl font-bold mb-4">Payroll Date Calculator</h2>
  
      <form @submit.prevent="fetchPayrollDates" class="space-y-3">
        <div>
          <label for="year" class="block text-sm font-medium">Year</label>
          <input
            type="number"
            id="year"
            v-model="year"
            class="w-full border rounded p-2"
            required
          />
        </div>
  
        <div>
          <label for="month" class="block text-sm font-medium">Month</label>
          <input
            type="number"
            id="month"
            v-model="month"
            min="1"
            max="12"
            class="w-full border rounded p-2"
            required
          />
        </div>
  
        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          :disabled="loading"
        >
          {{ loading ? "Calculating..." : "Calculate Payday" }}
        </button>
      </form>
  
      <div v-if="error" class="text-red-600 mt-4">{{ error }}</div>
  
      <div v-if="payrollDates" class="mt-4">
        <p><strong>Employee Pay Date:</strong> {{ payrollDates['employee_pay_date'] }}</p>
        <p><strong>Employer Payment Date:</strong> {{ payrollDates['employer_payment_date'] }}</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  
  const year = ref(new Date().getFullYear())
  const month = ref(new Date().getMonth() + 1)
  const loading = ref(false)
  const error = ref('')
  const payrollDates = ref(null)
  
  const fetchPayrollDates = async () => {
    loading.value = true
    error.value = ''
    payrollDates.value = null

    try {
      const response = await axios.post('/api/payday/calculate', {
        year: year.value,
        month: month.value
      }, {
        headers: {
          'Accept': 'application/json'
        }
      })

      payrollDates.value = response.data
    } catch (err) {
      if (err.response && err.response.status === 422) {
        error.value = err.response.data.message
      } else {
        error.value = err.message || 'Something went wrong'
      }
    } finally {
      loading.value = false
    }
  }
  </script>
  