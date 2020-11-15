<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="has-text-centered mb-lg">
			<p class="is-size-4">{{ resource.full_name }}</p>
		</div>
		
		<tabs class="is-marginless" :tabs="[
			{route: 'users.edit', label: 'auth::users.single', active: false},
			{route: 'users.password', label: 'validation.attributes.password', active: false, show: 'write_users'},
			{route: 'users.chronicle', label: 'auth::users.activity', active: true, show: 'read_chronicle'}
		]"></tabs>

		<div class="paper pt-lg pb-lg">
			<ActivityFeed :loadurl="'users/' + userId + '/chronicle'"/>
		</div>
	</div>
</template>

<script>
import {View, Tabs, Shower, RequiresPermissions} from 'umomega-foundation'
import ActivityFeed from '../../components/ActivityFeed'

export default {
	mixins: [ View, Shower, RequiresPermissions ],
	components: { Tabs, ActivityFeed },
	data() { return {
		titleLabel: 'auth::users.activity',
		breadcrumbs: [
			{to: { name: 'users.index'}, text: this.$root.trans.get('auth::users.multiple')}
		],
		guardedBy: 'read_chronicle',
		showRoute: 'users',
	}},
	computed: {
		userId() {
			return this.$route.params.id
		}
	}
};
</script>