<template>
	<canvas height="320" :id="'chart_' + chartkey"></canvas>
</template>

<script>
import Chart from 'chart.js'

Chart.defaults.global.responsive = true
Chart.defaults.global.maintainAspectRatio = false
Chart.defaults.global.defaultFontFamily = '"Manrope", sans-serif'
Chart.defaults.global.defaultFontColor = '#FFFFFF'
Chart.defaults.global.tooltips.backgroundColor = 'rgba(0,27,117,0.85)'
Chart.defaults.global.legend.position = 'bottom'
Chart.defaults.global.legend.labels.boxWidth = 16
Chart.defaults.global.legend.labels.padding = 32
Chart.defaults.global.legend.labels.usePointStyle = true
Chart.defaults.global.legend.labels.fontSize = 10

export default {
	props: ['chartkey', 'labels', 'data'],
	data() { return {
		canvas: null,
		chart: null
	}},
	mounted() {
		this.canvas = document.getElementById('chart_' + this.chartkey).getContext('2d')
		this.chart = new Chart(this.canvas, this.getConfiguration())
	},
	methods: {
		getConfiguration() {
			var configuration = {
				type: 'line',
				data: {
					labels: this.labels,
					datasets: [],
				},
		        options: {scales: {yAxes: [{ticks: {beginAtZero: true}, gridLines: {color: 'transparent'}}]}}
			}

			for(const [label, data] of Object.entries(this.data)) {
				configuration.data.datasets.push({
					label: label.toUpperCase(),
					data: data,
					borderColor: '#FFFFFF',
					fill: 'start',
					pointRadius: 6,
					pointHoverRadius: 8,
					pointBackgroundColor: "#FFFFFF",
					pointHoverBackgroundColor: "#FFFFFF",
					pointBorderColor: "rgba(255,255,255,0.5)",
					pointBorderWidth: 4
				})
			}

			return configuration
		}
	}
}
</script>