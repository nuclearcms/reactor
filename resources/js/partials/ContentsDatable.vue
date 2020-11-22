<template>
	<Datable
		:defaultkey="'created_at'" :defaultdir="'desc'"
		:route="route"
		:sortables="[
			{key: 'title', label:'validation.attributes.title'},
			{key: 'type', label:'validation.attributes.type', skip: true},
			{key: 'published_at', label:'validation.attributes.published_at'},
			{key: 'created_at', label:'validation.attributes.created_at'}
		]"
		:indexloadroute="indexloadroute"
		:canwrite="$can('write_contents')"
		:hidestoolbar="hidestoolbar"
		:createroutename="createroutename"
		:createicon="createicon"
		:searchloadroute="searchloadroute"
		:bulkdeleteroute="bulkdeleteroute"
		:alllabel="alllabel"
		:filterable="filterable"
		:filters="filters"
	>
		<template v-slot:table-row-thumb="slotProps">
			<div class="datable-row-thumb" v-if="slotProps.row.cover_thumbnail != null">
				<img :src="slotProps.row.cover_thumbnail" class="datable-thumb">
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
import {Datable, format_date, RequiresPermissions} from 'umomega-foundation'
import ContentsDropdown from './ContentsDropdown'

export default {
	mixins: [RequiresPermissions],
	props: [
		'route', 'indexloadroute', 'hidestoolbar',
		'createroutename', 'createicon', 'searchloadroute', 'bulkdeleteroute', 'alllabel', 'filterable', 'filters'
	],
	components: { Datable, ContentsDropdown },
	methods: {
		makeReadableDate(date) {
			return format_date(date);
		}
	}
}
</script>