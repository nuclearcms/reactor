<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="has-text-centered mb-lg">
			<p class="is-size-4">{{ store.user.full_name }}</p>
		</div>

		<tabs class="is-marginless" :tabs="[
			{route: 'profile.edit', label: 'auth::users.profile', active: false},
			{route: 'profile.password', label: 'validation.attributes.password', active: false},
			{route: 'profile.chronicle', label: 'auth::users.activity', active: true}
		]"></tabs>

		<div class="paper pt-lg pb-lg">
			<ActivityFeed :loadurl="'profile/chronicle'"/>
		</div>
	</div>
</template>

<script>
import {View, Tabs} from 'umomega-foundation'
import ActivityFeed from '../../components/ActivityFeed'

export default {
	mixins: [ View ],
	components: { Tabs, ActivityFeed },
	data() { return {
		titleLabel: 'auth::users.activity'
	}},
	mounted() {
		const self = this

		setTimeout(function() {
			self.isLoaded = true
		})
	}
};
</script>