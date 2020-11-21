<template>
	<div class="has-text-centered mb-lg">
		<div v-if="resource.ancestors != undefined && resource.ancestors.length > 0" class="mb-xl">
			<p class="is-size-9 has-text-weight-bold has-color-grey-darker is-uppercase mb-xxs" v-text="trans.get('hierarchy::contents.ancestors')"></p>
			<div>
				<span v-for="(ancestor, index) in resource.ancestors" :key="index">
					<span v-if="index != 0">&nbsp;<i class="has-color-grey-light icon fas fa-long-arrow-alt-right"></i></span>
					<router-link :to="{ name: (ancestor.hides_children || ancestor.content_type.hides_children ? 'contents.children' : 'contents.edit'), params: {id: ancestor.id} }" v-text="ancestor.title[$root.appLocale]"></router-link>
				</span>
			</div>
		</div>

		<p class="is-size-4" v-text="contentTitle"></p>
		<p class="is-size-8 has-color-grey-darker">
			<router-link class="is-uppercase has-text-weight-bold" :to="contentTypeRoute" v-text="contentTypeName"></router-link>
		</p>
	</div>
</template>

<script>
export default {
	props: ['resource', 'contentTitle', 'contentTypeName', 'contentTypeRoute']
}
</script>