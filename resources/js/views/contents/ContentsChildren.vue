<template>
	<div :class="isLoaded ? 'reveal is-loaded' : 'reveal'">
		
		<ContentsTitle :resource="resource" :contentTitle="contentTitle" :contentTypeName="contentTypeName" :contentTypeRoute="contentTypeRoute"/>

		<tabs class="is-marginless" :tabs="[
			{route: 'contents.children', label: 'hierarchy::contents.children', active: true},
			{route: 'contents.edit', label: 'hierarchy::contents.single', active: false},
			{route: 'contents.settings', label: 'hierarchy::contents.settings', active: false},
			{route: 'contents.statistics', label: 'hierarchy::contents.statistics', active: false},
		]"></tabs>

		<div class="paper">
			<ContentsHeader :permission="$can('write_contents')" :resource="resource" :editingLocale="editingLocale" :errors="{erroredLocales: []}" :canHaveMoreTranslations="canHaveMoreTranslations" :canDeleteCurrentTranslation="false" :contentId="contentId"/>

			<ContentsDatable v-if="resource.children_display_mode == 'list'" :route="'contents.children'" :indexloadroute="'contents/' + $route.params.id + '/children'" :hidestoolbar="true" :editingLocale="editingLocale" :inverted="false"/>
			<div v-else class="paper__body paper__body--noside">
				<div class="paper__main">
					<div class="contents-tree-outer contents-tree-outer--large mt-none">
						<ContentsTree :contents="contents" :editingLocale="editingLocale" :can="$can('write_permissions')" :locked="resource.is_locked" :parentId="contentId" :showsthumbnails="true"/>
					</div>
				</div>
			</div>

			<div class="paper__footer" v-if="!resource.is_locked">
				<div class="field has-addons is-pulled-right">
					<div class="control">
						<router-link :to="{name: 'contents.create', params: {parent: resource.id}}" class="button icon-only-wide is-primary" type="button">
							<i class="icon fas fa-plus"></i>
						</router-link>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import {Tabs, RequiresPermissions, Translatable} from 'umomega-foundation'
import ContentsTitle from '../../partials/ContentsTitle'
import ContentsHeader from '../../partials/ContentsHeader'
import ContentsDatable from '../../partials/ContentsDatable'
import ContentsTree from '../../partials/ContentsTree'
import ContentsEditHelper from '../../mixins/ContentsEditHelper'

export default {
	mixins: [ RequiresPermissions, Translatable, ContentsEditHelper ],
	components: { Tabs, ContentsHeader, ContentsTitle, ContentsDatable, ContentsTree },
	data() { return {
		titleLabel: 'hierarchy::contents.children',
		hasOptions: true,
		breadcrumbs: [
			{to: { name: 'contents.index'}, text: this.$root.trans.get('hierarchy::contents.multiple')}
		],
		guardedBy: 'read_contents',
		contents: []
	}},
	mounted() {
		const self = this

		if(self.resource.children_display_mode && self.resource.children_display_mode == 'tree') {
			self.load()

			Event.$on('content-tree-modified', function() {
				self.load()
			})
		} else {
			Event.$off('resource-loaded')
			Event.$on('resource-loaded', function(resource) {
				if(resource.children_display_mode != 'tree') return

				self.load()

				Event.$on('content-tree-modified', function() {
					self.load()
				})
			})
		}
	},
	beforeDestroy() {
		Event.$off('resource-loaded')
	},
	methods: {
		load() {
			const self = this

			axios.get(api_url_with_token('contents/' + self.$route.params.id + '/children'))
				.then(function(response) {
					self.contents = response.data
				})
				.catch(function(error) { assess_error(error) })
		}
	},
	watch: {
		$route(to, from) {
			if(from.params.id != to.params.id) this.loadResource()
		}
	},
}
</script>