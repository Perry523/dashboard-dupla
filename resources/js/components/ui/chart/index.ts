import { ref, computed, type Ref } from 'vue'
import type { ChartData } from 'chart.js'

export interface DoughnutDataItem {
  label: string
  value: number
  color: string
}

export function useDoughnutChart(initialData: DoughnutDataItem[] = []) {
  const data: Ref<DoughnutDataItem[]> = ref(initialData)

  const chartData = computed<ChartData<'doughnut'>>(() => ({
    labels: data.value.map(item => item.label),
    datasets: [{
      data: data.value.map(item => item.value),
      backgroundColor: data.value.map(item => item.color),
      borderColor: data.value.map(item => item.color),
      borderWidth: 2,
      hoverBorderWidth: 3,
      hoverOffset: 4
    }]
  }))

  const total = computed(() => 
    data.value.reduce((sum, item) => sum + item.value, 0)
  )

  const updateData = (newData: DoughnutDataItem[]) => {
    data.value = newData
  }

  const addItem = (item: DoughnutDataItem) => {
    data.value.push(item)
  }

  const removeItem = (index: number) => {
    data.value.splice(index, 1)
  }

  return {
    data,
    chartData,
    total,
    updateData,
    addItem,
    removeItem
  }
}