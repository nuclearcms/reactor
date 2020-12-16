<template>
	<div>
		<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
			
			<ContentsTitle :resource="resource" :contentTitle="contentTitle" :contentTypeName="contentTypeName" :contentTypeRoute="contentTypeRoute"/>

			<tabs class="is-marginless" :tabs="tabs"></tabs>

			<div class="paper has-background-primary has-color-white">
				<StatisticsChart :data="views" />
			</div>
		</div>
	</div>
</template>

<script>
import {Tabs, RequiresPermissions, assess_error} from 'umomega-foundation'
import {ContentsTitle, ContentsEditHelper} from 'nuclear-hierarchy-ui'
import StatisticsChart from '../../components/StatisticsChart'

export default {
	mixins: [ RequiresPermissions, ContentsEditHelper ],
	components: { Tabs, ContentsTitle, StatisticsChart },
	data() { return {
		titleLabel: 'hierarchy::contents.statistics',
		hasOptions: true,
		breadcrumbs: [
			{to: { name: 'contents.index'}, text: this.$root.trans.get('hierarchy::contents.multiple')}
		],
		guardedBy: 'read_contents',
		tabs: [
			{route: 'contents.edit', label: 'hierarchy::contents.single', active: false},
			{route: 'contents.settings', label: 'hierarchy::contents.settings', active: false},
			{route: 'contents.statistics', label: 'hierarchy::contents.statistics', active: true},
		],
		views: []
	}},
	mounted() {
		const self = this

		Event.$on('resource-loaded', function(data) {
			if((data.content_type.hides_children || data.hides_children) && self.tabs.length == 3) {
				self.tabs.unshift({ route: 'contents.children', label: 'hierarchy::contents.children', active: false})
			} else if(self.tabs.length > 3) {
				self.tabs.shift()
			}
		})

		axios.get(api_url_with_token('contents/' + self.$route.params.id + '/statistics'))
			.then(function(response) {
				self.views = response.data.views
			})
			.catch(function(error) { assess_error(error) })
	},
	beforeDestroy() {
		Event.$off('resource-loaded')
	}
}
</script>