<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="has-text-centered mb-lg">
			<p class="is-size-4">{{ resource.name }}</p>
		</div>

		<tabs class="is-marginless" :tabs="[
			{route: 'contenttypes.edit', label: 'hierarchy::contenttypes.single', active: false},
			{route: 'contenttypes.fields', label: 'hierarchy::contentfields.multiple', active: false},
			{route: 'contenttypes.contents', label: 'hierarchy::contents.multiple', active: true}
		]"></tabs>

		<div class="paper">
			<ContentsDatable :route="'contenttypes.contents'" :indexloadroute="'contenttypes/' + $route.params.id + '/contents'" :hidestoolbar="true"/>
		</div>
	</div>
</template>

<script>
import {View, Shower, Tabs} from 'umomega-foundation'
import ContentsDatable from '../../partials/ContentsDatable'

export default {
	mixins: [ View, Shower ],
	components: { Tabs, ContentsDatable },
	data() { return {
		titleLabel: 'hierarchy::contents.multiple',
		breadcrumbs: [
			{to: { name: 'contenttypes.index'}, text: this.$root.trans.get('hierarchy::contenttypes.multiple')}
		],
		showRoute: 'contenttypes',
		guardedBy: 'read_contenttypes'
	}}
}
</script>