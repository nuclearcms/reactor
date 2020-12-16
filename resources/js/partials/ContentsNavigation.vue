<template>
	<nav class="contents-navigation">
		<h2 class="contents-navigation__flap is-uppercase"><span v-text="trans.get('reactor::general.contents')"></span></h2>
		<router-link v-if="$can('write_contents')" :to="{ name: 'contents.create' }" class="contents-navigation__new"><i class="icon fas fa-plus"></i></router-link>
		
		<div class="field">
			<div class="control has-icons-left">
				<input type="search" class="input" name="q" :placeholder="trans.get('foundation::general.search_for')" v-model="searchTerm" @keydown.enter.prevent="searchContents">
				<span class="icon is-small is-left">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>

		<div class="contents-navigation__locales">
			<a v-if="$root.appLocales.length > 1" v-for="locale in $root.appLocales" href="#" :class="'contents-navigation__locale' + (locale == editingLocale ? ' contents-navigation__locale--active' : '' )" @click.prevent="changeEditingLocale(locale)" v-text="locale"></a>
		</div>

		<div class="contents-tree-outer">
			<ContentsTree :contents="contents" :can="$can('write_contents')" :editingLocale="editingLocale" :locked="false" :parentId="null"/>
		</div>	
	</nav>
</template>

<script>
import {RequiresPermissions, assess_error} from 'umomega-foundation'
import {ContentsTree} from 'nuclear-hierarchy-ui'

export default {
	mixins: [ RequiresPermissions ],
	components: { ContentsTree },
	data() { return {
		editingLocale: this.$root.appLocale,
		contents: [],
		searchTerm: ''
	}},
	created() {
		const self = this

		self.load()

		Event.$on('content-tree-modified', function() {
			self.load()
		})
	},
	methods: {
		load() {
			const self = this

			axios.get(api_url_with_token('contents/roots'))
				.then(function(response) {
					self.contents = response.data
				})
				.catch(function(error) { assess_error(error) })
		},
		changeEditingLocale(locale) {
			this.editingLocale = locale
		},
		searchContents(value) {
			const q = this.searchTerm

			router.push({name: 'contents.index', query: {q: q}})

			Event.$emit('search-query-changed', q)

			this.searchTerm = ''
		}
	}
}
</script>