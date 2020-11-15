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
	</div>
</template>

<script>
import {View, Tabs} from 'umomega-foundation';

export default {
	mixins: [ View ],
	components: { Tabs },
	data() { return {
		titleLabel: 'reactor::general.dashboard'
	}},
	mounted() {
		const self = this

		setTimeout(function() {
			self.isLoaded = true
		})
	}
};
</script>