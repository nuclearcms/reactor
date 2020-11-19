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
			<Datable
				:defaultkey="'created_at'" :defaultdir="'desc'"
				:route="'contenttypes.contents'"
				:sortables="[
					{key: 'title', label:'validation.attributes.title'},
					{key: 'type', label:'validation.attributes.type', skip: true},
					{key: 'published_at', label:'validation.attributes.published_at'},
					{key: 'created_at', label:'validation.attributes.created_at'}
				]"
				:indexloadroute="'contenttypes/' + $route.params.id + '/contents'"
				:canwrite="$can('write_contents')"
				:hidestoolbar="true"
			>
				<template v-slot:table-row-thumb="slotProps">
					<div class="datable-row-thumb">
						IMG
					</div>
				</template>

				<template v-slot:default="slotProps">
					<td><router-link :to="{ name: (slotProps.row.hides_children || slotProps.row.content_type.hides_children ? 'contents.children' : 'contents.edit'), params: {id: slotProps.row.id} }" v-text="slotProps.row.title[$root.appLocale]" /></td>
					<td><router-link class="is-size-7" v-if="$can('read_contenttypes')" :to="{ name: 'contenttypes.edit', params: { id: slotProps.row.content_type_id }}" v-text="slotProps.row.content_type.name"/><span class="is-size-7 has-text-grey-darker" v-else v-text="slotProps.row.content_type.name"></span></td>
					<td><span class="is-size-7" v-text="makeReadableDate(slotProps.row.published_at)"></span></td>
					<td><span class="is-size-7" v-text="makeReadableDate(slotProps.row.created_at)"></span></td>
					<td class="datable-row-options">
						<ContentsDropdown :can="$can('write_contents')" :content="slotProps.row"/>
					</td>
				</template>
			</Datable>
		</div>
	</div>
</template>

<script>
import {View, Shower, Tabs, Datable, format_date, RequiresPermissions, assess_error} from 'umomega-foundation'
import ContentsDropdown from '../../partials/ContentsDropdown'

export default {
	mixins: [ View, Shower, RequiresPermissions ],
	components: { Datable, Tabs, ContentsDropdown },
	data() { return {
		titleLabel: 'hierarchy::contents.multiple',
		breadcrumbs: [
			{to: { name: 'contenttypes.index'}, text: this.$root.trans.get('hierarchy::contenttypes.multiple')}
		],
		showRoute: 'contenttypes',
		guardedBy: 'read_contenttypes'
	}},
	methods: {
		makeReadableDate(date) {
			return format_date(date);
		}
	}
}
</script>