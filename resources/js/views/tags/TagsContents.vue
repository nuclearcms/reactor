<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		<div class="has-text-centered mb-lg">
			<p class="is-size-4" v-text="tagName"></p>
			<p class="is-size-8 has-color-grey-darker" v-text="tagSlug"></p>
		</div>

		<tabs class="is-marginless" :tabs="[
			{route: 'tags.edit', label: 'tags::tags.single', active: false},
			{route: 'tags.contents', label: 'hierarchy::contents.multiple', active: true}
		]"></tabs>

		<div class="paper">
			<ContentsDatable :route="'tags.contents'" :indexloadroute="'tags/' + $route.params.id + '/contents'" :hidestoolbar="true"/>
		</div>
	</div>
</template>

<script>
import {View, Shower, Tabs} from 'umomega-foundation'
import {ContentsDatable} from 'nuclear-hierarchy-ui'
import {TagsEditHelper} from 'umomega-tags'

export default {
	mixins: [ View, Shower, TagsEditHelper ],
	components: { Tabs, ContentsDatable },
	data() { return {
		titleLabel: 'hierarchy::contents.multiple',
		breadcrumbs: [
			{to: { name: 'tags.index'}, text: this.$root.trans.get('tags::tags.multiple')}
		],
		showRoute: 'tags',
		guardedBy: 'read_tags'
	}}
}
</script>