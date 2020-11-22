<template>
	<ContentsDatable :route="'contents.index'" :createroutename="'contents.create'" :createicon="'plus'" :indexloadroute="'contents'" :searchloadroute="'contents/search'" :bulkdeleteroute="'contents/bulk'" :alllabel="'hierarchy::contents.all'" :hidestoolbar="false" :filterable="true" :filters="[
			{value: 'unpublished', label: trans.get('hierarchy::contents.s_unpublished')},
			{value: 'locked', label: trans.get('hierarchy::contents.s_locked')},
			{value: 'invisible', label: trans.get('hierarchy::contents.s_invisible')},
			{value: 'draft', label: trans.get('hierarchy::contents.s_draft')},
			{value: 'archived', label: trans.get('hierarchy::contents.s_archived')},
			{value: 'published', label: trans.get('hierarchy::contents.s_published')}
		]"
	/>
</template>

<script>
import {View} from 'umomega-foundation'
import ContentsDatable from '../../partials/ContentsDatable'

export default {
	mixins: [ View ],
	components: { ContentsDatable },
	data() { return {
		titleLabel: 'hierarchy::contents.manage',
		guardedBy: 'read_contents'
	}}
}
</script>