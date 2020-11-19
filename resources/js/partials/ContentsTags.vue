<template>
	<RelationField :value="value" :errors="errors" :hint="readonly ? '' : trans.get('hierarchy::contents.tags_hint')" :readonly="readonly" :name="'tags'" :label="undefined" :placeholder="trans.get('hierarchy::contents.tags_search')" :options="{multiple: true, searchroute: 'tags/search', translated: true, wrapper: 'contents-tags', tag: 'div', class: 'field is-grouped is-grouped-multiline', invokeEnter: function(vm, axios, api_url_with_token, assess_error) {
			axios.post(api_url_with_token('tags'), { name: vm.searchTerm, type: '' })
			.then(function(response) { vm.add(response.data.payload) })
			.catch(function(error) { assess_error(error) })
	 	}}">
		<template v-slot:message="p">
			<p class="pb-md" v-if="p.related.length == 0" v-text="trans.get('hierarchy::contents.no_tags')"></p>
		</template>

		<template v-slot:draggable="p">
			<div class="control" v-for="(tag, i) in p.related" :key="tag.id">
				<div class="tags has-addons">
					<router-link class="tag is-primary has-text-weight-bold is-size-8" :to="{name: 'tags.edit', params: {id: tag.id}}" v-text="tag.name[$root.appLocale]"/>
					<a href="#" class="tag is-primary-dark has-color-white" @click.prevent="p.remove(i)">
						<i class="icon fas fa-times"></i>
					</a>
				</div>
			</div>
		</template>

		<template v-slot:readonly="p">
			<div class="field is-grouped is-grouped-multiline" v-if="p.readonly">
				<div class="control" v-for="(tag, i) in p.related" :key="tag.id">
					<div class="tags has-addons">
						<router-link class="tag is-primary has-text-weight-bold" :to="{name: 'tags.edit', params: {id: tag.id}}" v-text="tag.name[$root.appLocale]"/>
					</div>
				</div>
			</div>
		</template>
	</RelationField>
</template>

<script>
import {RelationField} from 'umomega-foundation'

export default {
	components: {RelationField},
	props: ['readonly', 'errors', 'value'],
	data() { return {
		related: this.value || []
	}}
}
</script>