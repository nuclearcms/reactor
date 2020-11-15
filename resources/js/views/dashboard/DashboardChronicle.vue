<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="has-text-centered mb-lg">
			<p class="is-size-4" v-text="trans.get('foundation::general.greeting', {name: store.user.first_name })"></p>
			<p class="is-size-8 has-color-grey-darker" v-text="trans.get('reactor::general.dashboard_description')"></p>
		</div>

		<tabs class="is-marginless" :tabs="[
			{route: 'dashboard.overview', label: 'reactor::general.dashboard', active: false},
			{route: 'dashboard.chronicle', label: 'auth::users.activity', active: true},
		]"></tabs>

		<div class="paper pt-lg pb-lg">
			<ActivityFeed :loadurl="'dashboard/chronicle'"/>
		</div>
	</div>
</template>

<script>
import {View, Tabs, RequiresPermissions } from 'umomega-foundation'
import ActivityFeed from '../../components/ActivityFeed'

export default {
	mixins: [ View, RequiresPermissions ],
	components: { Tabs, ActivityFeed },
	data() { return {
		titleLabel: 'auth::users.activity',
		guardedBy: 'read_chronicle'
	}},
	mounted() {
		const self = this

		setTimeout(function() {
			self.isLoaded = true
		})
	}
};
</script>