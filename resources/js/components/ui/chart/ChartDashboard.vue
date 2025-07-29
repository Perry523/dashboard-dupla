<script setup lang="ts">
import { useDoughnutChart } from './index'
import DoughnutChart from './DoughnutChart.vue'

interface Props {
    insight: {
      finalizados: number,
      pendentes: number,
      expirados: number
    };
}

const props = withDefaults(defineProps<Props>(), {
  insight: undefined
});

// Sample data
const { chartData, total } = useDoughnutChart([
  { label: 'Finalizados', value: props.insight.finalizados, color: 'rgb(34, 197, 94)' },
  { label: 'Pendentes', value: props.insight.pendentes, color: 'rgb(59, 130, 246)' },
  { label: 'Expirados', value: props.insight.expirados, color: 'rgb(249, 115, 22)' }
])
const chartTitle = `Total Pixes: ${total.value} `


/* export default {
  name: 'ChartDashboard',
  components: {
    Doughnut,
  },
  setup() {
    // You can add any additional setup logic here if needed
  },
  data() {
    return {
      data,
    };
  },
}; */

</script>

<template>
  <div class="rounded-lg border bg-card p-40">
    <div class="mb-4">
      <h3 class="text-lg font-semibold">Insights: Geração de Pix</h3>
      
      <p class="text-sm text-muted-foreground">Médias sobre pixes criados</p>
    </div>
    
    <DoughnutChart 
      :data="chartData"
      :title="chartTitle"
    subtitle=''
      :show-legend="true"
      legend-position="right"
    />
  </div>
</template>

<!-- export default {
  name: 'ChartDashboard',
  template: template.innerHTML,
  mounted() {
    this.initChart();
  },
  methods: {
    initChart() {
      const ctx = document.getElementById('myCanvasId') as HTMLCanvasElement;
      console.log('Inner export context:', ctx);
      const configData = {
        datasets: [{
          data: [10, 20, 30]
        }],
        labels: ['Red', 'Yellow', 'Blue']
      };
      console.log('QUASE ');
      new Chart(ctx, {
        type: Doughnut,
        data: configData,
      });
    }
  }
}; -->