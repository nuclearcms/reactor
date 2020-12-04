<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="has-text-centered mb-lg">
			<p class="is-size-4" v-text="trans.get('foundation::general.greeting', {name: store.user.first_name })"></p>
			<p class="is-size-8 has-color-grey-darker" v-text="trans.get('reactor::general.dashboard_description')"></p>
		</div>

		<tabs class="is-marginless" :tabs="[
			{route: 'dashboard.overview', label: 'reactor::general.dashboard', active: true},
			{route: 'dashboard.chronicle', label: 'auth::users.activity', active: false, show: 'read_chronicle'},
		]"></tabs>

		<div class="paper has-background-primary has-color-white">
			<StatisticsChart :data="views" />
		</div>

		<div class="dashboard-contents">
			<div class="dashboard-list" v-for="category in ['most_viewed', 'recently_viewed', 'recently_updated', 'recently_created']">
				<h3 class="dashboard-list__heading" v-text="trans.get('reactor::general.' + category)"></h3>
				<ul class="dashboard-list__list">
					<li class="dashboard-list__item" v-for="content in contents[category]">
						<router-link :to="{ name: (content.hides_children || content.content_type.hides_children ? 'contents.children' : 'contents.edit'), params: {id: content.id} }" v-text="content.title[editingLocale]" class="dashboard-list__link"/>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
import {View, Tabs, assess_error} from 'umomega-foundation'
import StatisticsChart from '../../components/StatisticsChart'

export default {
	mixins: [ View ],
	components: { Tabs, StatisticsChart },
	data() { return {
		titleLabel: 'reactor::general.dashboard',
		editingLocale: this.$root.appLocale,
		views: [],
		contents: {}
	}},
	mounted() {
		const self = this

		setTimeout(function() {
			self.isLoaded = true
		})

		axios.get(api_url_with_token('dashboard'))
			.then(function(response) {
				self.views = response.data.views
				self.contents = response.data.contents
			})
			.catch(function(error) { assess_error(error) })
	}
};
</script>