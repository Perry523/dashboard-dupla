<script setup lang="ts">
import { computed } from 'vue'
import { Chart as ChartJS, ArcElement, Tooltip, Legend, type ChartData, type ChartOptions } from 'chart.js'
import { Doughnut } from 'vue-chartjs'

ChartJS.register(ArcElement, Tooltip, Legend)

interface DoughnutChartProps {
  data: ChartData<'doughnut'>

  options?: ChartOptions<'doughnut'>
  title?: string
  subtitle?: string
  showLegend?: boolean
  legendPosition?: 'right'
  //legendPosition?: 'top' | 'bottom' | 'left' | 'right'
}

const props = withDefaults(defineProps<DoughnutChartProps>(), {
  showLegend: true,
  legendPosition: 'right',
  title: '',
  subtitle: ''
})

const chartOptions = computed<ChartOptions<'doughnut'>>(() => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: props.showLegend,
      position: props.legendPosition,
      labels: {
        usePointStyle: true,
        padding: 20,
        font: {
          family: 'Helvetica Neue',//'Instrument Sans, sans-serif',
          size: 14,
        }
      },
      title: {
        display: !!props.title,
        text: props.title,
        font: {
          family: 'Helvetica Neue',//'Instrument Sans, sans-serif',
          size: 16,
          weight: 'bold',
        },
        padding: {
          bottom: 10
        }
      }
    },
    tooltip: {
      backgroundColor: 'rgb(15, 23, 42)',
      titleColor: 'rgb(248, 250, 252)',
      bodyColor: 'rgb(248, 250, 252)',
      borderColor: 'rgb(51, 65, 85)',
      borderWidth: 1,
      cornerRadius: 8,
      displayColors: true,
      titleFont: {
        family: 'Instrument Sans, sans-serif',
        size: 14,
        weight: 'bold'
      },
      bodyFont: {
        family: 'Instrument Sans, sans-serif',
        size: 13
      },
      callbacks: {
        label: (context) => {
          const label = context.label || ''
          const value = context.parsed
          const total = context.dataset.data.reduce((a: number, b: number) => a + b, 0)
          const percentage = ((value / total) * 100).toFixed(1)
          return `${label}: ${value} (${percentage}%)`
        }
      }
    }
  },
  cutout: '60%',
  ...props.options
}))

</script>


<template>
  <div class="w-full">
    <div v-if="subtitle" class="mb-4 text-center">
      <p class="text-sm text-muted-foreground">{{ subtitle }}</p>
    </div>
    


    <div class="relative h-64 w-full">
      <Doughnut 
        :data="data" 
        :options="chartOptions"
        class="max-h-full max-w-full"
      />

    </div>
  </div>
</template>