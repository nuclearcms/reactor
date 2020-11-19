<template>
	<Datable
		:defaultkey="'created_at'" :defaultdir="'desc'"
		:route="'contents.index'"
		:sortables="[
			{key: 'title', label:'validation.attributes.title'},
			{key: 'type', label:'validation.attributes.type', skip: true},
			{key: 'published_at', label:'validation.attributes.published_at'},
			{key: 'created_at', label:'validation.attributes.created_at'}
		]"
		:createroutename="'contents.create'"
		:createicon="'plus'"
		:indexloadroute="'contents'"
		:searchloadroute="'contents/search'"
		:bulkdeleteroute="'contents/bulk'"
		:alllabel="'hierarchy::contents.all'"
		:canwrite="$can('write_contents')"
		:filterable="true"
		:filters="[
			{value: 'unpublished', label: trans.get('hierarchy::contents.s_unpublished')},
			{value: 'locked', label: trans.get('hierarchy::contents.s_locked')},
			{value: 'invisible', label: trans.get('hierarchy::contents.s_invisible')},
			{value: 'draft', label: trans.get('hierarchy::contents.s_draft')},
			{value: 'archived', label: trans.get('hierarchy::contents.s_archived')},
			{value: 'published', label: trans.get('hierarchy::contents.s_published')}
		]"
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
</template>

<script>
import {View, Datable, format_date, RequiresPermissions} from 'umomega-foundation'
import ContentsDropdown from '../../partials/ContentsDropdown'

export default {
	mixins: [ View, RequiresPermissions ],
	components: { Datable, ContentsDropdown },
	data() { return {
		titleLabel: 'hierarchy::contents.manage',
		guardedBy: 'read_contents'
	}},
	methods: {
		makeReadableDate(date) {
			return format_date(date);
		}
	}
}
</script>