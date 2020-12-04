<template>
	<div class="paper__main charts-outer">
		<div class="has-text-centered mb-md">
			<div class="mb-md">
				<a href="#" v-for="key in keys" :class="(key == viewing ? 'pill is-active is-uppercase' : 'pill is-uppercase')" v-text="trans.get('reactor::general.per_' + key)" @click.prevent="tab = key"></a>
			</div>
			<p class="is-size-8 is-uppercase has-text-weight-medium"><span class="has-text-weight-bold" v-text="trans.get('reactor::general.total_views') +':'"></span> {{ data.total_views }} _ <span class="has-text-weight-bold" v-text="trans.get('reactor::general.views_today') +':'"></span> {{ data.views_today }} _ <span class="has-text-weight-bold" v-text="trans.get('reactor::general.latest_view') +':'"></span> {{ data.latest_view }}</p>
		</div>

		<div class="charts">
			<div v-for="key in keys" :class="key == viewing ? 'chart' : 'chart--hidden'">
				<Chart :chartkey="key" :labels="data.labels[key]" :data="data.data[key]"/>
			</div>
		</div>
	</div>
</template>

<script>
import Chart from './Chart'

export default {
	props: ['data'],
	components: { Chart },
	data() { return {
		tab: null,
	}},
	computed: {
		keys() {
			return this.data.labels ? Object.keys(this.data.labels) : []
		},
		viewing() {
			return (this.keys.length > 0 && this.tab == null) ? this.keys[0] : this.tab
		}
	}
}
</script>