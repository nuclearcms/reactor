<template>
	<div :class="isLoaded ? 'paper reveal is-loaded' : 'paper reveal'">
		<form method="POST" action="/api/contents" @submit.prevent="requestStoreDynamic()" autocomplete="off">
			
			<div class="paper__body paper__body--noside">
				<div class="paper__main">
					<FormBody :schema="schema" v-model="form" :readonly="false"/>
				</div>
			</div>

			<SubmitFooter :config="{icon: 'plus'}" v-model="form"></SubmitFooter>

		</form>
	</div>
</template>

<script>
import {View, Storer, FormBody, Form, SubmitFooter, RequiresPermissions, assess_error} from 'umomega-foundation'

export default {
	mixins: [ View, RequiresPermissions, Storer ],
	components: { FormBody, SubmitFooter },
	data() { return {
		titleLabel: 'hierarchy::contents.create',
		breadcrumbs: [
			{to: { name: 'contents.index'}, text: this.$root.trans.get('hierarchy::contents.multiple')}
		],
		guardedBy: 'write_contents',
		form: new Form({title: '', content_type_id: ''}),
		schema: [
			{
				type: 'TextField',
				name: 'title',
				label: this.$root.trans.get('validation.attributes.title'),
				options: {required: true}
			},
			{
				type: 'SelectField',
				name: 'content_type_id',
				label: this.$root.trans.get('validation.attributes.type'),
				options: {
					required: true,
					choices: []
				}
			}
		]
	}},
	mounted() {
		const self = this

		// This is to override Storer's rendering
		setTimeout(function() {
			self.isLoaded = false
		}, 2)

		var route = 'contents/precreate'
		if(self.$route.params.parent) route += '/' + self.$route.params.parent

		axios.get(api_url_with_token(route))
			.then(function(response) {
				self.isLoaded = true

				if(response.data.action == 'populate')
				{
					if(self.$route.params.parent) {
						self.breadcrumbs.push({to: { name: 'contents.edit', params: {id: self.$route.params.parent }}, text: response.data.parent.title[self.$root.appLocale] })
					}

					self.schema[1].options.choices = response.data.types.map(function(t) {
						return { value: t.id, label: t.name }
					})
				} else if(response.data.action == 'redirect')
				{
					self.notifier.danger(response.data.message)
					router.push({ name: 'contents.edit', params: { id: self.$route.params.parent } })
				}
			})
			.catch(function(error) { assess_error(error) })
	},
	methods: {
		requestStoreDynamic() {
			var route = 'contents'
			if(this.$route.params.parent) route += '/' + this.$route.params.parent

			this.requestStore(route, 'contents.edit')
		}
	}
};
</script>